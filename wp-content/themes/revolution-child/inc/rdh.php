<?php
define('RDH_TITLES', array('RDH', 'LDH', 'RDHAP', 'EPDH', 'CRDH', 'RDHEF', 'PHDHP'));
define('CONFERENCE_ATTEND', array('Twice per year', 'Yearly', 'Quarterly', 'Rarely', 'Never'));
define('RDH_PRACTICE', array('Part-time', 'Full-time', 'Rarely', 'Not at all'));
define('RDH_BEHAVIOUR', array('I use an electric toothbrush', 'I grind my teeth', 'I own custom-fitted whitening trays', 'I use an electric water flosser', 'I have had braces or Invisalign in my lifetime', 'I regularly use Chapstick or healing lip balm', 'I have sensitive teeth'));
define('RDH_INTERESTS', array('CE credits', 'Brand Ambassador (earn commissions)', 'Published writing', 'New Career Opportunities', 'Professional development', 'Education & Public Speaking Engagements', 'Mentoring future dental professionals'));
function add_custom_constant_inline_chat_sbr()
{
    $inline_script = "
        <script type='text/javascript'>
            var CHAT_SBR_URL = '" . CHAT_SBR_URL . "';
        </script>
    ";

    echo $inline_script;
}

add_action('wp_footer', 'add_custom_constant_inline_chat_sbr');
add_action('admin_footer', 'add_custom_constant_inline_chat_sbr');
function clone_post_rdh($post_id, $new_page_title = '')
{
    $post = get_post($post_id);
    if (!$post) {
        return 0;
    }

    $new_post = array(
        'post_type' => $post->post_type,
        'post_status' => 'publish',
        'post_title' => $new_page_title,
        'post_content' => $post->post_content,
        'post_excerpt' => $post->post_excerpt,
        'post_author' => $post->post_author,
        'post_parent' => $post->post_parent,
        'menu_order' => $post->menu_order,
        'comment_status' => $post->comment_status,
        'ping_status' => $post->ping_status,
        'post_password' => $post->post_password,
        'post_date' => $post->post_date,
        'post_date_gmt' => $post->post_date_gmt,
        'post_modified' => $post->post_modified,
        'post_modified_gmt' => $post->post_modified_gmt
    );

    $new_post_id = wp_insert_post($new_post);


    if (!$new_post_id) {
        return 0;
    }

    $post_meta_data = get_post_meta($post_id);

    foreach ($post_meta_data as $key => $value) {
        update_post_meta($new_post_id, $key, maybe_unserialize($value[0]));
    }

    return $new_post_id;
}
function cloneRdhPageById($rdh_id, $page_id = '838570')
{
    $access_code_dentist = get_user_meta($rdh_id, 'access_code', true);
    if($access_code_dentist!=''){
        $page_id = DENTIST_PAGE_ID;
    }
    // echo $page_id;
    // die();
    $original_page_id = $page_id;
    $rdh_id = (int) $rdh_id;
    
    $user_info = get_userdata($rdh_id);
    $username = $user_info->user_login;
    if ($username == '') {
        $username = $rdh_id;
    }
    $new_page_title = 'Recommendations page for ' . $username;
    $posts_with_meta = get_posts(
        array(
            'meta_key' => 'rdhc_id',
            'meta_value' => $rdh_id,
            'post_type' => 'page', // Adjust the post type as needed
            'posts_per_page' => -1, // Use -1 to fetch all matching posts
            'fields' => 'ids', // Retrieve only post IDs to check existence
        )
    );
    
    if (empty($posts_with_meta)) {
        $new_page_id = clone_post_rdh($original_page_id, $new_page_title);
        wp_update_post(array(
            'ID' => $new_page_id,
            'post_title' => $new_page_title
        ));
        update_post_meta($new_page_id, 'rdhc_id', $rdh_id);
    }
    
}
function wp_add_placeholder_mbt($elements)
{
    $place_holder = bp_get_the_profile_field_name();
    $place_holder = str_replace('contact-info', '', $place_holder);
    $place_holder = str_replace('professional-information', '', $place_holder);
    $place_holder = str_replace('social-media-info', '', $place_holder);
    // echo '<pre>';
    // print_r($elements);
    // die();
    $esteric = '';
    if (isset($elements['aria-required']) && $elements['aria-required'] == true) {
        $esteric = ' *';
    }
    if (isset($elements['type']) && $elements['type'] == 'text') {
        // $elements['aria-labelledby'] = '';
    }
    // echo '<pre>';
    // print_r($elements);
    // echo '</pre>';
    $elements['placeholder'] =  $place_holder . $esteric;
    return $elements;
}
add_action('bp_xprofile_field_edit_html_elements', 'wp_add_placeholder_mbt');
add_action('bp_complete_signup', 'buddydev_redirect_after_signup_mbt');

function buddydev_redirect_after_signup_mbt()
{
    $page = 'rdh-thankyou'; //your page slug
    bp_core_redirect(site_url($page));
}

function auto_register_user_as_affiliate_bb($user_id = 0)
{
    global $wpdb;
    $affiliate_id = affwp_add_affiliate(array(
        'user_id'        => $user_id,
        'status' => 'active',
        'dynamic_coupon' => !affiliate_wp()->settings->get('require_approval') ? 1 : '',
    ));
    affwp_update_affiliate(array('affiliate_id' => $affiliate_id, 'rate' => '20', 'rate_type' => 'percentage'));
    if (!$affiliate_id) {
        return;
    }
    $exp = isset($_REQUEST['repeater_exp']) ? $_REQUEST['repeater_exp'] : array();
    $deg = isset($_REQUEST['repeater_degree']) ? $_REQUEST['repeater_degree'] : array();
    $liscence = isset($_REQUEST['repeater_state']) ? $_REQUEST['repeater_state'] : array();
    $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : array();
    $biref = isset($_REQUEST['biref']) ? $_REQUEST['biref'] : '';
    $rdh_video_url = isset($_REQUEST['rdh_video_url']) ? $_REQUEST['rdh_video_url'] : '';
    $social = isset($_REQUEST['social']) ? $_REQUEST['social'] : array();
    $contact = isset($_REQUEST['contact']) ? $_REQUEST['contact'] : array();
    $professional = isset($_REQUEST['professional']) ? $_REQUEST['professional'] : array();

    global $wpdb;
    if (is_array($exp) && count($exp) > 0) {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'experience',
            'value' => json_encode($exp),
        ));        
    }

    if (is_array($deg) && count($deg) > 0) {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'education',
            'value' => json_encode($deg),
        ));
    }
    if (is_array($liscence) && count($liscence) > 0) {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'liscence',
            'value' => json_encode($liscence),
        ));
    }
    if ($biref != '') {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'biref',
            'value' => $biref,
        ));
    }
    if (is_array($contact) && count($contact) > 0) {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'contact',
            'value' => json_encode($contact),
        ));
        wp_update_user([
            'ID' => $user_id, // this is the ID of the user you want to update.
            'first_name' => $_REQUEST['field_1'],
            'display_name' => $_REQUEST['field_1'],
            'last_name' => $_REQUEST['field_132']
        ]);
    }
    if (is_array($professional) && count($professional) > 0) {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'professional',
            'value' => json_encode($professional),
        ));
    }
    if (is_array($social) && count($social) > 0) {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'social',
            'value' => json_encode($social),
        ));
        update_user_meta($user_id, 's_facebook', $social['facebook']);
        update_user_meta($user_id, 's_instagram', $social['instagram']);
        update_user_meta($user_id, 's_twitter', $social['twitter']);
        update_user_meta($user_id, 's_tikTok', $social['tiktok']);
        update_user_meta($user_id, 's_blog', $social['blog']);
        update_user_meta($user_id, 's_linkedin', $social['linkedin']);
        update_user_meta($user_id, 's_youtube', $social['youtube']);
    }

    if (is_array($address) && count($address) > 0) {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'address',
            'value' => json_encode($address),
        ));
    }
    $wpdb->insert('buddy_user_meta', array(
        'user_id' => $user_id,
        'key' => 'all',
        'value' => json_encode($_POST),
    ));
    update_user_meta($user_id, 'first_name_temp', $_REQUEST['field_1']);
    update_user_meta($user_id, 's_facebook', $social['facebook']);
    $emails = WC()->mailer()->get_emails();
    $respose =   $emails['WC_RDH_Register_Email']->trigger($user_id);
    // echo '<pre>';
    // print_r($_POST);
    // echo json_encode($_POST);
    // echo '</pre>';
    // die();
    $status = affwp_get_affiliate_status($affiliate_id);
    $user   = (array) get_userdata($user_id);
    $args   = (array) $user['data'];

    /**
     * Fires immediately after a new user has been auto-registered as an affiliate
     *
     * @since 1.7
     *
     * @param int    $affiliate_id Affiliate ID.
     * @param string $status       The affiliate status.
     * @param array  $args         Affiliate data.
     */
    do_action('affwp_auto_register_user', $affiliate_id, $status, $args);
}
function activate_buddypress_user($user_id)
{
    // Check if BuddyPress is active
    if (function_exists('buddypress')) {
        // Activate the user
        bp_core_activate_signup($user_id);
        //bp_core_activate_account($user_id);
    }
}
add_action('user_register', 'activate_buddypress_user', 10, 1);
function bp_core_signup_user_mbt($user_id, $user_login, $user_password, $user_email, $usermeta)
{
    global $wpdb;
    $role = bp_get_option('default_role');
    auto_register_user_as_affiliate_bb($user_id);
    save_rdhc_in_JSON_file();
    cloneRdhPageById($user_id);
    sbr_rdhc_invite_codes_query($user_id);

    if (!$wpdb->query($wpdb->prepare("UPDATE {$wpdb->users} SET user_status = 0 WHERE ID = %d", $user_id))) {
        //
    }

    $wpdb->update(
        $wpdb->prefix . 'signups',
        array(
            'active'    => 1,
            'activated' => current_time('mysql', 1),
        ),
        array('user_email' => $user_email)
    );
    bp_delete_user_meta($user_id, 'activation_key');
    $member = get_userdata($user_id);
    $member->set_role($role);
    // bp_core_activate_account($user_id);
    //bp_core_activate_signup($user_id);
    // do something with $user_id
}
add_action('bp_core_signup_user', 'bp_core_signup_user_mbt', 10, 5);

add_action('bp_activate_signup_confirmation_after_details', 'add_repeater_fields_admin_mbt');
function add_repeater_fields_admin_mbt($signup)
{
    $user_login = $signup->user_login;
    $userobj = get_user_by('login', $user_login);
    if ($userobj) {
        echo '<div class="orig-container-mbt">';
        global $wpdb;
        $sql_query = "select * from buddy_user_meta WHERE user_id=" . $userobj->ID;
        $results_arr = $wpdb->get_results($sql_query, 'ARRAY_A');
        //   echo '<pre>';
        //   print_r($results_arr);
        //   echo '</pre>';
        if (is_array($results_arr) && count($results_arr) > 0) {
            foreach ($results_arr as $key => $ed) {
                if ($ed['key'] == 'contact') {
                    $contact = json_decode($ed['value'], true);
                    // print_r($contact);
                    if (is_array($contact) && count($contact) > 0) {
                        echo '<div class="exp-wrapper"><h2>Contact Details</h2>';
                        echo '<div class="wrap-container">';
                        foreach ($contact as $keysoc => $socval) {
                            $keysoc = str_replace("_", " ", $keysoc);
                            if (is_array($socval)) {
                                echo '<strong>' . $keysoc . ':</strong>' . json_encode($socval) . '<br />';
                            } else {
                                echo '<strong>' . $keysoc . ':</strong>' . $socval . '<br />';
                            }
                        }


                        echo '</div>';
                        echo '</div>';
                    }
                }
                if ($ed['key'] == 'professional') {
                    $professional = json_decode($ed['value'], true);

                    if (is_array($professional) && count($professional) > 0) {
                        echo '<div class="exp-wrapper"><h2>Professional Details</h2>';
                        echo '<div class="wrap-container">';
                        foreach ($professional as $keysoc => $socval) {
                            $keysoc = str_replace("_", " ", $keysoc);
                            if (is_array($socval)) {
                                echo '<strong>' . $keysoc . ':</strong>' . json_encode($socval) . '<br />';
                            } else {
                                echo '<strong>' . $keysoc . ':</strong>' . $socval . '<br />';
                            }
                        }


                        echo '</div>';
                        echo '</div>';
                    }
                }
                if ($ed['key'] == 'education') {
                    //  echo 'yes';
                    $education = json_decode($ed['value'], true);
                    if (is_array($education) && count($education) > 0) {
                        echo '<div class="exp-wrapper"><h2>Education Details</h2>';
                        echo '<div class="wrap-container">';
                        for ($i = 0; $i < count($education['school']); $i++) {
                            echo '<div class="education-item">';
                            echo '<strong>School:</strong>' . $education['school'][$i] . '<br />';
                            echo '<strong>Degree title:</strong>' . $education['degree_title'][$i] . '<br />';
                            echo '<strong>Grad date:</strong>' . $education['grad_date'][$i] . '<br />';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';
                    }
                }
                if ($ed['key'] == 'experience') {
                    $experience = json_decode($ed['value'], true);
                    if (is_array($experience) && count($experience) > 0) {
                        echo '<div class="exp-wrapper"><h2>Experience Details</h2>';
                        echo '<div class="wrap-container">';
                        for ($i = 0; $i < count($experience['exp_title']); $i++) {
                            echo '<div class="experience-item">';
                            echo '<strong>Exp title:</strong>' . $experience['exp_title'][$i] . '<br />';
                            echo '<strong>Company:</strong>' . $experience['company'][$i] . '<br />';
                            echo '<strong>Exp employment type:</strong>' . $experience['exp_employment_type'][$i] . '<br />';
                            echo '<strong>City:</strong>' . $experience['city'][$i] . '<br />';
                            echo '<strong>State:</strong>' . $experience['state'][$i] . '<br />';
                            echo '<strong>Start date:</strong>' . $experience['start_month'][$i] . '-' . $experience['start_year'][$i] . '<br />';
                            echo '<strong>End date:</strong>' . $experience['end_month'][$i] . '-' . $experience['end_year'][$i] . '<br />';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';
                    }
                }
                if ($ed['key'] == 'liscence') {
                    $liscence = json_decode($ed['value'], true);
                    if (is_array($liscence) && count($liscence) > 0) {
                        echo '<div class="exp-wrapper"><h2>Liscence Details</h2>';
                        echo '<div class="wrap-container">';
                        for ($i = 0; $i < count($liscence['liscence']); $i++) {
                            echo '<div class="liscence-item">';
                            echo '<strong>Liscence Number:</strong>' . $liscence['liscence'][$i] . '<br />';
                            echo '<strong>State:</strong>' . $liscence['state'][$i] . '<br />';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';
                    }
                }
                if ($ed['key'] == 'social') {
                    $social = json_decode($ed['value'], true);
                    // print_r($social);
                    if (is_array($social) && count($social) > 0) {
                        echo '<div class="exp-wrapper"><h2>Social Details</h2>';
                        echo '<div class="wrap-container">';
                        foreach ($social as $keysoc => $socval) {
                            $keysoc = str_replace("_", " ", $keysoc);
                            echo '<strong>' . $keysoc . ':</strong>' . $socval . '<br />';
                        }


                        echo '</div>';
                        echo '</div>';
                    }
                }
                if ($ed['key'] == 'address') {
                    $address = json_decode($ed['value'], true);

                    if (is_array($address) && count($address) > 0) {
                        echo '<div class="exp-wrapper"><h2>Address Details</h2>';
                        echo '<div class="wrap-container">';
                        foreach ($address as $keysoc => $socval) {
                            $keysoc = str_replace("_", " ", $keysoc);
                            if (is_array($socval)) {
                                echo '<strong>' . $keysoc . ':</strong>' . json_encode($socval) . '<br />';
                            } else {
                                echo '<strong>' . $keysoc . ':</strong>' . $socval . '<br />';
                            }
                        }


                        echo '</div>';
                        echo '</div>';
                    }
                }
                if ($ed['key'] == 'biref') {
                    echo '<div class="exp-wrapper"><h2>Brief Introducation</h2>';
                    echo '<div class="wrap-container">';
                    echo $ed['value'];
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
    }
}
function redirect_rdh_member($redirect_to,$user)
{
    $is_dentist = get_user_meta( $user->ID, 'access_code', true );
        
    if ( $is_dentist != '' ) {
        // Redirect to /dentist/{username}
        $redirect = home_url( '/dentist/' . $user->user_login );
        return $redirect;
    } 

    if (isset($_POST['rdh_member'])) {
        $userdata = get_user_by('email', $_REQUEST['username']);
        if (!$userdata) {
            $userdata = get_user_by('login', $_REQUEST['username']);
        }
        //delete_transient('rdh_member');
        return "/members/" . bp_core_get_username($userdata->ID) . "/profile/edit/group/1";
    } else {
        return $redirect_to;
    }
}
add_action('wp_ajax_partial_submit_form_profile', 'partial_submit_form_profile');
add_action('wp_ajax_nopriv_partial_submit_form_profile', 'partial_submit_form_profile');
function partial_submit_form_profile()
{
    $userId = get_current_user_id();
    if ($_REQUEST['field_1'] != '' && $_REQUEST['field_1'] != '') {
        wp_update_user([
            'ID' => $userId, // this is the ID of the user you want to update.
            'first_name' => $_REQUEST['field_1'],
            'last_name' => $_REQUEST['field_132']
        ]);
    }

    update_buddy_user_custom_fileds($userId, 'true');
}
add_filter('woocommerce_login_redirect', 'redirect_rdh_member', 10,2);
add_action('xprofile_updated_profile', 'update_rdh_profile_data', 1, 5);
if (isset($_POST['field_ids'])) {
    // update_buddy_user_custom_fileds(get_current_user_id());
}
function update_rdh_profile_data($user_id, $posted_field_ids, $errors, $old_values, $new_values)
{

    if (empty($errors)) {
        update_buddy_user_custom_fileds($user_id);
    }
}
function update_buddy_user_custom_fileds($user_id, $ajax_req = 'false')
{
    global $wpdb;
    $thank_you_redirect = false;
    $exp = isset($_REQUEST['repeater_exp']) ? $_REQUEST['repeater_exp'] : array();
    $deg = isset($_REQUEST['repeater_degree']) ? $_REQUEST['repeater_degree'] : array();
    $liscence = isset($_REQUEST['repeater_state']) ? $_REQUEST['repeater_state'] : array();
    $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : array();
    $biref = isset($_REQUEST['biref']) ? $_REQUEST['biref'] : '';
    $rdh_video_url = isset($_REQUEST['rdh_video_url']) ? $_REQUEST['rdh_video_url'] : '';
    /*
    if (isset($_REQUEST['signup_username'])) {
        wp_update_user([
            'ID' => $user_id,
            'user_nicename' =>   $_REQUEST['signup_username'],
            'user_login' =>   $_REQUEST['signup_username'],
        ]);
        update_user_meta($user_id, 'customer_to_rdhc', 'yes');
    }
    */
    if (isset($_REQUEST['signup_username'])) {
        global $wpdb;

        $userData = array(
            'user_login' => $_REQUEST['signup_username'],
            'user_nicename' => $_REQUEST['signup_username'],
        );
        $wpdb->update(
            $wpdb->users,
            $userData,
            ['ID' => $user_id]
        );
        update_user_meta($user_id, 'customer_to_rdhc', 'yes');
    }

    $social = isset($_REQUEST['social']) ? $_REQUEST['social'] : array();
    $contact = isset($_REQUEST['contact']) ? $_REQUEST['contact'] : array();
    $professional = isset($_REQUEST['professional']) ? $_REQUEST['professional'] : array();
    $sql_query = "select affiliate_id from wp_affiliate_wp_affiliates where user_id =" . $user_id;
    $results_query = $wpdb->get_results($sql_query, 'ARRAY_A');
    if ($results_query == null || count($results_query) == 0) {
        $affiliate_id = affwp_add_affiliate(array(
            'user_id'        => $user_id,
            'status' => 'active',
            'dynamic_coupon' => !affiliate_wp()->settings->get('require_approval') ? 1 : '',
        ));
        $status = affwp_get_affiliate_status($affiliate_id);
        $user   = (array) get_userdata($user_id);
        $args   = (array) $user['data'];
        do_action('affwp_auto_register_user', $affiliate_id, $status, $args);
        update_user_meta($user_id, 'last_activity', date("Y-m-d H:i:s"));
        $emails = WC()->mailer()->get_emails();
        $respose =   $emails['WC_RDH_Register_Email']->trigger($user_id);
    }
    $sql_query2 = "select * from buddy_user_meta where user_id =" . $user_id;
    $results_query2 = $wpdb->get_results($sql_query2, 'ARRAY_A');
    if ($results_query2 == null || count($results_query2) == 0) {
        $thank_you_redirect = true;
    }
    if (is_array($exp) && count($exp) > 0) {
        $result = $wpdb->delete(
            'buddy_user_meta',
            array('user_id' => $user_id, 'key' => 'experience')
        );

        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'experience',
            'value' => json_encode($exp),
        ));
    }

    if (is_array($deg) && count($deg) > 0) {

        $result = $result = $wpdb->delete(
            'buddy_user_meta',

            array('user_id' => $user_id, 'key' => 'education')
        );


        //  echo 'updated'.$user_id;
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'education',
            'value' => json_encode($deg),
        ));
        // print_r($deg);
        // die();

    }
    if (is_array($liscence) && count($liscence) > 0) {
        $result = $wpdb->delete(
            'buddy_user_meta',
            array('user_id' => $user_id, 'key' => 'liscence')
        );

        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'liscence',
            'value' => json_encode($liscence),
        ));
    }
    if ($biref != '') {
        $result =  $wpdb->delete(
            'buddy_user_meta',
            array('user_id' => $user_id, 'key' => 'biref')
        );
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'biref',
            'value' => $biref,
        ));
    }

    if (is_array($contact) && count($contact) > 0) {
        $result =  $wpdb->delete(
            'buddy_user_meta',
            array('user_id' => $user_id, 'key' => 'contact')
        );
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'contact',
            'value' => json_encode($contact),
        ));
    }
    if (is_array($professional) && count($professional) > 0) {
        $result = $wpdb->delete(
            'buddy_user_meta',
            array('user_id' => $user_id, 'key' => 'professional')
        );
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'professional',
            'value' => json_encode($professional),
        ));
        update_user_meta($user_id, 'rdh_video_url', $rdh_video_url);
    }
    if (is_array($social) && count($social) > 0) {
        update_user_meta($user_id, 's_facebook', $social['facebook']);
        update_user_meta($user_id, 's_instagram', $social['instagram']);
        update_user_meta($user_id, 's_twitter', $social['twitter']);
        update_user_meta($user_id, 's_tikTok', $social['tiktok']);
        update_user_meta($user_id, 's_blog', $social['blog']);
        update_user_meta($user_id, 's_linkedin', $social['linkedin']);
        update_user_meta($user_id, 's_youtube', $social['youtube']);

        $result = $wpdb->delete(
            'buddy_user_meta',

            array('user_id' => $user_id, 'key' => 'social')
        );
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'social',
            'value' => json_encode($social),
        ));
    }


    if (is_array($address) && count($address) > 0) {
        $result = $wpdb->delete(
            'buddy_user_meta',
            array('user_id' => $user_id, 'key' => 'address')
        );
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'address',
            'value' => json_encode($address),
        ));

        //print_r($address);

    }

    $result = $wpdb->delete(
        'buddy_user_meta',

        array('user_id' => $user_id, 'key' => 'all')
    );
    $wpdb->insert('buddy_user_meta', array(
        'user_id' => $user_id,
        'key' => 'all',
        'value' => json_encode($_POST),
    ));
    if (function_exists('w3tc_flush_url')) {
        $user_idd = bp_core_get_userid(bp_core_get_username(get_current_user_id()));
        if (!$user_idd || $user_idd == '') {
            $linkslug = $wpdb->get_var("SELECT user_login FROM wp_users WHERE user_nicename = '" . bp_core_get_username(get_current_user_id()) . "'");
        } else {
            $linkslug = bp_core_get_username(get_current_user_id());
        }
        w3tc_flush_url(home_url() . "/rdh/profile/" . $linkslug . "/");
        w3tc_flush_url(home_url() . "/rdh/products/" . $linkslug . "/");
        w3tc_flush_url(home_url() . "/rdh/contact/" . $linkslug . "/");
    }
    if ($ajax_req == 'true') {
        echo 'yes';
        die();
    }
    if ($thank_you_redirect) {
        $page = 'rdh-thankyou';
        bp_core_redirect(site_url($page));
    } else {
        bp_core_redirect(wp_get_referer() . '?updated=true');
    }
}

function update_buddy_user_custom_fileds_back($user_id)
{
    global $wpdb;
    $thank_you_redirect = false;
    $exp = isset($_REQUEST['repeater_exp']) ? $_REQUEST['repeater_exp'] : array();
    $deg = isset($_REQUEST['repeater_degree']) ? $_REQUEST['repeater_degree'] : array();
    $liscence = isset($_REQUEST['repeater_state']) ? $_REQUEST['repeater_state'] : array();
    $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : array();
    $biref = isset($_REQUEST['biref']) ? $_REQUEST['biref'] : '';
    $social = isset($_REQUEST['social']) ? $_REQUEST['social'] : array();
    $contact = isset($_REQUEST['contact']) ? $_REQUEST['contact'] : array();
    $professional = isset($_REQUEST['professional']) ? $_REQUEST['professional'] : array();
    $sql_query = "select affiliate_id from wp_affiliate_wp_affiliates where user_id =" . $user_id;
    $results_query = $wpdb->get_results($sql_query, 'ARRAY_A');
    if ($results_query == null || count($results_query) == 0) {
        $affiliate_id = affwp_add_affiliate(array(
            'user_id'        => $user_id,
            'dynamic_coupon' => !affiliate_wp()->settings->get('require_approval') ? 1 : '',
        ));
        $status = affwp_get_affiliate_status($affiliate_id);
        $user   = (array) get_userdata($user_id);
        $args   = (array) $user['data'];
        do_action('affwp_auto_register_user', $affiliate_id, $status, $args);
        update_user_meta($user_id, 'last_activity', date("Y-m-d H:i:s"));
        $emails = WC()->mailer()->get_emails();
        $respose =   $emails['WC_RDH_Register_Email']->trigger($user_id);
    }
    if (is_array($exp) && count($exp) > 0) {
        $result = $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => json_encode($exp)
            ),
            array('user_id' => $user_id, 'key' => 'experience')
        );
        if ($result > 1) {
            //
        } else {
            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'experience',
                'value' => json_encode($exp),
            ));
        }
    }

    if (is_array($deg) && count($deg) > 0) {

        $result = $result = $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => json_encode($deg)
            ),
            array('user_id' => $user_id, 'key' => 'education')
        );

        if ($result > 1) {
            //
        } else {

            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'education',
                'value' => json_encode($deg),
            ));
            // print_r($deg);
            // die();
        }
    }
    if (is_array($liscence) && count($liscence) > 0) {
        $result = $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => json_encode($liscence)
            ),
            array('user_id' => $user_id, 'key' => 'liscence')
        );

        if ($result > 1) {
            //
        } else {
            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'liscence',
                'value' => json_encode($liscence),
            ));
        }
    }
    if ($biref != '') {
        $result =  $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => $biref
            ),
            array('user_id' => $user_id, 'key' => 'biref')
        );

        if ($result > 1) {
            //
        } else {
            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'biref',
                'value' => $biref,
            ));
        }
    }

    if (is_array($contact) && count($contact) > 0) {
        $result =  $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => json_encode($contact)
            ),
            array('user_id' => $user_id, 'key' => 'contact')
        );

        if ($result > 1) {
            //
        } else {
            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'contact',
                'value' => json_encode($contact),
            ));
        }
    }
    if (is_array($professional) && count($professional) > 0) {
        $result = $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => json_encode($professional)
            ),
            array('user_id' => $user_id, 'key' => 'professional')
        );

        if ($result > 1) {
            //
        } else {
            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'professional',
                'value' => json_encode($professional),
            ));
        }
    }
    if (is_array($social) && count($social) > 0) {
        $result = $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => json_encode($social)
            ),
            array('user_id' => $user_id, 'key' => 'social')
        );

        if ($result > 1) {
            //
        } else {
            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'social',
                'value' => json_encode($social),
            ));
        }
    }


    if (is_array($address) && count($address) > 0) {
        $result = $wpdb->update(
            'buddy_user_meta',
            array(
                'value' => json_encode($address)
            ),
            array('user_id' => $user_id, 'key' => 'address')
        );
        if ($result > 1) {
            //
        } else {
            $wpdb->insert('buddy_user_meta', array(
                'user_id' => $user_id,
                'key' => 'address',
                'value' => json_encode($address),
            ));
            $thank_you_redirect = true;
        }
        //print_r($address);

    }

    $result = $wpdb->update(
        'buddy_user_meta',
        array(
            'value' => json_encode($_POST)
        ),
        array('user_id' => $user_id, 'key' => 'all')
    );
    if ($result > 1) {
        //
    } else {
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'all',
            'value' => json_encode($_POST),
        ));
    }

    if ($thank_you_redirect) {
        $page = 'rdh-thankyou';
        //   bp_core_redirect(site_url($page));
        bp_core_redirect(wp_get_referer() . '?updated=true');
    } else {
        bp_core_redirect(wp_get_referer() . '?updated=true');
    }
}
add_action('acf/init', 'mbt_acf_op_init');
function mbt_acf_op_init()
{

    // Check function exists.
    if (function_exists('acf_add_options_page')) {

        // Add parent.
        $parent = acf_add_options_sub_page(array(
            'page_title'  => __('RDHC Invite Codes'),
            'menu_title'  => __('RDHC Invite Codes'),
            'parent_slug' => 'apis-settings',
            'capability'    => 'edit_posts',
            'redirect'    => false,
        ));
    }
}

add_filter('acf/validate_value/name=rdhc_invite_codes', 'require_unique_validation_mbt', 10, 4);
function require_unique_validation_mbt($valid, $value, $field, $input)
{
    if (!$valid) {
        return $valid;
    }
    $parent_group = $field['key'];
    $sub_fields = $field['sub_fields'];
    foreach ($sub_fields as $key => $val) {
        if ($val['name'] == 'rdhc_invite_code') {
            $child_key_code = $val['key'];
        }
        if ($val['name'] == 'rdhc_email_address') {

            $child_key_email = $val['key'];
        }
    }

    $codes_rr = array();
    $email_rr = array();
    foreach ($value as $nw_val) {
        if (in_array(strtolower($nw_val[$child_key_email]), $email_rr)) {
            $valid = 'The email ' . $nw_val[$child_key_email] . ' already exists';
        } else {
            $email_rr[] = strtolower($nw_val[$child_key_email]);
        }
        if (in_array(strtolower($nw_val[$child_key_code]), $codes_rr)) {
            $valid .= '<br />The Code ' . $nw_val[$child_key_code] . ' already exists';
        } else {
            $codes_rr[] = strtolower($nw_val[$child_key_code]);
        }
    }
    return $valid;
}

add_action('init', function() {
    if (function_exists('get_field')) {
$rows = get_field('rdhc_invite_codes', 'option');
$codes_arr = array();
if ($rows) {
    foreach ($rows as $row) {
        if ($row['rdhc_invite_code'] != '') {
            $codes_arr[] = $row['rdhc_invite_code'];
        }
    }
}
//define('REFFERAL_CODES', $codes_arr);
  
    }
    if (function_exists('sbr_rdhc_all_retrieve_invite_codes')) {
        define('REFFERAL_CODES', sbr_rdhc_all_retrieve_invite_codes());
    }

});
//add_action('init','vc_custom_params_rdhcc');
function vc_custom_params_rdhcc()
{
    if(!function_exists('vc_add_param')){
        return false;
    }
    //echo get_the_id();
    global $post;
    $current_page_id =  $_GET['post'];
    if ($current_page_id == '') {
        $current_page_id =  $_REQUEST['post_id'];
    }
    $user_id = get_post_meta($current_page_id, 'rdhc_id', true);
    $affwp_product_rates =  get_user_meta($user_id, 'affwp_product_rates', true);
    $optionss = array();
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
        'fields' => 'ids',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => array('raw', 'packaging', 'landing-page', 'uncategorized', 'data-only', 'addon'),
                'operator' => 'NOT IN',
            ),
            // array(
            //     'taxonomy' => 'product_type',
            //     'field' => 'slug',
            //     'terms' => array('composite'),
            //     'operator' => 'Not IN',
            // ),
        ),
    );

    $product_list = get_posts($args);
    foreach ($product_list as $prod_id) {
        $options[get_the_title($prod_id)] = $prod_id;
    }
    $taxonomies_ptypes = get_terms(array(
        'taxonomy' => 'type',
        'hide_empty' => false
    ));
    if (!empty($taxonomies_ptypes)) {

        foreach ($taxonomies_ptypes as $category) {
            $options[$category->name . ' (Category)'] = $category->slug;
        }
    }

    
    $attributes = array(
        'type' => 'dropdown',
        'heading' => "Product Or Category",
        'param_name' => 'product_id',
        'value' => $options,
        'description' => __("Please select the product/category you want to add ", "my-text-domain"),
    );
    vc_add_param('single_porudct_rdhc', $attributes); // Note: 'vc_message' was used as a base for "Message box" element
    $rdh_user_iddd = array(
        "type" => "hiddenfield",
        'heading' => "",
        'param_name' => 'rdh_user_id',
        'value' => $user_id,
        'description' => __(""),
    );
    vc_add_param('single_porudct_rdhc', $rdh_user_iddd);
    $image_1 = array(
        "type" => "attach_image",
        'heading' => "Custom Image",
        'param_name' => 'custom_image',
        'description' => __("Please upload custom image This will replace default image ", "my-text-domain"),
    );
    vc_add_param('single_porudct_rdhc', $image_1);
}
function save_rdhc_in_JSON_file()
{
    $args = array(
        'meta_query' => array(
            array(
                'key' => 'bp_xprofile_visibility_levels',
                'compare' => 'EXISTS'
            )
        )
    );
    $file_path = get_stylesheet_directory() . '/assets/rdhcs.json';
    $user_data  = array();
    $rdhusers = get_users($args);
    foreach ($rdhusers as $user) {
        $email = $user->user_email;
        $rdh_titleline = get_user_meta($user->ID, 'rdh_titleline', true);
        $chat_user_image  = bp_core_fetch_avatar(
            array(
                'item_id' => $user->ID, // id of user for desired avatar
                'type'    => 'thumb-mini',
                'html'   => FALSE     // FALSE = return url, TRUE (default) = return img html
            )
        );
        //  $_rdh_titleline = get_user_meta($user->ID, '_rdh_titleline', true);
        $user_data[$email] = array('timeline' => $rdh_titleline, 'profile_pic' => $chat_user_image, 'full_name' => $user->first_name . ' ' . $user->last_name);
    }
    $json_data = json_encode($user_data);
    update_option('rdhcs_json', $json_data);
    file_put_contents($file_path, $json_data);
    //  die();
}


add_shortcode('single_porudct_rdhc', 'single_porudct_rdhc_callback');
function single_porudct_rdhc_callback($atts, $content = null)
{

    extract(shortcode_atts(array(
        'product_id' => '',
        'custom_title' => '',
        'recommended' => '',
        'callout_text' => '',
        'custom_image' => '',
        'description' => '',
        'link_url' => '',
        'add_to_cart' => '',
        'discount_type' => '',
        'discount_amount' => '',
        'show_quantity' => '',
        'rdh_user_id' => '',
        'allow_coupon' => '',
        'stackable_sale' => ''


    ), $atts));



    global $GEHA_PAGE_ID, $post,$sc_page;
    $pslug = $post->post_name;
        if(isset($_REQUEST['page_id_darkstar']) && $_REQUEST['page_id_darkstar'] != ''){

         $GEHA_PAGE_ID = isset($_REQUEST['page_id_darkstar']) ? $_REQUEST['page_id_darkstar']:'';

    }
    $dentist_page = false;
    if(get_query_var('dentist_name')!=''){
        $dentist_page = true;
    }
    //echo 'geha page id is'.$GEHA_PAGE_ID;
    $add_to_cart_text = 'Add To Cart';
    if($sc_page) {
    $add_to_cart_text = 'Add To Cart'; 
    }
    $coupon_string = '';
    if($allow_coupon=='no'){
        $coupon_string = 'data-disable_coupon=yes';
    }
    $dental =false;
    $show_add_to_cart_btn = true;

    $page_normal_text_key = 'rdhc_page_normal_text_';
    $normay_text_arr_products = array();
    if ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID) {
        $page_normal_text_key = 'rdhc_page_normal_text_2';
        $normay_text_arr_products = NORMAL_TEXT_ARRAY_PRODUCTS;
        // $page_normal_text_string = 'normally pprice without GEHA discount ';
        $page_normal_text_string = 'Discounted price for GEHA members ';
    }
    if ($GEHA_PAGE_ID == UCC_PAGE_ID) {
      
        $page_normal_text_string = 'Discounted price for UCC members ';
    }

    if ( !is_null( $post ) ) {
        $post_id = $post->ID;
    }

    $select_package_html = '';
    $rate_sale = (int) $discount_amount;
    $rdhc_user = isset($_COOKIE['red_user_id']) ? $_COOKIE['red_user_id'] : '';
$drFullName= '';

if($rdhc_user =='') {
        $rdhc_user = isset($_REQUEST['rdhc_user_id']) ? $_REQUEST['rdhc_user_id']:'';

    }
    $dentist_discountedPrice  ='';
    if($rdhc_user!='' &&  $dentist_page){
        $drFullName = get_user_meta($rdhc_user,'first_name',true).' '.get_user_meta($rdhc_user,'last_name',true);
        $dentist_discountedPrice  ='<div class="drtext"><i>discounted pricing for patients</i></div>';
    }
    
    if(is_user_logged_in() && get_current_user_id() == $rdhc_user){

    }
    update_user_meta($rdhc_user, 'product_found', 'yes');
    $rdhc_price_array = array();
    if (!preg_match("/[a-z]/i", $product_id)) {
        $product_cat_slug = get_comma_seperated_cat_slugs($product_id);
        $category_slug = 'adults-probiotics'; // Replace 'category-slug' with the slug of the category you want to check
        $taxonomy ='type';
        if (product_belongs_to_category($product_id, $category_slug,$taxonomy) && ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID || $GEHA_PAGE_ID == SHINE_PAGE_ID || is_wc_endpoint_url('shine_subscription') || is_page('sale') ||  $GEHA_PAGE_ID == UCC_PAGE_ID)) {
            $dental =true;
            ob_start(); // Start output buffering
            get_template_part('page-templates/cari-pro-dental-subscription', '', array('product_id' => $product_id,'discount_type'=>$discount_type,'discount_amount'=>$discount_amount,'call_from_page'=>$pslug)); // Retrieve the content of custom-template.php
             $custom_content = ob_get_clean();
           
            
        }
        $category_slug = 'enamel-armour'; // Replace 'category-slug' with the slug of the category you want to check
        $taxonomy ='type';
        if (product_belongs_to_category($product_id, $category_slug,$taxonomy) && ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID || $GEHA_PAGE_ID == UCC_PAGE_ID || $GEHA_PAGE_ID == SHINE_PAGE_ID || is_wc_endpoint_url('shine_subscription') || is_page('sale') || $GEHA_PAGE_ID == UCC_PAGE_ID)) {
            $dental =true;
            ob_start(); // Start output buffering
            get_template_part('page-templates/enamel-armour-subscription', '', array('product_id' => $product_id,'discount_type'=>$discount_type,'discount_amount'=>$discount_amount,'call_from_page'=>$pslug)); // Retrieve the content of custom-template.php
             $custom_content = ob_get_clean(); 
        }

        $category_slug = 'adults-plaque'; // Replace 'category-slug' with the slug of the category you want to check
        $taxonomy ='type';
        if (product_belongs_to_category($product_id, $category_slug,$taxonomy) && ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID || $GEHA_PAGE_ID == UCC_PAGE_ID || $GEHA_PAGE_ID == SHINE_PAGE_ID || is_wc_endpoint_url('shine_subscription') || is_page('sale'))) {
            $dental =true;
            ob_start(); // Start output buffering
            get_template_part('page-templates/plaque-highlighter-subscription', '', array('product_id' => $product_id,'discount_type'=>$discount_type,'discount_amount'=>$discount_amount,'call_from_page'=>$pslug)); // Retrieve the content of custom-template.php
             $custom_content = ob_get_clean(); 
        }

        $category_slug = 'proshield'; // Replace 'category-slug' with the slug of the category you want to check
        $taxonomy ='product_cat';

        if (product_belongs_to_category($product_id, $category_slug,$taxonomy) && ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID || $GEHA_PAGE_ID == 847434 || $GEHA_PAGE_ID == SHINE_PAGE_ID || is_wc_endpoint_url('shine_subscription')|| is_page('sale') || $GEHA_PAGE_ID == UCC_PAGE_ID)) {
            $dental =true;
            ob_start(); // Start output buffering
            get_template_part('page-templates/sport-guards', '', array('product_id' => $product_id,'discount_type'=>$discount_type,'discount_amount'=>$discount_amount,'call_from_page'=>$pslug)); // Retrieve the content of custom-template.php
             $custom_content = ob_get_clean();
           
        }

        $product = wc_get_product($product_id);
        if ($product_id) {
            $was_text_string = '<span class="wasText">was </span><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $product->get_regular_price() . '</bdi></span></del>';
            if ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID) {
                $was_text_string = '<div class="wasTextParent-div"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $product->get_regular_price() . '</bdi></span></del></div><span class="was-text2 wasText tttttttttyyyy discountedPriceForGehaMember"> discounted price for GEHA members</span>';
            }
            if ($GEHA_PAGE_ID == UCC_PAGE_ID) {
                $was_text_string = '<div class="wasTextParent-div"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $product->get_regular_price() . '</bdi></span></del></div><span class="was-text2 wasText tttttttttyyyy discountedPriceForGehaMember"> discounted price for UCC members</span>';
              //  $page_normal_text_string = 'Discounted price for UCC members ';
            }
            if($GEHA_PAGE_ID == SHINE_PAGE_ID && $stackable_sale=='yes'){
            $pprice = (int) $product->get_price();
            $ppriceCalculation = get_post_meta($product_id, '_regular_price', true);
            $discount  = 0;


            if ($discount_type == 'percentage') {
                $discount = ($pprice * $rate_sale) / 100;
                $discounted_price = $pprice - $discount;
            } elseif ($discount_type == 'fixed') {
                $discount = $rate_sale;
                $discounted_price = $pprice - $rate_sale;
            } else {
                $discount = 0;
                $discounted_price = $pprice;
            }
           
            $pid =  $product_id;
            $_product = $product;
            
            if ($discount >  $product->get_price()) {
                $discount =   $product->get_price();
            }
            $sale_price =  $product->get_price() - $discount;
                if($discount>0){
                $sale_price =  $product->get_price() - $discount;
            }
            }
            else{
            $pprice = (int) $product->get_price();
            $ppriceCalculation = get_post_meta($product_id, '_regular_price', true);
            
                if ($discount_type == 'percentage') {
                    $discount = ($ppriceCalculation * $rate_sale) / 100;
                    $discounted_price = $ppriceCalculation - $discount;
                } elseif ($discount_type == 'fixed') {
                    $discount = $rate_sale;
                    $discounted_price = $ppriceCalculation - $rate_sale;
                } else {
                    $discount = 0;
                    $discounted_price = $ppriceCalculation;
                }

           // }
            $pid =  $product_id;
            $_product = $product;
           
            if ($discount > get_post_meta($pid, '_regular_price', true)) {
                $discount =  get_post_meta($pid, '_regular_price', true);
            }
            $sale_price =  get_post_meta($pid, '_price', true) - $discount;
            // only for geha
            //if($discount>0 && $GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID ){
                if($discount>0){
                $sale_price =  get_post_meta($pid, '_regular_price', true) - $discount;
            }
        }
        $sale_price = number_format($sale_price, 2, '.', '');
            $still_available = get_post_meta($pid, 'still_available', true);
            $bogo_custom_title = get_post_meta($pid, 'bogo_custom_title', true);
            $ptitle = get_the_title($product_id);
            $post_date = get_the_date('Ymd', $product_id);
            //  $_product = wc_get_product((int) $product_id);
            if ($custom_title != '') {
                $ptitle = $custom_title;
            }
            $str = '';

            $featured_img_url = get_the_post_thumbnail_url($product_id, 'full');
            if ($custom_image != '') {
                $featured_img_url = wp_get_attachment_image_url($custom_image, 'full');
            }
            $rdhc_discounted_price = '';
            /*
        if ($discount > 0) {
            $rdhc_discounted_price = 'data-rdh_sale_price="' . $sale_price . '"';
            $existing_value = get_user_meta($rdhc_user, 'rdhc_discounted_products', true);
            if ($existing_value == '') {
                $existing_value = array();
            }
            $existing_value[$pid] = $sale_price;
            update_user_meta($rdhc_user, 'rdhc_discounted_products', $existing_value);
        }
        */



            if ($discount > 0) {
                if ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-geha_sale_price="' . $sale_price . '" data-geha_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'geha_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'geha_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == SWEAT_COIN_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-sweatcoin_sale_price="' . $sale_price . '" data-sweatcoin_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'sweatcoin_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'sweatcoin_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == ONE_DENTAL_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-1dental_sale_price="' . $sale_price . '" data-1dental_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, '1dental_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, '1dental_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == BENEFIT_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-benefithub_sale_price="' . $sale_price . '" data-benefithub_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'benefithub_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'benefithub_discounted_products', $existing_value);
              
                }else if ($GEHA_PAGE_ID == PERK_SPOT_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-perkspot_sale_price="' . $sale_price . '" data-perkspot_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'perkspot_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'perkspot_discounted_products', $existing_value);
              
                }else if ($GEHA_PAGE_ID == ABNENITY_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-abenity_sale_price="' . $sale_price . '" data-abenity_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'abenity_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'abenity_discounted_products', $existing_value);
              
                }else if ($GEHA_PAGE_ID == GOOD_RX_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-goodrx_sale_price="' . $sale_price . '" data-goodrx_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'goodrx_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'goodrx_discounted_products', $existing_value);
              
                }
                else if ($GEHA_PAGE_ID == UCC_PAGE_ID) {
                    $rdhc_discounted_price = 'data-ucc_sale_price="' . $sale_price . '" data-ucc_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'ucc_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'ucc_discounted_products', $existing_value);
              
                }
                else if ($GEHA_PAGE_ID == TELEDENTIST_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-teledentists_sale_price="' . $sale_price . '" data-teledentists_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'teledentists_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'teledentists_discounted_products', $existing_value);
              
                } else if ($GEHA_PAGE_ID == INSURANCE_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-insurance_lander_price="' . $sale_price . '" data-insurance_lander="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'insurance_lander_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'insurance_lander_discounted_products', $existing_value);
               
                } else if ($GEHA_PAGE_ID == VIP_SALE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-vip_sale_price="' . $sale_price . '" data-vip_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'vip_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'vip_discounted_products', $existing_value);
                }
                else if ($GEHA_PAGE_ID == SHINE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-shine_sale_price="' . $sale_price . '" data-shine_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'shine_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'shine_discounted_products', $existing_value);
                }
                else if ($GEHA_PAGE_ID == CUSTOMER_DISCOUNT_PAGE_ID) {
                    $rdhc_discounted_price = 'data-sbrcustomer_sale_price="' . $sale_price . '" data-sbrcustomer_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'sbrcustomer_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'sbrcustomer_discounted_products', $existing_value);
                }
                else {
                    $rdhc_discounted_price = 'data-rdh_sale_price="' . $sale_price . '"';
                    $existing_value = get_user_meta($rdhc_user, 'rdhc_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_user_meta($rdhc_user, 'rdhc_discounted_products', $existing_value);
                }
               // $sale_price = number_format((float)$sale_price, 2, '.', '');
                $sale_price = number_format($sale_price, 2, '.', '');
            } else {
                if ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-geha_user="yes" ';
                } elseif ($GEHA_PAGE_ID == SWEAT_COIN_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-sweatcoin_user="yes" ';
                } elseif ($GEHA_PAGE_ID == ONE_DENTAL_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-1dental_user="yes" ';
                } elseif ($GEHA_PAGE_ID == BENEFIT_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-benefithub_user="yes" ';
                }
                elseif ($GEHA_PAGE_ID == PERK_SPOT_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-perkspot_user="yes" ';
                } elseif ($GEHA_PAGE_ID == ABNENITY_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-abenity_user="yes" ';
                }
                elseif ($GEHA_PAGE_ID == UCC_PAGE_ID) {
                    $rdhc_discounted_price = ' data-ucc_user="yes" ';
                }
                elseif ($GEHA_PAGE_ID == GOOD_RX_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-goodrx_user="yes" ';
                }elseif ($GEHA_PAGE_ID == TELEDENTIST_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-teledentists_user="yes" ';
                } elseif ($GEHA_PAGE_ID == INSURANCE_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-insurance_lander="yes" ';
                }
                else if ($GEHA_PAGE_ID == SHINE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-shine_user="yes" ';
                }
                else if ($GEHA_PAGE_ID == CUSTOMER_DISCOUNT_PAGE_ID) {
                    $rdhc_discounted_price = ' data-sbrcustomer_user="yes" ';
                }
            }
            $rec = 0;
            $normal_text = get_field($page_normal_text_key, $product_id);
            if ($normal_text == '' && in_array($product_id, $normay_text_arr_products)) {
                if (str_contains($page_normal_text_string, 'GEHA')) {
                    $normal_text = $page_normal_text_string;
                } else {
                    $normal_text = str_replace('pprice', '$' . get_post_meta($product_id, '_regular_price', true), $page_normal_text_string);
                }
            }
            $btn = ' <button class="btn btn-primary-blue product_type_composite add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $product_id . '" data-rdhc_user_id="' . $rdhc_user . '" data-quantity="1" data-product_id="' . $product_id . '" ' . $rdhc_discounted_price . ' data-action="woocommerce_add_order_item" '.$coupon_string.'>'.$add_to_cart_text.'</button>';
            if ($add_to_cart == 'no') {

                //   $btn = ' <a class="btn btn-primary-blue product_type_composite" href="'.$link_url.'" data-quantity="1" > Select a package</a>';

                $btn = '<div class="addToCartBottom openQuantityBox">
    <button class="btn btn-primary-blue btn-lg product_type_simple  selectquantitybtn" data-price="' . $sale_price . '">Select Quantity</button>
</div><div class="packageQuantityBox">
    <div class="packageheader font-mont">
        <span class="textSelectQuantity">Select Quantity</span>
        <p class="textSelectQuantity open-sans">
            Due to limited stock, you can <br>
            purchase up to 10 units per order
        </p>
        <a href="javascript:;" class="iconCloseBox">
            x
        </a>
    </div>
    <div class="increament-decreament-wrapper box">
        <div class="checkout-amount ">
            <div class="plus-minusWrapper">                
                <button type="button" class="decrease-btn minus-btn">-</button>
                <input type="text" class="quantity  qty-update" data-rdhc_user_id="' . $rdhc_user . '" data-pid="' . $product_id . '" value="1" readonly="readonly">
                <button type="button" class="increase-btn plus-btn">+</button>
            </div>
            <p class="total">$<span class="price-display">' . $sale_price . '</span></p>
            <div class="normalyAmount italic ">' . $normal_text . '</div>
            <p class="price" data-price="' . $sale_price . '"
                style="visibility:hidden; display:none;">$30 per month</p>
        </div>
    </div>

    <div class="product-selection-price-wrap orange">
        <button
            class="btn btn-primary-blue product_type_composite add_to_cart_button ajax_add_to_cart"
            href="?add-to-cart=" data-quantity="1" data-rdhc_user_id="' . $rdhc_user . '" 
            data-product_id=""
            data-action="woocommerce_add_order_item" ' . $rdhc_discounted_price . ' '.$coupon_string.'>'.$add_to_cart_text.'</button>
    </div>
</div>';
            }
            if ($add_to_cart == 'no' && $link_url != 'javascript:void(0);') {
                $btn = ' <a class="btn btn-primary-blue product_type_composite" href="' . $link_url . '" data-quantity="1" > Select a package</a>';
            }
            if(is_user_logged_in() && get_current_user_id() == $rdhc_user && $dentist_page){
            
                $btn = '<style>.drtext{display:none;}</style><div class="access-code-no-added">
                                    <span class="selec-option-to-share italic-style"> Select one or more products to share</span>
                                    <div class="product-selection-price-wrap added-button ony-dentist-page">                                
                                    <div class="check-button">
                                        <input type="checkbox" id="'.$product_id.'" name="radio-group" class="selected_for_share" value="'.$product_id.'" >
                                        <label for="'.$product_id.'" class="btn">
                                            <span class="click-to-select">Click to Select</span>                                    
                                            <span class="added-text">Added!</span>
                                        </label>
                                    </div>
                                    </div>                                
                                </div>';
            }
            if ($recommended == 'yes') {
                $rec = 1;
            }
            if ($_product->is_on_sale() || $discount > 0) {
                //$callout_text = 'Sale!';
                // $str = '<span class="wasText">was </span><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $_product->get_regular_price() . '</bdi></span></del>';
                $str = $was_text_string;
            } else {
                if (strpos($callout_text, 'Sale') !== false) {
                    $callout_text = '';
                }
            }

            $data = '<div class="lander-shortcode" data-price="' . $sale_price . '" data-date="' . $post_date . '" data-recommended="' . $rec . '" data-tagging="' . $callout_text . '" data-cats="'.$product_cat_slug.'">
                <div class="product-selection-box">';
                
            if ($callout_text != 'Select') {
                $data .= '<div class="featureTag"><span>' . $callout_text . '</span></div>';
            }
            if($dental){
                //die();
                 $data .=$custom_content.'</div></div>';
                 return $data;
            }
            $average_text = get_field("average_price", $product_id);
            if ($average_text == '') {
                $average_text = 'normally';
            }
            $normal_text = get_field($page_normal_text_key, $product_id);
            if ($normal_text == '' && in_array($product_id, $normay_text_arr_products)) {
                if (str_contains($page_normal_text_string, 'GEHA')) {
                    $normal_text = $page_normal_text_string;
                } else {
                    $normal_text = str_replace('pprice', '$' . get_post_meta($product_id, '_regular_price', true), $page_normal_text_string);
                }
            }
           
            $data .= '<div class="product-selection-image-wrap">
                    <a href="' . $link_url . '">
                        <img src="' . $featured_img_url . '">
                    </a>
                    </div>
                    <div class="product-selection-description-parent">
                        <div class="product-selection-description-parent-inner">
                            <div class="backOrderList alert alert-danger font-mont">This product is backordered with an estimated shipping date in mid January 2024.</div>                        
                            <div class="product-selection-description">
                            <div class="starRatinGImage"><img src="<?php echo home_url();?>/wp-content/uploads/2020/09/4.9-stars.png" alt=""></div>
                            <div class="small-desc">' . $description . '</div>
                                <div class="productDescriptionDiv proTpDiv"> <b>' . $ptitle . '</b></div>
                                <div class="productDescriptionFull">' . $content . '</div>
                                    <div class="product-selection-price-text-top noflexDiv">
                                        <span class="product-selection-price-text hoo">' . $str . '
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $sale_price . '</bdi>
                                                </span>
                                            </ins>
                                        </span>
                                        <div class="normalyAmount italic forOnlyLayoutSixDisplay" ></div>
                                        <div class="featureShippingPrice">+free shipping</div>
                                    </div>
                                    '.$dentist_discountedPrice.'                                    
                                </div>
                                <div class="normalyAmount italic">' . $normal_text . ' </div>
                                
                            <div class="product-selection-price-wrap green">               

                            ' . $btn . ' 
                            </div>
                        </div>
                    </div>
                </div>
         </div>';
            return $data;
        }
    }

    // if($product_id)
    else {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'posts_per_page'        => '12',
            // 'orderby'=> 'meta_value_num', 
            // 'order' => 'ASC',
            // 'meta_key'=>'rdhc_order_for_rdhc_lander_page',
            'tax_query'             => array(
                'relation' => 'AND',
                array(
                    'taxonomy'      => 'type',
                    'field' => 'slug', //This is optional, as it defaults to 'term_id'
                    'terms'         => array($product_id),
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                )
            )
        );

        if ($product_id == 'night-guard-2mm-3mm' || $product_id == 'tray-system') {
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            $args['meta_key'] = 'rdhc_order_for_rdhc_lander_page';
        }
        $products = new WP_Query($args);
        $counter = 0;
        $select_package_html = '<div class="selectPackageWrapper">
              <div class="selectPackageBox">
                <div class="selectPackageBoxWrapper">
                  
                    <div class="packageheader font-mont">
                      <span class="textSelectPackage">Select Package</span>
                      <a href="javascript:;" class="iconCloseBox">
                        x
                      </a>
                    </div>
                    <div class="packageBody">
                      <div class="stepQuantityOption">';
                      $product_cat_slug = '';
        while ($products->have_posts()) : $products->the_post();
            $child_product_id = get_the_id();
            $ptitle = get_the_title($child_product_id);
            $post_date = get_the_date('Ymd', $child_product_id);

            $product = wc_get_product($child_product_id);
            $product_cat_slug .= get_comma_seperated_cat_slugs($child_product_id).',';

            if($GEHA_PAGE_ID == SHINE_PAGE_ID && $stackable_sale=='yes'){
                $pprice = (int) $product->get_price();
            $discount  = 0;
            if ($discount_type == 'percentage') {
                $discount = ($pprice * $rate_sale) / 100;
                $discounted_price = $pprice - $discount;
            } elseif ($discount_type == 'fixed') {
                $discount = $rate_sale;
                $discounted_price = $pprice - $rate_sale;
            } else {
                $discount = 0;
                $discounted_price = $pprice;
            }
           
            $pid =  $product_id;
            $_product = $product;
          
            if ($discount >  $product->get_price()) {
                $discount =   $product->get_price();
            }
            $sale_price =  $product->get_price() - $discount;
                if($discount>0){
                $sale_price =  $product->get_price() - $discount;
            }
            }
            else{
                $pprice = $product->get_price();
                $ppriceCalculation = get_post_meta($child_product_id, '_regular_price', true);
            $discount  = 0;
           
                if ($discount_type == 'percentage') {
                    $discount = ($ppriceCalculation * $rate_sale) / 100;
                    $discounted_price = $ppriceCalculation - $discount;
                } elseif ($discount_type == 'fixed') {
                    $discount = $rate_sale;
                    $discounted_price = $ppriceCalculation - $rate_sale;
                } else {
                    $discount = 0;
                    $discounted_price = $ppriceCalculation;
                }

           // }
            $pid =  $child_product_id;
            $_product = $product;

            if ($discount > get_post_meta($child_product_id, '_regular_price', true)) {
                $discount = get_post_meta($child_product_id, '_regular_price', true);
            }
            $sale_price =  get_post_meta($pid, '_price', true) - $discount;
            // only for geha 
            if($discount > 0){
                $sale_price =  get_post_meta($pid, '_regular_price', true) - $discount;
            }
            }
            $sale_price = number_format($sale_price, 2, '.', '');
            
           
            $still_available = get_post_meta($pid, 'still_available', true);
            $bogo_custom_title = get_post_meta($pid, 'bogo_custom_title', true);

            if ($custom_title != '') {
                $ptitle = $custom_title;
            }
            $str = '';

            $featured_img_url = get_the_post_thumbnail_url($child_product_id, 'full');
            if ($custom_image != '') {
                $featured_img_url = wp_get_attachment_image_url($custom_image, 'full');
            }
            $rdhc_discounted_price = '';
            /*
            if ($discount > 0) {
                $rdhc_discounted_price = 'data-rdh_sale_price="' . $sale_price . '"';
                $existing_value = get_user_meta($rdhc_user, 'rdhc_discounted_products', true);
                if ($existing_value == '') {
                    $existing_value = array();
                }
                $existing_value[$pid] = $sale_price;
                update_user_meta($rdhc_user, 'rdhc_discounted_products', $existing_value);
            }
            */
            if ($discount > 0) {


                if ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-geha_sale_price="' . $sale_price . '" data-geha_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'geha_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'geha_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == SWEAT_COIN_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-sweatcoin_sale_price="' . $sale_price . '" data-sweatcoin_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'sweatcoin_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'sweatcoin_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == ONE_DENTAL_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-1dental_sale_price="' . $sale_price . '" data-1dental_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, '1dental_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, '1dental_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == BENEFIT_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-benefithub_sale_price="' . $sale_price . '" data-benefithub_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'benefithub_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'benefithub_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == PERK_SPOT_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-perkspot_sale_price="' . $sale_price . '" data-perkspot_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'perkspot_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'perkspot_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == ABNENITY_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-abenity_sale_price="' . $sale_price . '" data-abenity_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'abenity_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'abenity_discounted_products', $existing_value);
                }
                else if ($GEHA_PAGE_ID == GOOD_RX_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-goodrx_sale_price="' . $sale_price . '" data-goodrx_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'goodrx_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'goodrx_discounted_products', $existing_value);
                }
                else if ($GEHA_PAGE_ID == UCC_PAGE_ID) {
                    $rdhc_discounted_price = 'data-ucc_sale_price="' . $sale_price . '" data-ucc_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'ucc_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'ucc_discounted_products', $existing_value);
                }else if ($GEHA_PAGE_ID == TELEDENTIST_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-teledentists_sale_price="' . $sale_price . '" data-teledentists_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'teledentists_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'teledentists_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == INSURANCE_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-insurance_lander_sale_price="' . $sale_price . '" data-insurance_lander="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'insurance_lander_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'insurance_lander_discounted_products', $existing_value);
                } else if ($GEHA_PAGE_ID == VIP_SALE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-vip_sale_price="' . $sale_price . '" data-vip_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'vip_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'vip_discounted_products', $existing_value);
                }
                else if ($GEHA_PAGE_ID == SHINE_PAGE_ID) {
                    $rdhc_discounted_price = 'data-shine_sale_price="' . $sale_price . '" data-shine_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'shine_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'shine_discounted_products', $existing_value);
                } 
                else if ($GEHA_PAGE_ID == CUSTOMER_DISCOUNT_PAGE_ID) {
                    $rdhc_discounted_price = 'data-sbrcustomer_sale_price="' . $sale_price . '" data-sbrcustomer_user="yes"';
                    $existing_value = get_post_meta($GEHA_PAGE_ID, 'sbrcustomer_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_post_meta($GEHA_PAGE_ID, 'sbrcustomer_discounted_products', $existing_value);
                } 
                else {
                    $rdhc_discounted_price = 'data-rdh_sale_price="' . $sale_price . '"';
                    $existing_value = get_user_meta($rdhc_user, 'rdhc_discounted_products', true);
                    if ($existing_value == '') {
                        $existing_value = array();
                    }
                    $existing_value[$pid] = $sale_price;
                    update_user_meta($rdhc_user, 'rdhc_discounted_products', $existing_value);
                }
               // $sale_price = number_format((float)$sale_price, 2, '.', '');
               $sale_price = number_format($sale_price, 2, '.', '');
            } else {


                if ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-geha_user="yes" ';
                } elseif ($GEHA_PAGE_ID == SWEAT_COIN_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-sweatcoin_user="yes" ';
                } elseif ($GEHA_PAGE_ID == ONE_DENTAL_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-1dental_user="yes" ';
                } elseif ($GEHA_PAGE_ID == PERK_SPOT_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-benefithub_user="yes" ';
                } elseif ($GEHA_PAGE_ID == INSURANCE_TEMPLATE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-insurance_lander="yes" ';
                }
                elseif ($GEHA_PAGE_ID == SHINE_PAGE_ID) {
                    $rdhc_discounted_price = ' data-shine_user="yes" ';
                }
                elseif ($GEHA_PAGE_ID == CUSTOMER_DISCOUNT_PAGE_ID) {
                    $rdhc_discounted_price = ' data-sbrcustomer_user="yes" ';
                }
            }
            $rec = 0;
            $btn = ' <button class="btn btn-primary-blue product_type_composite add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $child_product_id . '" ' . $rdhc_discounted_price . ' data-quantity="1" data-product_id="' . $child_product_id . '" data-rdhc_user_id="' . $rdhc_user . '" data-action="woocommerce_add_order_item" '.$coupon_string.'>'.$add_to_cart_text.'</button>';
            if ($add_to_cart == 'no') {
                //$btn = ' <a class="btn btn-primary-blue product_type_composite" href="'.$link_url.'" data-quantity="1" > Select a package</a>';
                $btn = '';
            }
            if ($add_to_cart == 'no' && $link_url != 'javascript:void(0);') {
                $btn_cat = ' <a class="btn btn-primary-blue product_type_composite" href="' . $link_url . '" data-quantity="1" > Select a package</a>';
            } else {
                $btn_cat = '<button class="btn btn-primary-blue btn-lg select-a-package" data-product_id="'.$product_id.'">Select a package</button>';
            }
            if ($recommended == 'yes') {
                $rec = 1;
            }
            $was_text_string = '<span class="wasText">was </span><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $_product->get_regular_price() . '</bdi></span></del>';
            if ($GEHA_PAGE_ID == GEHA_TEMPLATE_PAGE_ID) {
                $was_text_string = '<div class="wasTextParent-div"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $_product->get_regular_price() . '</bdi></span></del></div><span class="was-text2 wasText tyyyyyyyy discountedPriceForGehaMember">discounted price for GEHA members</span>';
            }
            if ($GEHA_PAGE_ID == UCC_PAGE_ID) {
                $was_text_string = '<div class="wasTextParent-div"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $_product->get_regular_price() . '</bdi></span></del></div><span class="was-text2 wasText tyyyyyyyy discountedPriceForGehaMember">discounted price for UCC members</span>';
            }
            if ($_product->is_on_sale() || $discount > 0) {
                //$callout_text = 'Sale!';
                //$str = '<span class="wasText">was </span><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $_product->get_regular_price() . '</bdi></span></del>';
                $str = $was_text_string;
            } else {
                if (strpos($callout_text, 'Sale') !== false) {
                    $callout_text = '';
                }
            }
            $data = '<div class="lander-shortcode" data-price="' . $sale_price . '" data-date="' . $post_date . '" data-recommended="' . $rec . '" data-tagging="' . $callout_text . '" data-cats="'.$product_cat_slug.'">
                <div class="product-selection-box">';
            if ($callout_text != 'Select') {
                $data .= '<div class="featureTag"><span>' . $callout_text . '</span></div>';
            }
            $average_text = get_field("average_price", $child_product_id);
            if ($average_text == '') {
                $average_text = 'normally';
            }
            $normal_text = get_field($page_normal_text_key, $child_product_id);
            if ($normal_text == '' && in_array($child_product_id, $normay_text_arr_products)) {
                if (str_contains($page_normal_text_string, 'GEHA')) {
                    $normal_text = $page_normal_text_string;
                } else {
                    $normal_text = str_replace('pprice', '$' . get_post_meta($child_product_id, '_regular_price', true), $page_normal_text_string);
                }
            }
            $data .= '<div class="product-selection-image-wrap">
                    <a href="' . $link_url . '">
                        <img src="' . $featured_img_url . '">
                    </a>
                    </div>
                    <div class="product-selection-description-parent">
                        <div class="product-selection-description-parent-inner">
                            <div class="product-selection-description">
                                <div class="starRatinGImage"><img src="' . home_url() . '/wp-content/uploads/2020/09/4.9-stars.png" alt=""></div>
                                <div class="small-desc">' . $description . '</div>
                                <div class="productDescriptionDiv hooooo"> <b>' . $ptitle . '</b></div>
                                <div class="productDescriptionFull">' . $content . '</div>
                                    <div class="product-selection-price-text-top featuredRow noflexDiv">
                                        <span class="product-selection-price-text heee">' . $str . '
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi><span class="woocommerce-Price-currencySymbol">$</span>' . $sale_price . '</bdi>
                                                </span>
                                            </ins>
                                        </span>
                                        <div class="normalyAmount italic forOnlyLayoutSixDisplay">' . $normal_text . '</div>
                                        <div class="featureShippingPrice">+free shipping</div>

                                    </div>
                                </div>
                                    <div class="normalyAmount italic">' . $normal_text . ' </div>
'.$dentist_discountedPrice.'                                    
                                <div class="product-selection-price-wrap redd">               
                            ' . $btn . '
                            </div>
                        ';
            $free_text = '';
            if (in_array($child_product_id, array(130269, 794933, 427602, 427704))) {
                // $free_text = '<strong style="color:red"> + Free Gift</strong>';
            }
            $select_package_html .= '<div class="packageRow">
         <div class="custom-radio form-group-radio-custom">
           <input type="radio" data-pid="' . $child_product_id . '" data-price="' . $sale_price . '" data-avr-price="' . $normal_text . '" id="' . $child_product_id . '" name="fav_language" ' . $rdhc_discounted_price . ' class="pacakge_selected_data" value="" />
           <label for="' . $child_product_id . '">
               <div class="radioButtonInner">
                 <span>' . get_the_title($child_product_id) . ' <span class="packagePrice">($' . $sale_price . ')</span>' . $free_text . ' </span>
               </div>

           </label>
         </div>
       </div>';
        endwhile;
if(is_user_logged_in() && get_current_user_id() == $rdhc_user && $dentist_page){
            
            $btn_cat = '<style>.drtext{display:none;}</style><div class="access-code-no-added">

                                <span class="selec-option-to-share italic-style"> Select one or more products to share</span>
                                <div class="product-selection-price-wrap added-button ony-dentist-page">                                
                                <div class="check-button">
                                    <input type="checkbox" id="'.$product_id.'" class="selected_for_share" name="radio-group" value="'.$product_id.'" >
                                    <label for="'.$product_id.'" class="btn">
                                        <span class="click-to-select">Click to Select</span>                                    
                                        <span class="added-text">Added!</span>
                                    </label>
                                </div>
                                </div>                                
                            </div>';
        }
        else{
            $btnshr ='<div class="product-selection-price-wrap selectpackageButton">
            <button class="btn btn-primary-blue btn-lg select-a-package" data-product_id="'.$product_id.'">Select a package</button>
          </div>';
        }
        $select_package_html .= '</div>

                </div>

              <div class="packageFooter">
                <div class="packageTotalPrice">
                <div class="priceparentBx"><span class="dollerSign">$</span><span class="packageAmount">20</span></div>
                    <div class="normalyAmount italic"><span class="targeted_avr"></span></div>
                </div>
                <div class="addToCartBottom openQuantityBox">
                   
                    <button
                    class="btn btn-primary-blue product_type_composite add_to_cart_button ajax_add_to_cart"
                    href="?add-to-cart=" data-quantity="1" ' . $rdhc_discounted_price . ' data-rdhc_user_id="' . $rdhc_user . '" 
                    data-product_id=""
                    data-action="woocommerce_add_order_item" '.$coupon_string.'>'.$add_to_cart_text.'</button>
                </div>
              </div>
            </div>

          </div>

          <div class="product-selection-price-wrap selectpackageButton">
            ' . $btn_cat . '
          </div>
        </div>';
        $data .= $select_package_html . '</div> </div> </div></div>';
        wp_reset_postdata();
        return $data;
    }
}

add_action('wp_loaded', 'testjson_users');
function testjson_users()
{
    if (isset($_GET['json_rdhc'])) {
        save_rdhc_in_JSON_file();
        echo 'yes';
        die();
    }
}
function buddyPressUserAfterSuccess($user_id, $key, $user)
{
    // save_rdhc_in_JSON_file();
    // cloneRdhPageById($user_id);
    // sbr_rdhc_invite_codes_query($user_id);


}
add_action('bp_core_activated_user', 'buddyPressUserAfterSuccess', 10, 3);

/*
Autogenerate page for exiswting users
*/
if (isset($_GET['create_Rdhc_page']) && $_GET['create_Rdhc_page'] != '') {
    add_action('init', 'autoGenRDHCPAgeForExistingUser');
    function autoGenRDHCPAgeForExistingUser()
    {
        $usrid = $_GET['create_Rdhc_page'];
        global $wpdb;
        $get_redhc_page = "SELECT post_id FROM wp_postmeta INNER JOIN wp_posts ON wp_posts.ID =  wp_postmeta.post_id WHERE meta_key='rdhc_id' AND meta_value = $usrid AND post_type='page' and post_status='publish'";
        $page_id = $wpdb->get_var($wpdb->prepare($get_redhc_page));
        if ($page_id == '') {
            cloneRdhPageById($usrid);
            $rdh_id = (int) $usrid;
            $user_info = get_userdata($rdh_id);
            $username = $user_info->user_login;
            if ($username == '') {
                $username = $rdh_id;
            }
            echo 'page is generated and title is Recommendations page for' . $username;
        } else {
            echo 'page already exists with id ' . $page_id;
        }
        die();
    }
}

add_action('woocommerce_thankyou', 'change_rdhc_commission_rates');
function change_rdhc_commission_rates($order_id)
{
    $affiliate_id =  get_post_meta($order_id, '_affiliate_id', true);
    if ($affiliate_id != '') {
        $affiliate = affwp_get_affiliate(absint($affiliate_id));
        $user_id = $affiliate->user_id;
        global $wpdb;
        $wpdp_query = "SELECT * FROM buddy_user_meta WHERE user_id =  $user_id ";
        $results = $wpdb->get_results($wpdp_query);
        if (count($results) > 0) {
            $rate_type = !empty($affiliate->rate_type) ? $affiliate->rate_type : '';
            $flat_rate_basis = !empty($affiliate->flat_rate_basis) ? $affiliate->flat_rate_basis : 'per_product';
            $rate = isset($affiliate->rate) ? $affiliate->rate : null;
            $rate = affwp_abs_number_round($affiliate->rate);
            if ($rate == 20) {
                affwp_update_affiliate(array('affiliate_id' => $affiliate_id, 'rate' => '10', 'rate_type' => 'percentage'));
            }
        }
    }
}
add_action('wp_ajax_update_rdh_publications', 'update_rdh_publications');
add_action('wp_ajax_nopriv_update_rdh_publications', 'update_rdh_publications');
add_action('wp_ajax_insert_rdh_publications', 'insert_rdh_publications');
add_action('wp_ajax_nopriv_insert_rdh_publications', 'insert_rdh_publications');

add_action('wp_ajax_get_rdh_publications', 'get_rdh_publications');
add_action('wp_ajax_nopriv_get_rdh_publications', 'get_rdh_publications');
add_action('wp_ajax_delete_rdh_publications', 'delete_rdh_publications');
add_action('wp_ajax_nopriv_delete_rdh_publications', 'delete_rdh_publications');



// Function to insert data into the wp_rdh_publications table
function insert_rdh_publications()
{

    global $wpdb;

    $pub_title = isset($_POST['pub_title']) ? sanitize_text_field($_POST['pub_title']) : '';
    $pub_category = isset($_POST['pub_category']) ? sanitize_text_field($_POST['pub_category']) : '';
    $sub_pub_category = isset($_POST['sub_pub_category']) ? sanitize_text_field($_POST['sub_pub_category']) : '';
    $publication_publisher = isset($_POST['publication_publisher']) ? sanitize_text_field($_POST['publication_publisher']) : '';
    $publisher_name_other = isset($_POST['publisher_name_other']) ? sanitize_text_field($_POST['publisher_name_other']) : '';
    $publicationDate = isset($_POST['publicationDate']) ? sanitize_text_field($_POST['publicationDate']) : '';
    $pub_authorName = isset($_POST['pub_authorName']) ? sanitize_text_field($_POST['pub_authorName']) : '';
    $pub_url = isset($_POST['pub_url']) ? sanitize_text_field($_POST['pub_url']) : '';
    $pub_description = isset($_POST['pub_description']) ? esc_textarea($_POST['pub_description']) : '';
    $pub_description = str_replace("'", "\'", $pub_description);
    if ($sub_pub_category != '') {
        $pub_category = $sub_pub_category;
    }
    if ($publisher_name_other != '') {
        $publication_publisher = $publisher_name_other;
    }

    $user_id = get_current_user_id();
    if ($pub_authorName != '') {
        $author_name = $pub_authorName;
    }
    $arr = array(
        'user_id' => $user_id,
        'pub_title' => $pub_title,
        'pub_category' => $pub_category,
        'publication_publisher' => $publication_publisher,
        'publicationDate' => $publicationDate,
        'pub_authorName' => $author_name,
        'pub_url' => $pub_url,
        'pub_description' => $pub_description
    );
    $errors = array();
    foreach ($arr as $key => $val) {
        if ($val == '' && $key != 'pub_authorName') {
            $errors[$key] = 'This Field is required';
        }
    }
    if (count($errors) > 0) {
        echo json_encode($errors);
        die();
    }
    $inserted = $wpdb->insert(
        'wp_rdh_publications',
        $arr
    );
    if (!$inserted) {
        $arr = array('status' => 'error');
        echo json_encode($arr);
        die();
    }
    echo 'success';
    die();
}

// Function to update data in the wp_rdh_publications table
function update_rdh_publications()
{
    global $wpdb;
    $pub_title = stripslashes(isset($_POST['pub_title']) ? sanitize_text_field($_POST['pub_title']) : '');
    $pub_category = stripslashes(isset($_POST['pub_category']) ? sanitize_text_field($_POST['pub_category']) : '');
    $sub_pub_category = stripslashes(isset($_POST['sub_pub_category']) ? sanitize_text_field($_POST['sub_pub_category']) : '');
    $publication_publisher = stripslashes(isset($_POST['publication_publisher']) ? sanitize_text_field($_POST['publication_publisher']) : '');
    $publisher_name_other = stripslashes(isset($_POST['publisher_name_other']) ? sanitize_text_field($_POST['publisher_name_other']) : '');
    $publicationDate = isset($_POST['publicationDate']) ? sanitize_text_field($_POST['publicationDate']) : '';
    $pub_authorName = stripslashes(isset($_POST['pub_authorName']) ? sanitize_text_field($_POST['pub_authorName']) : '');
    $pub_url = isset($_POST['pub_url']) ? sanitize_text_field($_POST['pub_url']) : '';
    $pub_description = stripslashes(isset($_POST['pub_description']) ? esc_textarea($_POST['pub_description']) : '');
    $pub_description = stripslashes(str_replace("'", "\'", $pub_description));
    $publication_id = stripslashes(isset($_POST['pub_id']) ? esc_textarea($_POST['pub_id']) : '');
    if ($sub_pub_category != '') {
        $pub_category = $sub_pub_category;
    }
    if ($publisher_name_other != '') {
        $publication_publisher = $publisher_name_other;
    }

    $user_id = get_current_user_id();

    if ($pub_authorName != '') {
        $author_name = $pub_authorName;
    }
    $arr = array(
        'user_id' => $user_id,
        'pub_title' => $pub_title,
        'pub_category' => $pub_category,
        'publication_publisher' => $publication_publisher,
        'publicationDate' => $publicationDate,
        'pub_authorName' => $author_name,
        'pub_url' => $pub_url,
        'pub_description' => $pub_description
    );
    $errors = array();
    foreach ($arr as $key => $val) {
        if ($val == '' && $key != 'pub_authorName') {
            $errors[$key] = 'This Field is required';
        }
    }
    if (count($errors) > 0) {
        echo json_encode($errors);
        die();
    }
    if ($publication_id == '') {
        $arr = array('status' => 'error', 'message' => 'Publication Id is empty');
        echo json_encode($arr);
        die();
    }
    // echo '<pre>';
    // print_r($arr);
    // die();
    $updated = $wpdb->update('wp_rdh_publications', $arr, array('id' => $publication_id));
    if (!$updated) {
        $arr = array('status' => 'error');
        echo json_encode($arr);
        die();
    }
    echo 'success';
    die();
}

// Function to read data from the wp_rdh_publications table
function get_rdh_publications()
{
    global $wpdb;
    $userid = $_REQUEST['user_id'];
    $my_publications = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM wp_rdh_publications WHERE user_id = %d",
            $userid
        )
    );
    $user_info = get_userdata($userid);
    $username = $user_info->user_login;
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;
    $author_name = $first_name . ' ' . $last_name;
    $rdhTitle = get_field('rdh_titleline', 'user_' . $userid);
    if ($rdhTitle) {
        $rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
    }
    $author_name = $author_name . $rdhTitle;
    $html = '';
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'author'        =>  $userid,
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
        'posts_per_page' => -1
    );

    $pub_counter = 0;
    $author_query = new WP_Query($args);

    while ($author_query->have_posts()) : $author_query->the_post();
        $aid = get_the_id();
        $pub_counter++;
        $categories = get_the_category();
        $category_name = '';
        if (!empty($categories)) {
            $category_name = esc_html($categories[0]->name);
        }
        $html .= '<div class="card">
        <a href="' . get_the_permalink($aid) . '">
            <div class="card-img">
                <img src="' . get_the_post_thumbnail_url($aid, 'full') . '" >
        
            </div>
            <div class="card-details">
                <div class="">
                    <small>' . stripslashes($category_name) . '</small>
                </div>
                <div class="card-title">
                    <h2>' . stripslashes(get_the_title($aid)) . '</h2>
                </div>

                </a>
                <div class="description mbtDescriptionRow">
                <div class="descriptionMbtTp">
                    <p>' . wp_trim_words(stripslashes(get_the_content($aid)), 20, '...') . '</p>
                    <p class="author">' . stripslashes($author_name) . '</span></p>
                </div>
                    <div class="action_buttons_mbt">
                    <div class="buttonRow_inner">
                        <a href="' . get_the_permalink($aid) . '" class="readmoreButton">    
                            READ MORE
                        </a>                   
                    </div> 
                    <div class="buttonRow_inner innerTwo">
                    </div>
                    </div>
                </div>
            </div>

        </div>';
    endwhile;
    wp_reset_postdata();
    if (is_array($my_publications) && count($my_publications) > 0) {
        $categories = get_categories();
        $related_categories = array();
        foreach ($categories as $category) {
            //  echo $category->slug.'=>'.$category->name.'<br />';
            $related_categories[$category->slug] = $category->name;
        }

        foreach ($my_publications as $pub) {

            $category_name = isset($related_categories[$pub->pub_category]) ? $related_categories[$pub->pub_category] : $pub->pub_category;
            $final_image = 'LOGO-RDHC-default.jpg';
            if (str_contains($pub->publication_publisher, 'Magazine')) {
                $final_image = 'LOGO-RDH-mag-purple.jpg';
            }
            if (str_contains($pub->publication_publisher, 'Dentistry')) {
                $final_image = 'LOGO-dentistyIQ.jpg';
            }
            if (str_contains($pub->publication_publisher, 'Todays')) {
                $final_image = 'LOGO-todays-rdh.jpg';
            }
            if (str_contains($pub->publication_publisher, 'Inside')) {
                $final_image = 'LOGO-inside-dental-hygiene.jpg';
            }
            if (str_contains($pub->publication_publisher, 'Dimensions')) {
                $final_image = 'LOGO-dimensions-of-dental-hygiene.jpg';
            }
            if (str_contains($pub->publication_publisher, 'Bicuspid')) {
                $final_image = 'logo-drbicuspid.jpg';
            }
            $rdhTitle = get_field('rdh_titleline', 'user_' . $userid);
            if ($rdhTitle) {
                $rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
            }

            if ($pub->pub_authorName != '') {
                $author_name_updated = $author_name . '<br ./>' . $pub->pub_authorName;
            } else {
                $author_name_updated = $author_name;
            }
            if ($pub->publication_publisher)
                $html .= '<div class="card">
        <a href="' . $pub->pub_url . '">
            <div class="card-img">
                <img src="' . get_stylesheet_directory_uri() . '/assets/images/rdh-article-thumbnail/' . $final_image . '" >

            </div>
            <div class="card-details">
                <div class="">
                    <small>' . stripslashes($category_name) . '</small>
                </div>
                <div class="card-title">
                    <h2>' . stripslashes($pub->pub_title) . '</h2>
                </div>
                
                </a>
                <div class="description mbtDescriptionRow">
                <div class="descriptionMbtTp">
                    <p>' . wp_trim_words(stripslashes($pub->pub_description), 20, '...') . '</p>
                    <p class="author">' . stripslashes($author_name_updated) . '</span></p>
                </div>
                    <div class="action_buttons_mbt">
                    <div class="buttonRow_inner">
                        <a href="' . $pub->pub_url . '" class="readmoreButton">    
                            READ MORE
                        </a>                   
                    </div> 
                    <div class="buttonRow_inner innerTwo">
                     <a href="javascript:void(0);" class="edit-pub" data-pub_id="' . $pub->id . '" data-pub_title="' . str_replace('"', '&quot;', stripslashes($pub->pub_title)) . '" data-pub_category="' . stripslashes($category_name) . '" data-publication_publisher="' . stripslashes($pub->publication_publisher) . '" data-publicationDate="' . $pub->publicationDate . '" data-pub_authorName="' . stripslashes($pub->pub_authorName) . '" data-pub_url="' . $pub->pub_url . '" data-pub_description="' . stripslashes($pub->pub_description) . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      EDIT</a>
                     <a href="javascript:void(0);" class="del-pub" data-pub_id="' . $pub->id . '" onclick="archiveFunction(' . $pub->id . ')"><i class="fa fa-trash-o" aria-hidden="true"></i>
                      DELETE</a>
                    </div>
                    </div>
                </div>
            </div>
       
    </div>';
        }
    } else {
        if ($pub_counter == 0) {
            $html .= '<h2>No Publications Found</h2>';
        }
    }
    echo $html;
    die();
}

// Function to delete data from the wp_rdh_publications table
function delete_rdh_publications()
{
    global $wpdb;
    $id = $_REQUEST['pub_id'];
    $res = array();
    if ($id == '') {
        $res['statusText'] = 'Publication id is not provided';
    }
    $deleted = $wpdb->delete(
        'wp_rdh_publications',
        array('id' => $id, 'user_id' => get_current_user_id())
    );
    if (!$deleted) {
        $res['statusText'] = $wpdb->last_error;
    } else {
        $res['statusText'] = 'success';
    }
    echo json_encode($res);
    die();
}
function show_chat_widget_rdh_profile($rdh_id)
{
    return false;
    if (get_query_var('buddyname') == false || get_query_var('buddyname') == '') {
        return false;
    }
    $rdh_user = get_userdata($rdh_id);
    $rdh_email = $rdh_user->user_email;
    $rdh_name = $rdh_user->display_name;

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $curr_user = get_userdata($user_id);
        $chat_user_image  = bp_core_fetch_avatar(
            array(
                'item_id' => $user_id, // id of user for desired avatar
                'type'    => 'full',
                'html'   => FALSE     // FALSE = return url, TRUE (default) = return img html
            )
        );
        $userRole = '';
        if (in_array('customer', (array) $curr_user->roles)) {
            $userRole = 'customer';
        }
        if (in_array('administrator', (array) $curr_user->roles)) {
            $userRole = 'admin';
        }
        $field_value = '';
        if(function_exists('bp_is_active')){
        $field_value = bp_get_profile_field_data(array(
            'field' => 'Referral',
            'user_id' => $user_id,

        ));
    }
        if ($field_value != '') {
            $userRole = 'RDHC';
        }
        $chatusername = $curr_user->display_name;
        $chatUserEmail =  $curr_user->user_email;
    } else {
        $chat_user_image = get_stylesheet_directory_uri() . '/assets/images/user_people_man.svg';
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        $customer_id = '';
        if (count($uri_segments) >= 5 && isset($uri_segments[4]) && $uri_segments[4] != '') {
            $customer_id  = $uri_segments[4];
        }
        if ($customer_id == '') {
            $cookie_key = 'cust_' . $uri_segments[3];
            $customer_id = isset($_COOKIE[$cookie_key]) ? $_COOKIE[$cookie_key] : '';
            if ($customer_id == '') {
                $cookie_key =  str_replace('.', '_', $cookie_key);
                $customer_id = isset($_COOKIE[$cookie_key]) ? $_COOKIE[$cookie_key] : '';
            }
            //    die();
        }
        if ($customer_id != '') {
            if (isset($uri_segments[4]) && $uri_segments[4] != '' && count($uri_segments) >= 5) {
                setcookie('cust_' . $uri_segments[3], $uri_segments[4], strtotime('+1 day'), '/');
            }

            // echo $uri_segments[3].'=>'.$uri_segments[4];
            // die();
            $url = CHAT_SBR_URL . '/get-user-by-id?_id=' . $customer_id;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response != 'Bad request' && $response != '') {
                $usernode = json_decode($response, true);
                //print_r($usernode);
                $chatusername = $usernode['name'];
                $chatUserEmail =  $usernode['email'];
            } else {

                $chatusername = '';
                $chatUserEmail =  '';
            }
        }
        //  $chatusername = $_GET['chat_user_name'];
        //   $chatUserEmail =  $_GET['chat_user_email'];
    }


    // $destination_email = $rdh_email;

    if ($chatUserEmail != '' && $chatUserEmail != $rdh_email) {
?>

        <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/socket.io.js"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/client.js"></script>
        <script>
            var destination_mail = '<?php echo $rdh_email; ?>';
            var chatUserEmail = '<?php echo $chatUserEmail; ?>';
            var userRole = '<?php echo $userRole; ?>';
            var chat_user_image = '<?php echo $chat_user_image; ?>';
            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

            var rdh_user_image = '<?php

                                    echo bp_core_fetch_avatar(

                                        array(

                                            'item_id' => $rdh_id, // id of user for desired avatar

                                            'type'    => 'full',

                                            'html'   => FALSE     // FALSE = return url, TRUE (default) = return img html

                                        )

                                    );

                                    ?>'
        </script>



        <style>
            #rdhContactForm {
                display: none !important;
            }
        </style>
        <div class="wrapperChatBoxMbt messageWrapperContainerBox" style="bottom:0">
            <div class="wrapperChatBoxMbtInner">
                <div class="chatBoxHeader">
                    <span class="displayName"><span class="status online"></span> <?php echo $rdh_name; ?> <div id="notifications" class="notificationIcon">0</div> </span>
                    <div class="headerButtons">
                        <a href="javascript:;" class="icons minimizeWindow">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:;" class="icons maximizeWindow">
                            <i class="fa fa-window-maximize" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:;" class="icons closeBox">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="chatBoxBody">
                    <div class="msg-s-event-listitem" id="chat-conversation-front">

                    </div>
                </div>


                <div class="chatBoxFooter">
                    <div class="chat-input-holder">
                        <input style="display:none" id="name" readonly class="form-control" value="<?php echo $chatusername; ?>" placeholder="Sender Name...">
                        <textarea id="message-client" class="chat-input" placeholder="Write message..."></textarea>
                        <button class="upScreenOption">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="footerContentWrapper">

                        <span id="typing-status"></span>
                        <div class="formUploadButton">
                            <div class="my-img"></div>
                            <div class="footerUploadFiles">
                                <form id="image-upload-form" enctype="multipart/form-data">
                                    <div class="buttonAction fileUpload blue-btn btn ">
                                        <span><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                                        <input type="file" name="image" id="file-input" class="uploadlogo">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="submitButton frontEndSendButton">
                            <button id="send" class="" onclick="submitMessage()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            //  var socket = io();
            var uploaded_image = '';
            idparent = chatUserEmail;
            let newStrid = idparent.replace('@', '-');
            newStr2 = newStrid.replace('.', '-');
            if (newStr2.includes("+")) {
                newStr2 = newStr2.replace('+', '-');
            }
            if (newStr2.includes(".")) {
                newStr2 = newStr2.replace('.', '-');
            }
            newStr2 = newStr2.replace(/[^\w\s]/g, '-');
            chat_user_id = '#front-' + newStr2;
            jQuery(document).ready(function() {
                jQuery('.messageWrapperContainerBox').attr('id', 'front-' + newStr2);
            });

            socket.emit('getUnreadMessages', chatUserEmail, destination_mail);
            getMessages();
            const inputField = document.querySelector('#message-client');
            const typingStatus = document.querySelector('#typing-status');

            // inputField.addEventListener('keydown', () => {
            //     socket.emit('typing');
            // });

            inputField.addEventListener('keyup', () => {
                socket.emit('stop_typing');
            });

            socket.on('typing', (isTyping) => {
                if (isTyping) {
                    typingStatus.textContent = 'User is typing...';
                } else {
                    typingStatus.textContent = '';
                }
            });

            function convertTextToLink(text) {
                if (text != '' && typeof text === 'string') {
                    var urlRegex = /(https?:\/\/[^\s]+)/g;
                    return text.replace(urlRegex, function(url) {
                        return '<a href="' + url + '" target="_blank">' + url + '</a>';
                    });
                }
                return text;

            }

            function addMessages(message) {

                actual_message = message.message;
                image_message = '';

                if (actual_message.includes("|img|")) {
                    myArray = actual_message.split("|img|");
                    actual_message = myArray[0];
                    image_message = myArray[1];
                    image_message = '<br /><a href="<?php echo CHAT_SBR_URL; ?>/uploads/' + image_message + '" target="_blank" class="imageViewer"><span class="viewImageLink"><i class="fa fa-eye" aria-hidden="true"></i></span><img style="max-width: 70px;" src="<?php echo CHAT_SBR_URL; ?>/uploads/' + image_message + '"></img></a>';
                }
                actual_message = convertTextToLink(actual_message);
                // if(message.receiver==chatUserEmail || message.sender==chatUserEmail) {
                if ((message.receiver == chatUserEmail && message.sender == destination_mail) || (message.receiver == destination_mail && message.sender == chatUserEmail)) {

                    if (message.receiver == chatUserEmail) {
                        cls = 'sender';
                        user_img = rdh_user_image;

                    } else {
                        cls = 'receiver';
                        user_img = chat_user_image;
                    }
                    var createdAt = new Date(message.time);
                    //alert(message.time);
                    // createdAt = createdAt-2000;
                    const formattedDate = createdAt.toLocaleString('en-US', {
                        timeZone: user_timezone,
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });

                    const timeDiffMs = new Date().getTime() - createdAt.getTime();
                    const timeInSeconds = Math.floor(timeDiffMs / 1000);
                    const timeInMinutes = Math.floor(timeInSeconds / 60);
                    const timeInHours = Math.floor(timeInMinutes / 60);
                    if (timeInMinutes == 'null' || timeInMinutes == null || typeof(timeInMinutes) == "undefined" || typeof(timeInHours) == "undefined" || isNaN(timeInHours)) {
                        result = `just now`;

                    } else if (timeInHours < 1) {
                        result = `${timeInMinutes} minutes ago`;
                    } else if (timeInHours < 24) {
                        const remainingMin = timeInMinutes % 60;
                        result = `${timeInHours} hours ${remainingMin} minutes ago`;
                    } else {
                        const date = new Date();
                        date.setTime(Date.now() - timeInSeconds * 1000);
                        result = `on ${date.toLocaleDateString()}`;
                    }
                    messageis_Read = '';
                    if (message.status == 'read') {
                        messageis_Read = '<span class="readDoubleTick"></span>';
                    }
                    html_send_rec = '<div class="message-' + cls + ' rowFlex"> <div class="messgerPicture onee"> <span class="userImageMbt"> <img src="' + user_img + '" alt="" data-src="' + user_img + '" decoding="async" class=" lazyloaded"><noscript><img src="' + user_img + '" alt="Abidoon Nadeem" data-eio="l"></noscript> </span> </div> <div class="messageBody"> <div class="messgerName"> <span>' + message.name + '</span> </div> <div class="messageBodyText"> ' + actual_message + image_message + ' </div><span class="posttime sssss">' + formattedDate + '</span>' + messageis_Read + ' </div> </div>';
                    $("#chat-conversation-front").append(html_send_rec);

                }
            }

            function getMessages() {

                obj = {
                    receiver: destination_mail,
                    sender: chatUserEmail
                };

                $.get('<?php echo CHAT_SBR_URL; ?>/ChatSbr', obj, (data) => {
                    data.forEach(addMessages);
                })
                socket.emit('updateMessageStatus', chatUserEmail, destination_mail, 'read');
            }


            function addNotification(message) {

                existing_counter = jQuery('#notifications').text();
                if (existing_counter == '') {
                    existing_counter = 0;
                }
                if (message.receiver == chatUserEmail && message.status == 'unread') {
                    count = parseInt(existing_counter);
                    count2 = ++count;
                    $("#notifications").html(count2);
                }

            }

            function sendMessage(message) {
                socket.emit('updateMessageStatus', chatUserEmail, destination_mail, 'read');
                $.post('<?php echo CHAT_SBR_URL; ?>/ChatSbr', message)
                $("#message-client").val("");

                // socket.emit('getUnreadMessages',chatUserEmail,destination_mail);
            }


            socket.on('Chat', addMessages);
            //socket.on('getNotificationmessages', getNotificationmessages);
            socket.on('getNotificationmessages', (results, receiver_id, sender_id) => {
                // results.forEach(addNotification);
                if (receiver_id == chatUserEmail) {
                    $("#notifications").html(results.length);

                }
            });

            setTimeout(function() {

                jQuery(".chatBoxBody").scrollTop(jQuery(".chatBoxBody")[0].scrollHeight);
            }, 2000)

            function submitMessage() {

                message_val = $("#message-client").val();

                setTimeout(function() {
                    jQuery(".chatBoxBody").scrollTop(jQuery(".chatBoxBody")[0].scrollHeight);
                }, 500)
                if (message_val == '' && uploaded_image == '') {
                    return false;
                }
                if (uploaded_image != '') {
                    message_val = message_val + '|img|' + uploaded_image;
                    jQuery(chat_user_id).find('#image-upload-form')[0].reset();
                    uploaded_image = '';
                    jQuery(chat_user_id).find('.my-img').html('');

                }
                object = {
                    name: $("#name").val(),
                    message: message_val,
                    sender: chatUserEmail,
                    receiver: destination_mail
                };

                resp = sendMessage(object);
            }
        </script>
        <script>
            const imageUploadForm = document.getElementById('image-upload-form');
            const imageUploadButton = imageUploadForm.querySelector('button');
            const imageUploadInput = imageUploadForm.querySelector('input[type="file"]');
            const fileInput = document.getElementById('file-input');

            const uploader = new SocketIOFileUpload(socket);

            uploader.listenOnInput(fileInput);

            socket.on('file_uploaded_front', function(data) {

                uploaded_image = data.file.name;
                html_obj = '<div class="img-prev"><img  src="<?php echo CHAT_SBR_URL; ?>/uploads/' + uploaded_image + '"></img> <div class="cross"><span class="cross">×</span></div></div>';
                jQuery(chat_user_id).find('.my-img').html(html_obj);
                jQuery(chat_user_id).find('.my-img').addClass('hello');

            });
            jQuery(document).on('click', '.cross', function() {
                jQuery(chat_user_id).find('#image-upload-form')[0].reset();
                jQuery(chat_user_id).find('.my-img').html('');
                uploaded_image = '';
            });
        </script>
    <?php
    }
}

function show_chat_widget_rdh_backend($rdh_id)
{
    return  false;
    $rdh_user = get_userdata($rdh_id);
    $rdh_email = $rdh_user->user_email;
    $rdh_name = $rdh_user->display_name;
    $chatusername = '';
    $chatUserEmail = '';
    $chat_user_image = get_stylesheet_directory_uri() . '/assets/images/user_people_man.svg';
    $rdh_user_image = get_stylesheet_directory_uri() . '/assets/images/user_people_man.svg';
    ?>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/socket.io.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/client.js"></script>
    <script>
        function getQueryParams() {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams;
        }
        // jQuery(document).ready(function() {
        //     setTimeout(function() {
        //         jQuery('.sidebarOption ul li:first-child a').trigger('click');
        //         jQuery(".sidebarOption ul li:first-child a").addClass("activeChatUser");
        //     }, 500);
        // });
        var queryParams = getQueryParams();
        var destination_mail = '<?php echo $chatUserEmail; ?>';
        var chatUserEmail = '<?php echo $rdh_email; ?>';
        var userRole = 'RDHC';
        var curreUSerId = '<?php echo $rdh_id; ?>';
        var rdhcs_list = '';
        fetch('/wp-content/themes/revolution-child/assets/rdhcs.json?ver=<?php echo rand(10, 523658554); ?>')
            .then(response => response.json())
            .then(data => {
                rdhcs_list = data;

            });

        rdhcs_list = <?php echo get_option('rdhcs_json'); ?>

        var rdhAddress = queryParams.get('rdh_address');
        if (rdhAddress) {
            jQuery(".chatBoxWrapperContainer").addClass("showChatBox");

            jQuery(".sidebarOption  ul li").removeClass("activeChatUser");

            jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').empty();

            jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').append(rdhAddress);
            // destination_mail = jQuery(this).attr('data-email');
            jQuery('#chat-conversation').html('');



            setTimeout(function() {
                // jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').append("aasfdasfsfsf");
                jQuery("#chat-conversation").scrollTop($("#chat-conversation")[0].scrollHeight);
            }, 500);

            //  getMessages();
            //  socket.emit('getUnreadMessages', chatUserEmail, destination_mail);
        }
        jQuery(document).on('click', '.selectChatUser', function() {

            jQuery(".chatBoxWrapperContainer").addClass("showChatBox");

            jQuery(".sidebarOption  ul li").removeClass("activeChatUser");
            jQuery(this).addClass("activeChatUser");
            jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').empty();
            var getTextMbt = jQuery(this).addClass("activeChatUser").find('.getName').html();
            jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').append(getTextMbt);
            destination_mail = jQuery(this).attr('data-email');
            jQuery('#chat-conversation').html('');



            setTimeout(function() {
                // jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').append("aasfdasfsfsf");
                jQuery("#chat-conversation").scrollTop($("#chat-conversation")[0].scrollHeight);
            }, 500);

            getMessages();
            socket.emit('getUnreadMessages', chatUserEmail, destination_mail);
        });
        jQuery(document).ready(function() {
            getMyChats();
            setInterval(function() {
                getMyChats();
            }, 1000000);


            // jQuery.getJSON('/wp-content/themes/revolution-child/assets/rdhcs.json', function(data) {         
            //    var rdhcs_list = data;
            //     console.log(data);
            // });

        });




        // jQuery(document).on('click', '.selectChatUser', function() {

        var isMobile = $(window).width() < 768;
        if (isMobile) {
            jQuery(document).on('click', '.selectChatUser', function() {
                var mobileNav = $('.jumbotron.messageBodyChar');
                mobileNav.addClass('openNavigationOverlay');

                // var offsetTop = mobileNav.offset().top-80;                    
                // $('html, body').animate({
                //     scrollTop: offsetTop
                // }, 'slow');                

            });
        }
        // });
        jQuery(document).on('click', '.chatHeaderRight', function() {
            // jQuery('.chatHeaderRight').on('click', function() {  
            jQuery('.jumbotron.messageBodyChar').removeClass('openNavigationOverlay');
        });
    </script>
    <div class="container sidebarChatSystems chatWrapperContainer">

        <style>
            .accountDashboardMes {
                max-width: 100%;
            }
        </style>

        <div class="messageContainerWrapper">



            <div class="member-listing-wrapper">
                <div class="tab-content">
                    <div class="tab-pane">
                        <div class="list-group">
                            <a href="javascript:;">
                                <span class="name" style="min-width: 120px;
                                        display: inline-block;">Bhaumik Patel</span>
                                <span class="">This is big title</span>
                                <span class="text-muted" style="font-size: 11px;">- Hi hello how r u ?</span>
                                <span class="badge">12:10 AM</span>
                                <span class="pull-right"><span class="glyphicon glyphicon-paperclip">
                                    </span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- member-listing-wrapper -->



            <div class="rowTopMbt">
                <h3>RDHC Messaging</h3>
            </div>
            <div class="rowMbt libellMessage">
                <div class="messageNotification ">
                    <div class="messageWrapper">
                        <div class="sidebarOption">
                            <div class="dropdownHeaderr">
                                <div class="searchPanel">
                                    <input type="search" class="form-control disabledField" placeholder="Chats">
                                    <!-- <button><i class="fa fa-search" aria-hidden="true"></i></button> -->
                                </div>
                                <!-- <span class="messageText">Messages</span> -->
                            </div>

                            <div class="group-accordion">

                                <div class="accordion">

                                </div>


                            </div>

                            <div id="DZ_W_Notificationn1" class="widget-media dz-scroll">
                                <ul class=" user-messages-<?php echo $rdh_id; ?>">
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jumbotron messageBodyChar">
                <div class="chatHeaderRight">
                    <div class="backToChatList">
                        <a href="javascript:;">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <h4></h4>
                    <span class="notificationCounter messagecounter-<?php echo $rdh_id; ?>">0</span>
                </div>
                <div id="chat-conversation">
                    <?php
                    $rdh_address = '';

                    if (isset($_GET['rdh_address']) && $_GET['rdh_address'] != '') {
                        $rdh_address = $_GET['rdh_address'];
                        $arr_redh =  explode(',', $rdh_address);
                        if (count($arr_redh) > 0) {
                    ?>
                            <div class="userEmailSelectWrapper"> <!-- Parent div added here -->
                                <?php
                                foreach ($arr_redh as $r) {
                                ?>
                                    <div class="rdh_user_message" data-rdh_email="<?php echo $r; ?>">
                                        <span><?php echo $r; ?></span>
                                        <span class="crossrdh"><i class="fa fa-times" aria-hidden="true"></i> </span>
                                    </div>
                                <?php
                                }
                                ?>
                            </div> <!-- Close the parent div here -->
                    <?php
                        }
                    }
                    ?>
                </div>

                <input style="display:none" id="name" readonly class="form-control" value="<?php echo $rdh_name; ?>" placeholder="Sender Name...">

                <div class="subject-wrapper">
                    <?php
                    $grpclass = '';
                    if ($rdh_address != '') {
                        $grpclass = 'forGruopMessage';
                    ?>
                        <script>
                            jQuery(".sidebarChatSystems ").addClass("subjectAddedJs");
                        </script>
                        <div class="subject-field">
                            <input type="text" name="subject" id="subject_rdh" required placeholder="Type a subject here">
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="textareaoverLap <?php echo $grpclass; ?>">

                    <textarea id="message" class="form-control" placeholder="write message..."></textarea>

                    <!-- <span id ="typing-status"></span> -->
                    <div class="footerContentWrapper">
                        <div class="formUploadButton">
                            <div class="my-img"></div>
                            <div class="footerUploadFiles">
                                <form id="image-upload-form" enctype="multipart/form-data">
                                    <div class="buttonAction fileUpload blue-btn btn">
                                        <span><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                                        <input type="file" name="image" id="file-input" value="abcdefgh-mindblazetech-com" class="uploadlogo">
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="submitButton backendSendButton">
                            <button id="send" class="" onclick="submitMessage()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //var socket = io();
        rdh_addresses_email = [];
        var chat_user_image = '<?php echo $chat_user_image ?>';
        var rdh_user_image = '<?php echo $rdh_user_image ?>'
        const inputField = document.querySelector('#message');
        const typingStatus = document.querySelector('#typing-status');
        var uploaded_image = '';
        idparent = chatUserEmail;
        let newStrid = idparent.replace('@', '-');
        newStr2 = newStrid.replace('.', '-');
        if (newStr2.includes("+")) {
            newStr2 = newStr2.replace('+', '-');
        }
        if (newStr2.includes(".")) {
            newStr2 = newStr2.replace('.', '-');
        }
        newStr2 = newStr2.replace(/[^\w\s]/g, '-');
        chat_user_id = '#' + newStr2;
        // chat_user_id = chat_user_id.trim;
        jQuery(document).ready(function() {
            jQuery('.messageContainerWrapper').attr('id', newStr2);
        });
        // inputField.addEventListener('keydown', () => {
        //     socket.emit('typing');
        // });
        jQuery(document).on('click', '.crossrdh', function() {
            rdh_addresses_email.push(jQuery(this).parents('.rdh_user_message').attr('data-rdh_email'));
            jQuery(this).parents('.rdh_user_message').remove();
        });
        inputField.addEventListener('keyup', () => {
            socket.emit('stop_typing');
        });


        // accordion group member
        function addChatGroup(grp) {
            html_accordian = '';
            receivers = grp.receiver;
            inner_html = '';
            $full_name = '';
            if (receivers.length > 0) {
                const receiverArray = JSON.parse(receivers);

                new_rec = '';
                // Step 2: Loop through the receiver array and do whatever you need with each receiver
                for (const receiver of receiverArray) {
                    inner_html += '<div class="accordion-content"><p>' + receiver + '</p></div>';
                    var meta_value_rdh = rdhcs_list[receiver];

                    svg_link = '<?php echo home_url(); ?>/wp-content/uploads/2020/07/smilebrilliant-logomark-200x200-1.png';
                    timeline = '';

                    let newStr = receiver.replace('@', '-');
                    newStr = newStr.replace('.', '-');
                    if (newStr.includes("+")) {
                        newStr = newStr.replace('+', '-');
                    }
                    if (newStr.includes(".")) {
                        newStr = newStr.replace('.', '-');
                    }
                    newStr = newStr.replace(/[^\w\s]/g, '-');
                    if (typeof rdhcs_list[receiver] != "undefined") {
                        svg_link = '<?php echo home_url(); ?>/wp-content/themes/revolution-child/assets/images/rdh-profile/RDH-logo.svg';
                        timeline = meta_value_rdh['timeline'];
                        $full_name = meta_value_rdh['full_name'];
                    } else {
                        timeline = '';
                    }
                    new_rec += '<div class="selectChatUser" data-email="' + receiver + '"><a href="javascript:;"><div class="timeline-panel"><div class="media-body"><div class="messgerPicture rdhLogoMbt"> <div class="notificationCounter notifications-' + newStr + ' mbt-mess-not"></div><span class="userImageMbt"> <img src="' + svg_link + '" alt=""  class="userImageProfile"></span> </div> <h6 class="mb-0"><span class="getName">' + $full_name + ' <div class="rdhTagLine"><span class="gettitle">' + timeline + ' </span></div></span>  <div class="messaegTimeDisplay"><small class="d-block"> 02:26 PM</small></div></h6></div></div></a> </div>';
                    //console.log(new_rec);
                }
            }
            // console.log(html_accordian);
            html_accordian = '<div class="accordion-list"><div class="accordion-header"><h3 class="d-flex align-items-center justify-content-between">' + grp.subject + ' <span class="accordion-arrow"></span> </h3> <p>Lets be honest, SaaS spend is...</p></div><div class="accordion-content"><div class="accordion-content-inner">' + new_rec + '</div></div></div>';
            console.log(html_accordian);
            jQuery('.accordion').append(html_accordian);
        }
        $(document).ready(function() {
            obj = {
                sender: chatUserEmail
            };
            console.log(obj);
            $.get('<?php echo CHAT_SBR_URL; ?>/chatgroups', obj, (data) => {
                data.forEach(addChatGroup);
            });
            // Toggle accordion content on click

        });

        jQuery(document).on('click', '.accordion-header', function() {

            if (!jQuery(this).hasClass('open')) {
                // Close all other open accordion sections
                jQuery('.accordion-header.open').removeClass('open');
                jQuery('.accordion-content').slideUp();
            }
            // Toggle the current accordion section
            jQuery(this).toggleClass('open').next('.accordion-content').slideToggle();
            jQuery(this).find('.accordion-arrow').toggleClass('rotate');


            // jQuery(this).toggleClass('open').next('.accordion-content').slideToggle();
            // jQuery(this).find('.accordion-arrow').toggleClass('rotate');
        });

        // $(document).find('.accordion-header').click(function() {
        //     $(this).toggleClass('open').next('.accordion-content').slideToggle();
        //         $(this).find('.accordion-arrow').toggleClass('rotate');
        //         });

        // socket.on('typing', (isTyping) => {
        //     if (isTyping) {
        //         typingStatus.textContent = 'User is typing...';
        //     } else {
        //         typingStatus.textContent = '';
        //     }
        // });

        function convertTextToLink(text) {
            if (text != '' && typeof text === 'string') {
                var urlRegex = /(https?:\/\/[^\s]+)/g;
                return text.replace(urlRegex, function(url) {
                    return '<a href="' + url + '" target="_blank">' + url + '</a>';
                });
            }
            return text;
        }

        function addMessages(message) {
            actual_message = message.message;
            image_message = '';
            if (actual_message.includes("|img|")) {
                myArray = actual_message.split("|img|");
                actual_message = myArray[0];
                image_message = myArray[1];
                image_message = '<br /><a href="<?php echo CHAT_SBR_URL; ?>/uploads/' + image_message + '" target="_blank" class="imageViewer"><span class="viewImageLink"><i class="fa fa-eye" aria-hidden="true"></i></span><img style="max-width: 70px;" src="<?php echo CHAT_SBR_URL; ?>/uploads/' + image_message + '"></img></a>';
            }
            actual_message = convertTextToLink(actual_message);
            if (message.receiver == chatUserEmail) {
                cls = 'receiver';
                //user_img = rdh_user_image;

                if (typeof rdhcs_list[message.sender] != "undefined") {
                    user_img = rdhcs_list[message.sender]['profile_pic'];
                } else {
                    user_img = rdh_user_image;
                }

            } else {
                cls = 'sender';
                user_img = chat_user_image;
            }

            const createdAt = new Date(message.time);
            const formattedDate = createdAt.toLocaleString('en-US', {
                timeZone: user_timezone,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const timeDiffMs = new Date().getTime() - createdAt.getTime();
            const timeInSeconds = Math.floor(timeDiffMs / 1000);
            const timeInMinutes = Math.floor(timeInSeconds / 60);
            const timeInHours = Math.floor(timeInMinutes / 60);
            if (timeInMinutes == 'null' || timeInMinutes == null || typeof(timeInMinutes) == "undefined" || typeof(timeInHours) == "undefined" || isNaN(timeInHours)) {
                result = `just now`;

            } else if (timeInHours < 1) {
                result = `${timeInMinutes} minutes ago`;
            } else if (timeInHours < 24) {
                const remainingMin = timeInMinutes % 60;
                result = `${timeInHours} hours ${remainingMin} minutes ago`;
            } else {
                const date = new Date();
                date.setTime(Date.now() - timeInSeconds * 1000);
                result = `on ${date.toLocaleDateString()}`;
            }


            if ((message.receiver == chatUserEmail && message.sender == destination_mail) || (message.receiver == destination_mail && message.sender == chatUserEmail)) {
                messageis_Read = '';
                if (message.status == 'read') {
                    messageis_Read = '<span class="readDoubleTick"></span>';
                }
                html_send_rec = '<div class="message-' + cls + ' rowFlex"> <div class="messgerPicture twoo"> <span class="userImageMbt"> <img src="' + user_img + '" alt="" data-src="' + user_img + '" decoding="async" class=" lazyloaded"><noscript><img src="' + user_img + '" alt="Abidoon Nadeem" data-eio="l"></noscript> </span> </div> <div class="messageBody"> <div class="messgerName"> <span>' + message.name + '</span> </div> <div class="messageBodyText"> ' + actual_message + image_message + ' </div><span class="posttime tttt">' + formattedDate + '</span> ' + messageis_Read + ' </div> </div>';
                $("#chat-conversation").append(html_send_rec);
                //$("#chat-conversation").append('<div class="message-'+cls+' rowFlex"><strong>'+message.name.charAt(0).toUpperCase()+message.name.slice(1)+'</strong> says: <br><span>'+actual_message+image_message+'</span></div><hr/>');
            }
        }

        function addMyChat(rec) {

            let newStr = rec.sender.replace('@', '-');
            newStr = newStr.replace('.', '-');
            if (newStr.includes("+")) {
                newStr = newStr.replace('+', '-');
            }
            if (newStr.includes(".")) {
                newStr = newStr.replace('.', '-');
            }
            newStr = newStr.replace(/[^\w\s]/g, '-');
            // search for user by email address

            var meta_value_rdh = rdhcs_list[rec.sender];
            svg_link = '<?php echo home_url(); ?>/wp-content/uploads/2020/07/smilebrilliant-logomark-200x200-1.png';
            timeline = '';
            //if(meta_value_rdh !='undefined ' && meta_value_rdh !='undefined'  && meta_value_rdh !=undefined){
            //  if (rec.sender in rdhcs_list){

            if (typeof rdhcs_list[rec.sender] != "undefined") {
                svg_link = '<?php echo home_url(); ?>/wp-content/themes/revolution-child/assets/images/rdh-profile/RDH-logo.svg';
                // svg_link = meta_value_rdh['profile_pic'];
                timeline = meta_value_rdh['timeline'];


            } else {
                timeline = '';
            }
            new_rec = '<div class="selectChatUser" data-email="' + rec.sender + '"> ' + rec.name + ' Notifications:   </div>';

            new_rec = '<li class="selectChatUser" data-email="' + rec.sender + '"><a href="javascript:;"><div class="timeline-panel"><div class="media-body"><div class="messgerPicture rdhLogoMbt"> <div class="notifications-' + newStr + ' mbt-mess-not notificationCounter"></div><span class="userImageMbt"> <img src="' + svg_link + '" alt=""  class="userImageProfile"></span> </div> <h6 class="mb-0"><span class="getName">' + rec.name + ' <div class="rdhTagLine"><span class="gettitle">' + timeline + ' </span></div></span>  <div class="messaegTimeDisplay"><small class="d-block"> 02:26 PM</small></div></h6></div></div></a> </li>';
            append_id = ".user-messages-" + curreUSerId;
            jQuery(append_id).append(new_rec);
            socket.emit('getUnreadMessages', rec.receiver, rec.sender);
        }


        function getMessages() {

            if (destination_mail != '') {
                obj = {
                    receiver: destination_mail,
                    sender: chatUserEmail
                };

                $.get('<?php echo CHAT_SBR_URL; ?>/ChatSbr', obj, (data) => {
                    data.forEach(addMessages);
                })
                socket.emit('updateMessageStatus', chatUserEmail, destination_mail, 'read');
            }
        }

        function getMyChats() {

            obj = {
                receiver_id: chatUserEmail
            };

            $.get('<?php echo CHAT_SBR_URL; ?>/myChates', obj, (data) => {
                append_id = ".user-messages-" + curreUSerId;
                jQuery(append_id).html('');
                data.forEach(addMyChat);
            })
        }

        function addNotification(message) {
            existing_counter = jQuery('#notifications').text();
            if (existing_counter == '') {
                existing_counter = 0;
            }
            if (message.receiver == chatUserEmail) {
                count = parseInt(existing_counter);
                count2 = ++count;
                $("#notifications").html(count2);
            }
        }

        function sendMessage(message) {
            socket.emit('updateMessageStatus', chatUserEmail, destination_mail, 'read');
            $.post('<?php echo CHAT_SBR_URL; ?>/ChatSbr', message)
            $("#message").val("");

        }
        socket.on('Chat', addMessages);
        socket.on('getNotificationmessages', (results, receiver_id, sender_id) => {
            if (typeof sender_id == 'undefined') {
                return false;
            }
            //results.forEach(addNotification);
            let newStr = sender_id.replace('@', '-');
            newStr = newStr.replace('.', '-');
            if (newStr.includes("+")) {
                newStr = newStr.replace('+', '-');
            }
            if (newStr.includes(".")) {
                newStr = newStr.replace('.', '-');
            }
            newStr = newStr.replace(/[^\w\s]/g, '-');
            notifications_dev = ".notifications-" + newStr;
            notifications_dev_org = "notifications-" + newStr;


            if (receiver_id == chatUserEmail) {

                if ($(notifications_dev).length) {
                    //
                } else {
                    getMyChats();
                }
                jQuery(notifications_dev).html(results.length);
                if (results.length > 0) {
                    jQuery(notifications_dev).parents('.selectChatUser').addClass('hasNotifications');
                } else {
                    jQuery(notifications_dev).parents('.selectChatUser').removeClass('hasNotifications');
                }
                updateAllMessagesCounter();
            } else {

            }

        });

        function updateAllMessagesCounter() {
            existing_Counter = 0;
            jQuery(document).find('.mbt-mess-not').each(function() {
                count = jQuery(this).text();
                if (count == '' || count == ' ') {
                    count = 0;
                }

                intval = parseInt(count);
                // alert(intval);
                existing_Counter = existing_Counter + intval;
            });
            cls = ".messagecounter-" + curreUSerId;
            jQuery(cls).html(existing_Counter);
        }

        function submitMessage() {
            message_val = $("#message").val();

            setTimeout(function() {
                jQuery("#chat-conversation").scrollTop(jQuery("#chat-conversation")[0].scrollHeight);
            }, 500)
            if (message_val == '' && uploaded_image == '') {
                return false;
            }
            if (uploaded_image != '') {
                message_val = message_val + '|img|' + uploaded_image;
                jQuery(chat_user_id).find('#image-upload-form')[0].reset();
                uploaded_image = '';
                jQuery(chat_user_id).find('.my-img').html('');
            }
            var queryParams2 = getQueryParams();
            var rdhAddress2 = queryParams2.get('rdh_address');

            var subjectparam = jQuery("#subject_rdh").val();

            if (rdhAddress2 && subjectparam != '') {
                var emailAddresses2 = rdhAddress2.split(',');
                emailAddresses2 = emailAddresses2.filter(function(el) {
                    return !rdh_addresses_email.includes(el);
                });
                console.log(emailAddresses2);
                groupMessage = {
                    subject: subjectparam,
                    sender: chatUserEmail,
                    receiver: JSON.stringify(emailAddresses2)
                };
                $.post('<?php echo CHAT_SBR_URL; ?>/ChatGroup', groupMessage);
                for (var i = 0; i < emailAddresses2.length; i++) {
                    var email2 = emailAddresses2[i];
                    console.log(rdh_addresses_email);
                    if (rdh_addresses_email.includes(email2)) {

                        continue;
                    }
                    console.log("Email Address " + (i + 1) + ": " + email2.trim());
                    object = {
                        name: $("#name").val(),
                        message: message_val,
                        sender: chatUserEmail,
                        receiver: email2.trim()
                    };
                    resp = sendMessage(object);
                    if (i == emailAddresses2.length - 1) {
                        setTimeout(function() {
                            window.location.href = "<?php echo home_url(); ?>/my-account/support/?active-tab=chat";
                        }, 1000);

                    }
                }

            } else {
                object = {
                    name: $("#name").val(),
                    message: message_val,
                    sender: chatUserEmail,
                    receiver: destination_mail
                };
                resp = sendMessage(object);
            }
        }



        // Function to extract email addresses from the rdh_address parameter


        // Call the function to extract and loop through email addresses
    </script>
    <script>
        const imageUploadForm = document.getElementById('image-upload-form');
        const imageUploadButton = imageUploadForm.querySelector('button');
        const imageUploadInput = imageUploadForm.querySelector('input[type="file"]');
        const fileInput = document.getElementById('file-input');
        var radn_class = '';

        $('.fileUpload').click(function() {

            radn_class = 'cls' + Math.floor(Math.random() * 56888944) + 1;
            jQuery(document).find('.messageContainerWrapper').addClass(radn_class);
            //  setTimeout(function(){jQuery(document).find('.messageContainerWrapper').addClass(radn_class);}, 1000);

        });
        const uploader = new SocketIOFileUpload(socket);

        uploader.listenOnInput(fileInput);
        socket.on('file_uploaded_back', function(data) {
            uploaded_image = data.file.name;
            radn_class_act = '.' + radn_class;
            html_obj = '<div class="img-prev"><span class="viewImageLink"><i class="fa fa-eye" aria-hidden="true"></i></span><img style="max-width: 70px;" src="<?php echo CHAT_SBR_URL; ?>/uploads/' + uploaded_image + '"></img> <div class="cross"><span class="cross">×</span></div></div>';
            jQuery(radn_class_act).find('.my-img').html(html_obj);

        });
        jQuery(document).on('click', '.cross', function() {
            radn_class_act = '.' + radn_class;
            jQuery(radn_class_act).find('#image-upload-form')[0].reset();
            jQuery(radn_class_act).find('.my-img').html('');
            uploaded_image = '';
        });
    </script>
<?php
}
function show_chat_widget_rdh_backend_old($rdh_id)
{
    $rdh_user = get_userdata($rdh_id);
    $rdh_email = $rdh_user->user_email;
    $rdh_name = $rdh_user->display_name;
    $chatusername = '';
    $chatUserEmail = '';
    $chat_user_image = get_stylesheet_directory_uri() . '/assets/images/user_people_man.svg';
    $rdh_user_image = get_stylesheet_directory_uri() . '/assets/images/user_people_man.svg';
?>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/socket.io.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/client.js"></script>
    <script>
        // jQuery(document).ready(function() {
        //     setTimeout(function() {
        //         jQuery('.sidebarOption ul li:first-child a').trigger('click');
        //         jQuery(".sidebarOption ul li:first-child a").addClass("activeChatUser");
        //     }, 500);
        // });

        var destination_mail = '<?php echo $chatUserEmail; ?>';
        var chatUserEmail = '<?php echo $rdh_email; ?>';
        var userRole = 'RDHC';
        var curreUSerId = '<?php echo $rdh_id; ?>';
        var rdhcs_list = '';
        fetch('/wp-content/themes/revolution-child/assets/rdhcs.json?ver=<?php echo rand(10, 523658554); ?>')
            .then(response => response.json())
            .then(data => {
                rdhcs_list = data;

            });

        rdhcs_list = <?php echo get_option('rdhcs_json'); ?>

        jQuery(document).on('click', '.selectChatUser', function() {

            jQuery(".chatBoxWrapperContainer").addClass("showChatBox");

            jQuery(".sidebarOption  ul li").removeClass("activeChatUser");
            jQuery(this).addClass("activeChatUser");
            jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').empty();
            var getTextMbt = jQuery(this).addClass("activeChatUser").find('.getName').html();
            jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').append(getTextMbt);
            destination_mail = jQuery(this).attr('data-email');
            jQuery('#chat-conversation').html('');



            setTimeout(function() {
                // jQuery('.jumbotron.messageBodyChar .chatHeaderRight h4').append("aasfdasfsfsf");
                jQuery("#chat-conversation").scrollTop($("#chat-conversation")[0].scrollHeight);
            }, 500);

            getMessages();
            socket.emit('getUnreadMessages', chatUserEmail, destination_mail);
        });
        jQuery(document).ready(function() {
            getMyChats();
            setInterval(function() {
                getMyChats();
            }, 1000000);


            // jQuery.getJSON('/wp-content/themes/revolution-child/assets/rdhcs.json', function(data) {         
            //    var rdhcs_list = data;
            //     console.log(data);
            // });

        });




        // jQuery(document).on('click', '.selectChatUser', function() {

        var isMobile = $(window).width() < 768;
        if (isMobile) {
            jQuery(document).on('click', '.selectChatUser', function() {
                var mobileNav = $('.jumbotron.messageBodyChar');
                mobileNav.addClass('openNavigationOverlay');

                // var offsetTop = mobileNav.offset().top-80;                    
                // $('html, body').animate({
                //     scrollTop: offsetTop
                // }, 'slow');                

            });
        }
        // });
        jQuery(document).on('click', '.chatHeaderRight', function() {
            // jQuery('.chatHeaderRight').on('click', function() {  
            jQuery('.jumbotron.messageBodyChar').removeClass('openNavigationOverlay');
        });
    </script>
    <div class="container sidebarChatSystems chatWrapperContainer">

        <style>
            .accountDashboardMes {
                max-width: 100%;
            }
        </style>

        <div class="messageContainerWrapper">
            <div class="rowTopMbt">
                <h3>RDHC Messaging</h3>
            </div>
            <div class="rowMbt libellMessage">
                <div class="messageNotification ">
                    <div class="messageWrapper">
                        <div class="sidebarOption">
                            <div class="dropdownHeaderr">
                                <div class="searchPanel">
                                    <input type="search" class="form-control disabledField" placeholder="Chats">
                                    <!-- <button><i class="fa fa-search" aria-hidden="true"></i></button> -->
                                </div>
                                <!-- <span class="messageText">Messages</span> -->
                            </div>
                            <div id="DZ_W_Notificationn1" class="widget-media dz-scroll">
                                <ul class=" user-messages-<?php echo $rdh_id; ?>">
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:;">
                                            <div class="timeline-panel">
                                                <div class="media-bodyy">
                                                    <div class="animated-background">
                                                        <div class="background-masker header-top"></div>
                                                        <div class="background-masker header-left"></div>
                                                        <div class="background-masker header-right"></div>
                                                        <div class="background-masker header-bottom"></div>
                                                        <div class="background-masker subheader-left"></div>
                                                        <div class="background-masker subheader-right"></div>
                                                        <div class="background-masker subheader-bottom"></div>
                                                        <div class="background-masker content-top"></div>
                                                        <div class="background-masker content-first-end"></div>
                                                        <div class="background-masker content-second-line"></div>
                                                        <div class="background-masker content-second-end"></div>
                                                        <div class="background-masker content-third-line"></div>
                                                        <div class="background-masker content-third-end"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jumbotron messageBodyChar">
                <div class="chatHeaderRight">
                    <div class="backToChatList">
                        <a href="javascript:;">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <h4></h4>
                    <span class="notificationCounter messagecounter-<?php echo $rdh_id; ?>">0</span>
                </div>
                <div id="chat-conversation">
                </div>

                <input style="display:none" id="name" readonly class="form-control" value="<?php echo $rdh_name; ?>" placeholder="Sender Name...">


                <div class="textareaoverLap">
                    <textarea id="message" class="form-control" placeholder="write message..."></textarea>
                    <!-- <span id ="typing-status"></span> -->
                    <div class="footerContentWrapper">
                        <div class="formUploadButton">
                            <div class="my-img"></div>
                            <div class="footerUploadFiles">
                                <form id="image-upload-form" enctype="multipart/form-data">
                                    <div class="buttonAction fileUpload blue-btn btn">
                                        <span><i class="fa fa-paperclip" aria-hidden="true"></i></span>
                                        <input type="file" name="image" id="file-input" value="abcdefgh-mindblazetech-com" class="uploadlogo">
                                    </div>

                                </form>
                            </div>
                        </div>


                        <div class="submitButton backendSendButton">
                            <button id="send" class="" onclick="submitMessage()"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script>
        //var socket = io();

        var chat_user_image = '<?php echo $chat_user_image ?>';
        var rdh_user_image = '<?php echo $rdh_user_image ?>'
        const inputField = document.querySelector('#message');
        const typingStatus = document.querySelector('#typing-status');
        var uploaded_image = '';
        idparent = chatUserEmail;
        let newStrid = idparent.replace('@', '-');
        newStr2 = newStrid.replace('.', '-');
        if (newStr2.includes("+")) {
            newStr2 = newStr2.replace('+', '-');
        }
        if (newStr2.includes(".")) {
            newStr2 = newStr2.replace('.', '-');
        }
        newStr2 = newStr2.replace(/[^\w\s]/g, '-');
        chat_user_id = '#' + newStr2;
        // chat_user_id = chat_user_id.trim;
        jQuery(document).ready(function() {
            jQuery('.messageContainerWrapper').attr('id', newStr2);
        });
        // inputField.addEventListener('keydown', () => {
        //     socket.emit('typing');
        // });

        inputField.addEventListener('keyup', () => {
            socket.emit('stop_typing');
        });

        // socket.on('typing', (isTyping) => {
        //     if (isTyping) {
        //         typingStatus.textContent = 'User is typing...';
        //     } else {
        //         typingStatus.textContent = '';
        //     }
        // });

        function convertTextToLink(text) {
            if (text != '' && typeof text === 'string') {
                var urlRegex = /(https?:\/\/[^\s]+)/g;
                return text.replace(urlRegex, function(url) {
                    return '<a href="' + url + '" target="_blank">' + url + '</a>';
                });
            }
            return text;
        }

        function addMessages(message) {
            actual_message = message.message;
            image_message = '';
            if (actual_message.includes("|img|")) {
                myArray = actual_message.split("|img|");
                actual_message = myArray[0];
                image_message = myArray[1];
                image_message = '<br /><a href="<?php echo CHAT_SBR_URL; ?>/uploads/' + image_message + '" target="_blank" class="imageViewer"><span class="viewImageLink"><i class="fa fa-eye" aria-hidden="true"></i></span><img style="max-width: 70px;" src="<?php echo CHAT_SBR_URL; ?>/uploads/' + image_message + '"></img></a>';
            }
            actual_message = convertTextToLink(actual_message);
            if (message.receiver == chatUserEmail) {
                cls = 'receiver';
                //user_img = rdh_user_image;

                if (typeof rdhcs_list[message.sender] != "undefined") {
                    user_img = rdhcs_list[message.sender]['profile_pic'];
                } else {
                    user_img = rdh_user_image;
                }

            } else {
                cls = 'sender';
                user_img = chat_user_image;
            }

            const createdAt = new Date(message.time);
            const formattedDate = createdAt.toLocaleString('en-US', {
                timeZone: user_timezone,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const timeDiffMs = new Date().getTime() - createdAt.getTime();
            const timeInSeconds = Math.floor(timeDiffMs / 1000);
            const timeInMinutes = Math.floor(timeInSeconds / 60);
            const timeInHours = Math.floor(timeInMinutes / 60);
            if (timeInMinutes == 'null' || timeInMinutes == null || typeof(timeInMinutes) == "undefined" || typeof(timeInHours) == "undefined" || isNaN(timeInHours)) {
                result = `just now`;

            } else if (timeInHours < 1) {
                result = `${timeInMinutes} minutes ago`;
            } else if (timeInHours < 24) {
                const remainingMin = timeInMinutes % 60;
                result = `${timeInHours} hours ${remainingMin} minutes ago`;
            } else {
                const date = new Date();
                date.setTime(Date.now() - timeInSeconds * 1000);
                result = `on ${date.toLocaleDateString()}`;
            }


            if ((message.receiver == chatUserEmail && message.sender == destination_mail) || (message.receiver == destination_mail && message.sender == chatUserEmail)) {
                messageis_Read = '';
                if (message.status == 'read') {
                    messageis_Read = '<span class="readDoubleTick"></span>';
                }
                html_send_rec = '<div class="message-' + cls + ' rowFlex"> <div class="messgerPicture twoo"> <span class="userImageMbt"> <img src="' + user_img + '" alt="" data-src="' + user_img + '" decoding="async" class=" lazyloaded"><noscript><img src="' + user_img + '" alt="Abidoon Nadeem" data-eio="l"></noscript> </span> </div> <div class="messageBody"> <div class="messgerName"> <span>' + message.name + '</span> </div> <div class="messageBodyText"> ' + actual_message + image_message + ' </div><span class="posttime tttt">' + formattedDate + '</span> ' + messageis_Read + ' </div> </div>';
                $("#chat-conversation").append(html_send_rec);
                //$("#chat-conversation").append('<div class="message-'+cls+' rowFlex"><strong>'+message.name.charAt(0).toUpperCase()+message.name.slice(1)+'</strong> says: <br><span>'+actual_message+image_message+'</span></div><hr/>');
            }
        }

        function addMyChat(rec) {

            let newStr = rec.sender.replace('@', '-');
            newStr = newStr.replace('.', '-');
            if (newStr.includes("+")) {
                newStr = newStr.replace('+', '-');
            }
            if (newStr.includes(".")) {
                newStr = newStr.replace('.', '-');
            }
            newStr = newStr.replace(/[^\w\s]/g, '-');
            // search for user by email address

            var meta_value_rdh = rdhcs_list[rec.sender];
            svg_link = '<?php echo home_url(); ?>/wp-content/uploads/2020/07/smilebrilliant-logomark-200x200-1.png';
            timeline = '';
            //if(meta_value_rdh !='undefined ' && meta_value_rdh !='undefined'  && meta_value_rdh !=undefined){
            //  if (rec.sender in rdhcs_list){

            if (typeof rdhcs_list[rec.sender] != "undefined") {
                svg_link = '<?php echo home_url(); ?>/wp-content/themes/revolution-child/assets/images/rdh-profile/RDH-logo.svg';
                // svg_link = meta_value_rdh['profile_pic'];
                timeline = meta_value_rdh['timeline'];


            } else {
                timeline = '';
            }
            new_rec = '<div class="selectChatUser" data-email="' + rec.sender + '"> ' + rec.name + ' Notifications:   </div>';

            new_rec = '<li class="selectChatUser" data-email="' + rec.sender + '"><a href="javascript:;"><div class="timeline-panel"><div class="media-body"><div class="messgerPicture rdhLogoMbt"> <div id="notifications-' + newStr + '" class="mbt-mess-not"></div><span class="userImageMbt"> <img src="' + svg_link + '" alt=""  class="userImageProfile"></span> </div> <h6 class="mb-0"><span class="getName">' + rec.name + ' <div class="rdhTagLine"><span class="gettitle">' + timeline + ' </span></div></span>  <div class="messaegTimeDisplay"><small class="d-block"> 02:26 PM</small></div></h6></div></div></a> </li>';
            append_id = ".user-messages-" + curreUSerId;
            jQuery(append_id).append(new_rec);
            socket.emit('getUnreadMessages', rec.receiver, rec.sender);
        }


        function getMessages() {

            if (destination_mail != '') {
                obj = {
                    receiver: destination_mail,
                    sender: chatUserEmail
                };

                $.get('<?php echo CHAT_SBR_URL; ?>/ChatSbr', obj, (data) => {
                    data.forEach(addMessages);
                })
                socket.emit('updateMessageStatus', chatUserEmail, destination_mail, 'read');
            }
        }

        function getMyChats() {

            obj = {
                receiver_id: chatUserEmail
            };

            $.get('<?php echo CHAT_SBR_URL; ?>/myChates', obj, (data) => {
                append_id = ".user-messages-" + curreUSerId;
                jQuery(append_id).html('');
                data.forEach(addMyChat);
            })
        }

        function addNotification(message) {
            existing_counter = jQuery('#notifications').text();
            if (existing_counter == '') {
                existing_counter = 0;
            }
            if (message.receiver == chatUserEmail) {
                count = parseInt(existing_counter);
                count2 = ++count;
                $("#notifications").html(count2);
            }
        }

        function sendMessage(message) {
            socket.emit('updateMessageStatus', chatUserEmail, destination_mail, 'read');
            $.post('<?php echo CHAT_SBR_URL; ?>/ChatSbr', message)
            $("#message").val("");

        }
        socket.on('Chat', addMessages);
        socket.on('getNotificationmessages', (results, receiver_id, sender_id) => {
            //results.forEach(addNotification);
            let newStr = sender_id.replace('@', '-');
            newStr = newStr.replace('.', '-');
            if (newStr.includes("+")) {
                newStr = newStr.replace('+', '-');
            }
            if (newStr.includes(".")) {
                newStr = newStr.replace('.', '-');
            }
            newStr = newStr.replace(/[^\w\s]/g, '-');
            notifications_dev = "#notifications-" + newStr;
            notifications_dev_org = "notifications-" + newStr;


            if (receiver_id == chatUserEmail) {

                if ($(notifications_dev).length) {
                    //
                } else {
                    getMyChats();
                }
                jQuery(notifications_dev).html(results.length);
                if (results.length > 0) {
                    jQuery(notifications_dev).parents('.selectChatUser').addClass('hasNotifications');
                } else {
                    jQuery(notifications_dev).parents('.selectChatUser').removeClass('hasNotifications');
                }
                updateAllMessagesCounter();
            } else {

            }

        });

        function updateAllMessagesCounter() {
            existing_Counter = 0;
            jQuery(document).find('.mbt-mess-not').each(function() {
                count = jQuery(this).text();
                if (count == '' || count == ' ') {
                    count = 0;
                }

                intval = parseInt(count);
                // alert(intval);
                existing_Counter = existing_Counter + intval;
            });
            cls = ".messagecounter-" + curreUSerId;
            jQuery(cls).html(existing_Counter);
        }

        function submitMessage() {
            message_val = $("#message").val();

            setTimeout(function() {
                jQuery("#chat-conversation").scrollTop(jQuery("#chat-conversation")[0].scrollHeight);
            }, 500)
            if (message_val == '' && uploaded_image == '') {
                return false;
            }
            if (uploaded_image != '') {
                message_val = message_val + '|img|' + uploaded_image;
                jQuery(chat_user_id).find('#image-upload-form')[0].reset();
                uploaded_image = '';
                jQuery(chat_user_id).find('.my-img').html('');
            }

            object = {
                name: $("#name").val(),
                message: message_val,
                sender: chatUserEmail,
                receiver: destination_mail
            };
            resp = sendMessage(object);
        }
    </script>
    <script>
        const imageUploadForm = document.getElementById('image-upload-form');
        const imageUploadButton = imageUploadForm.querySelector('button');
        const imageUploadInput = imageUploadForm.querySelector('input[type="file"]');
        const fileInput = document.getElementById('file-input');
        var radn_class = '';

        $('.fileUpload').click(function() {

            radn_class = 'cls' + Math.floor(Math.random() * 56888944) + 1;
            jQuery(document).find('.messageContainerWrapper').addClass(radn_class);
            //  setTimeout(function(){jQuery(document).find('.messageContainerWrapper').addClass(radn_class);}, 1000);

        });
        const uploader = new SocketIOFileUpload(socket);

        uploader.listenOnInput(fileInput);
        socket.on('file_uploaded_back', function(data) {
            uploaded_image = data.file.name;
            radn_class_act = '.' + radn_class;
            html_obj = '<div class="img-prev"><span class="viewImageLink"><i class="fa fa-eye" aria-hidden="true"></i></span><img style="max-width: 70px;" src="<?php echo CHAT_SBR_URL; ?>/uploads/' + uploaded_image + '"></img> <div class="cross"><span class="cross">×</span></div></div>';
            jQuery(radn_class_act).find('.my-img').html(html_obj);

        });
        jQuery(document).on('click', '.cross', function() {
            radn_class_act = '.' + radn_class;
            jQuery(radn_class_act).find('#image-upload-form')[0].reset();
            jQuery(radn_class_act).find('.my-img').html('');
            uploaded_image = '';
        });
    </script>
<?php
}
add_action('wp_ajax_add_current_user_unread_notification_count', 'add_current_user_unread_notification_count');
function add_current_user_unread_notification_count()
{
    $userid = get_current_user_id();
    $current_count = isset($_POST['current_count']) ? $_POST['current_count'] : 0;
    $existing_count = get_user_meta($userid, 'notification_count_updated4', true);

    if ($existing_count == '') {
        $existing_count = 0;
    }
    $existing_count = (int) $current_count + $existing_count;
    update_user_meta($userid, 'notification_count_updated4', $existing_count);
    setcookie('notification_count', $existing_count, strtotime('+365 day'), '/');
    die();
}


function Socket_Script_info()
{
?>


    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/socket.io.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/client.js"></script>
    <?php
    if (is_user_logged_in()) {
        $current_url = "http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $front_cust = 'yes';
        if (is_user_logged_in() && strpos($current_url, "rdh/contact") == false) {
            $front_cust = 'no';
        }
        $user_id = get_current_user_id();
        $curr_user = get_userdata($user_id);
        $userRole = '';
        $both = false;
        if (in_array('customer', (array) $curr_user->roles)) {
            $userRole = 'customer';
        }
        if (in_array('administrator', (array) $curr_user->roles)) {
            $userRole = 'admin';
        }
        $field_value = '';
        if(function_exists('bp_is_active')){
        $field_value = bp_get_profile_field_data(array(
            'field' => 'Referral',
            'user_id' => $user_id,

        ));
    }
        if ($field_value != '') {
            $userRole = 'RDHC';
        }
        $args = array(
            'customer'  => get_current_user_id()
        );
        $have_orders = wc_get_orders($args);
        if ($field_value != '' && !empty($have_orders)) {
            $both = true;
        }
    ?>
        <script>
            var both = false;
            const ROOMS = {
                "admin": "adminRoom",
                "customer": "customerRoom",
                "RDHC": "RDHCRoom"
            };
            var userRole = '<?php echo $userRole; ?> ';
            var useremaiAddress = '<?php echo $curr_user->user_email; ?>';
            <?php if ($both) {
            ?>

                var both = true;
                jQuery(document).ready(function() {
                    getmynotifications(['customerRoom', 'RDHCRoom', 'all']);
                });
            <?php

            } else if ($userRole == 'RDHC') {
            ?>
                jQuery(document).ready(function() {
                    getmynotifications(['RDHCRoom', 'all']);

                });
            <?php
            } else if ($userRole == 'customer') {
            ?>
                jQuery(document).ready(function() {
                    getmynotifications(['customerRoom', 'all']);

                });
            <?php
            }
            ?>

            //var socket = io();

            var user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            var send_role = userRole;
            if (both) {
                var send_role = 'both'
            }


            var socket = io.connect('<?php echo CHAT_SBR_URL; ?>', {
                query: {
                    role: send_role,
                    front_cust: '<?php echo $front_cust; ?>'
                }
            });
            <?php if ($both) {
            ?>
                socket.emit('join', 'customerRoom');
                socket.emit('join', 'RDHCRoom');
            <?php

            } else {
            ?>
                socket.emit('join', ROOMS[userRole]);
            <?php
            }
            ?>

            socket.on('newNotification', (res) => {
                notification_count_existing = jQuery('#flyout-example .notificationCounter').text();

                if (notification_count_existing == '') {
                    notification_count_existing = 0;
                }
                ++notification_count_existing;
                jQuery('#flyout-example .notificationCounter').text(Number(notification_count_existing));
                generateNotification_entity(res);

            });
            socket.on('delNotification', (res) => {
                notid = "#" + res;
                jQuery(notid).remove();

            });

            function getmynotifications(arr) {
                user_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                jQuery.ajax({
                    method: 'POST',
                    contentType: "application/json",
                    data: JSON.stringify({
                        groupdata: arr
                    }),
                    url: '<?php echo CHAT_SBR_URL; ?>/notifications/',
                    success: function(res) {
                        cookiedata = jQuery.cookie("notification_count");
                        if (cookiedata == undefined || cookiedata == 'undefined') {
                            cookiedata = 0;
                        }
                        notification_count_existing = res.length - cookiedata;

                        if (notification_count_existing == '' || isNaN(notification_count_existing)) {
                            notification_count_existing = 0;
                        }
                        if (notification_count_existing < 0) {
                            notification_count_existing = 0;
                        }

                        jQuery('#flyout-example .notificationCounter').text(notification_count_existing);
                        res.forEach((item) => {
                            if (item.statu != 'trash') {
                                generateNotification_entity(item);
                            }

                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function timeAgo(timestamp) {
                var seconds = Math.floor((new Date() - timestamp) / 1000);
                if (seconds < 1) {
                    seconds = 10;
                }
                if (seconds < 60) {
                    return seconds + ' seconds ago';
                }
                const minutes = Math.floor(seconds / 60);
                if (minutes < 60) {
                    return minutes + ' minutes ago';
                }
                const hours = Math.floor(minutes / 60);
                if (hours < 24) {
                    return hours + ' hours ago';
                }
                const days = Math.floor(hours / 24);
                return days + ' days ago';
            }
            jQuery(document).on('click', '.bellNotification', function() {
                current_count = jQuery(this).text();
                if (current_count == '' || current_count == 0) {
                    return false;
                }
                jQuery.ajax({
                    data: 'current_count=' + current_count + '&action=add_current_user_unread_notification_count',
                    method: 'post',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    success: function(res) {

                        jQuery('#flyout-example .notificationCounter').text(0);
                    }
                });
            });

            function generateNotification_entity(res) {
                dt = res.time;
                if (res.status == 'trash') {
                    return;
                }
                const isoDate = new Date(dt); // Replace with your ISODate string
                const timestamp = Math.floor(isoDate.getTime());

                timeString = timeAgo(timestamp);
                formattedDate1 = dt.toLocaleString('en-US', {
                    timeZone: user_timezone,
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                formattedDate1 = '';
                html_content = '<li  id="' + res._id + '"> <a href="javascript:;"><div class="timeline-panel"><div class="dashboard-icon rdh_icon_white"><img src="https://smilebrilliant.com/wp-content/uploads/2020/07/smilebrilliant-logomark-200x200-1.png" alt=""></div><div class="media-body"><h6 class="mb-1">' + res.message + '</h6><small class="d-block">' + formattedDate1 + timeString + '</small></div></div></a> </li>';
                jQuery('#DZ_W_Notification1 .timeline').prepend(html_content);
            }

            socket.on('getNotificationmessages', (results, receiver_id, sender_id) => {
                obj = {
                    receiver_id: useremaiAddress
                };
                update_unread_messges_counter_global(obj);
            });
            jQuery(document).ready(function() {
                obj = {
                    receiver_id: useremaiAddress
                };
                update_unread_messges_counter_global(obj);
            });

            function update_unread_messges_counter_global(obj) {
                // obj = {receiver_id:useremaiAddress};
                $.post('<?php echo CHAT_SBR_URL; ?>/getunreadmessagesCount', obj, (data) => {
                    if (data.length > 0) {
                        // jQuery('#chat-circle').addClass('shake');
                        //setTimeout(function() {
                        //     var element = document.querySelector('#chat-circle.shake');
                        //     element.classList.add('stop-shaking');
                        // }, 8000);            
                        jQuery('#totalunreadmessages').html(data.length);
                    } else {
                        //jQuery('#chat-circle').removeClass('shake');
                        jQuery('#totalunreadmessages').html('0');
                    }
                });
            }
        </script>
    <?php
    } else {

    ?>
        <script>
            userRole = 'customer';
            var socket = io.connect('<?php echo CHAT_SBR_URL; ?>', {
                query: {
                    role: userRole,
                    front_cust: 'yes'
                }
            });
        </script>
    <?php
    }
    ?>

<?php
}

function registerNodeCustomer($name, $email, $receiver, $message)
{

    $url = CHAT_SBR_URL . '/create-user';
    $data = array(
        'name' => $name,
        'email' => $email,
        'password' => wp_generate_password(),
        'receiver' => $receiver,
        'message' => $message,
        'name' => $name
    );
    // print_R($data);
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
    );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);

    if ($response == 'Bad request' || $response == '') {
        return 'error';
    } else {
        return str_replace('"', "", $response);
    }
}

function apply_coupon_from_url_mbt()
{

    if (isset($_REQUEST['apply_coupon']) && $_REQUEST['apply_coupon'] == 'SGUARD20') {
        $coupon_code = $_REQUEST['apply_coupon'];
        if (WC()->cart->has_discount($coupon_code)) {
            return;
        }

        WC()->cart->apply_coupon($coupon_code);
    }
}
add_action('woocommerce_before_calculate_totals', 'apply_coupon_from_url_mbt', 10);
function custom_profile_redirect()
{
    $request_uri = $_SERVER['REQUEST_URI'];
    $pattern = '/^\/members\/([^\/]+)\/profile\/$/';

    if (preg_match($pattern, $request_uri, $matches)) {
        $user = $matches[1];
        wp_redirect(home_url("/rdh/profile/$user"), 301);
        exit();
    }
}
//add_action('template_redirect', 'custom_profile_redirect');

/*
Dentist System
*/
add_action("wp_ajax_reg_user_dentist_affiliate","reg_user_dentist_affiliate");
add_action("wp_ajax_nopriv_reg_user_dentist_affiliate","reg_user_dentist_affiliate");
function reg_user_dentist_affiliate(){
   // if(isset($_POST["reg_dentist"]) && $_POST["reg_dentist"]!=''){
        global $wpdb;
    parse_str($_POST['formData'], $formData);
   
    $username = sanitize_user($formData['signup_username']);
    $email = sanitize_email($formData['signup_email']);
    $password = $formData['signup_password'];
    $practice_name = sanitize_text_field($formData['practice_name']);

    $cellphone = sanitize_text_field($formData['contact']['cellphone']);
    $country = sanitize_text_field($formData['address']['country']);
    $address = sanitize_text_field($formData['address']['address']);
    $town_city = sanitize_text_field($formData['address']['town_city']);
    $apt = sanitize_text_field($formData['address']['apt']);
    $zipcode = $formData['address']['zipcode'];
    $state = sanitize_text_field($formData['address']['state']);

    $linkedin = esc_url_raw($formData['social']['linkedin']);
    $instagram = esc_url_raw($formData['social']['instagram']);
    $youtube = esc_url_raw($formData['social']['youtube']);
    $tiktok = esc_url_raw($formData['social']['tiktok']);
    $twitter = esc_url_raw($formData['social']['twitter']);
    $facebook = esc_url_raw($formData['social']['facebook']);
    $blog = esc_url_raw($formData['social']['blog']);
    $office_hours = $formData['open_hours'];
    $address2 = $formData['address'];
   
    // Add social media information to user meta
   
    // Add more fields as needed
    
    // Create the user
    $user_id = wp_create_user($username, $password, $email);

    if (!is_wp_error($user_id)) {
        $affiliate_id = affwp_add_affiliate(array(
            'user_id'        => $user_id,
            'status' => 'active',
            'dynamic_coupon' => !affiliate_wp()->settings->get('require_approval') ? 1 : '',
        ));
        affwp_update_affiliate(array('affiliate_id' => $affiliate_id, 'rate' => '20', 'rate_type' => 'percentage'));
   
        $status = affwp_get_affiliate_status($affiliate_id);
        $user   = (array) get_userdata($user_id);
        $args   = (array) $user['data'];
        do_action('affwp_auto_register_user', $affiliate_id, $status, $args);
        update_user_meta($user_id, 'last_activity', date("Y-m-d H:i:s"));
        $emails = WC()->mailer()->get_emails();
       // $respose =   $emails['WC_RDH_Register_Email']->trigger($user_id);
    
        // Update additional user meta
        update_user_meta($user_id, 'practice_name', $practice_name);
    
        update_user_meta($user_id, 'phone', $cellphone);
        update_user_meta($user_id, 'first_name', sanitize_text_field($formData['first_name']));
        update_user_meta($user_id, 'last_name', sanitize_text_field($formData['last_name']));
        update_user_meta($user_id, 'country', $country);
        update_user_meta($user_id, 'address', $address);
        update_user_meta($user_id, 'town_city', $town_city);
        update_user_meta($user_id, 'apt', $apt);
        update_user_meta($user_id, 'zipcode', $zipcode);
        update_user_meta($user_id, 'state', $state);
     
        update_user_meta( $user_id, "billing_first_name",  sanitize_text_field($formData['first_name']) );
        update_user_meta( $user_id, "billing_last_name", sanitize_text_field($formData['first_name']));
        update_user_meta( $user_id, "billing_company", $practice_name );
        update_user_meta($user_id, 'billing_country', $country);
        update_user_meta($user_id, 'billing_address_1', $address);
        update_user_meta($user_id, 'billing_city', $town_city);
        update_user_meta($user_id, 'billing_postcode', $zipcode);
        update_user_meta($user_id, 'billing_state', $state);
    
        update_user_meta($user_id, 'billing_phone', $cellphone);

        update_user_meta( $user_id, "shipping_first_name",  sanitize_text_field($formData['first_name']));
        update_user_meta( $user_id, "shipping_last_name", sanitize_text_field($formData['first_name']));
        update_user_meta($user_id, 'shipping_country', $country);
        update_user_meta($user_id, 'shipping_address_1', $address);
        update_user_meta($user_id, 'shipping_city', $town_city);
        update_user_meta($user_id, 'shipping_postcode', $zipcode);
        update_user_meta($user_id, 'shipping_state', $state);
        update_user_meta($user_id, 'shipping_phone', $cellphone);

        update_user_meta($user_id, 's_linkedin', $linkedin);
        update_user_meta($user_id, 's_instagram', $instagram);
        update_user_meta($user_id, 's_youtube', $youtube);
        update_user_meta($user_id, 's_tiktok', $tiktok);
        update_user_meta($user_id, 's_twitter', $twitter);
        update_user_meta($user_id, 's_facebook', $facebook);
        update_user_meta($user_id, 's_blog', $blog);
        $random_code = generateRandomCodeDentist();
        update_user_meta($user_id, 'access_code', $random_code);
        cloneRdhPageById($user_id,DENTIST_PAGE_ID);
        if (is_array($office_hours)) {
          
            update_user_meta($user_id, 'office_hours', $office_hours);
           // echo json_encode(array('success' => true, 'message' => 'Office hours saved successfully.'));
        }
        $wpdb->insert('buddy_user_meta', array(
            'user_id' => $user_id,
            'key' => 'address',
            'value' => json_encode($address2),
        ));
        // Add more meta data as needed
        
        // You can also log the user in if needed
        // wp_set_auth_cookie($user_id);

        echo json_encode(array('success' => true, 'Recommendation_url' => home_url().'/dentist/'.$username.'/?ref='.$affiliate_id,'access_code'=>$random_code));

    } else {
        echo $user_id->get_error_message();
    }

    wp_die();
    //}
}

function generateRandomCodeDentist() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $random_string = '';
    
    // Generate 4 random characters
    for ($i = 0; $i < 4; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    // Concatenate "SBR" prefix with the random characters
    $random_code = 'SBR' . $random_string;
    
    return $random_code;
}
function product_belongs_to_category($product_id, $category_slug, $taxonomy = 'product_cat') {
   
    // Get the terms (categories) associated with the product
    $terms = wp_get_post_terms($product_id, $taxonomy);
    
    
    // Check if the product belongs to the specified category
    foreach ($terms as $term) {
        if ($term->slug === $category_slug) {
            return true;
        }
    }

    return false;
}

/*
Dentist 
*/

/*
CREATE TABLE dentist_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dentist_id INT NOT NULL,
    dentist_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20),
    share_url LONGTEXT,
    dentist_note LONGTEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

*/
function load_email_template_dentist($template_name, $placeholders) {
    ob_start();
    include locate_template($template_name);
    $template = ob_get_clean();
    foreach ($placeholders as $key => $value) {
        $template = str_replace('{{' . $key . '}}', $value, $template);
    }
    return $template;
}
add_action('wp_ajax_send_email_share_link', 'send_email_share_link');
add_action('wp_ajax_nopriv_send_email_share_link', 'send_email_share_link');

function send_email_share_link() {
    global $wpdb;
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('success' => false,'message'=>'Invalid email address'));
        die();
        // Handle the error accordingly
    }
    $url = $_POST['url'];
    $dentist_name = $_POST['dentist_name'];
    $dentist_id = $_POST['dentist_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    
    $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
    $notes =nl2br(wp_kses_post($notes));

    
    $phone = isset($_POST['phone']) ? $_POST['phone']:'';
    $insertdata = array(
        'dentist_id' => $dentist_id,
        'dentist_name' => $dentist_name,
        'customer_email' => $email,
        'customer_first_name'=>$first_name,
        'customer_last_name'=>$last_name,
        'customer_phone' => $phone,
        'share_url' => $url,

        'dentist_note' => $notes
    );
        $tinyurl_api = 'http://tinyurl.com/api-create.php?url=' . urlencode($url);
        $url_tiny = file_get_contents($tinyurl_api);
    //add_filter('wp_mail_from', 'custom_email_from_for_dentist',10,1);
    //add_filter('wp_mail_headers', 'custom_email_headers_dentist',10,1);
    //add_filter('wp_mail_from_name', 'custom_email_from_name_for_dentist');
    // Implement your email sending logic here
    // Example:
    
$table_name = 'dentist_data';
$result=$wpdb->insert($table_name, $insertdata);
    //remove_filter('wp_mail_from', 'custom_email_from_for_dentist',10,1);
    //remove_filter('wp_mail_headers', 'custom_email_headers_dentist',10,1);

    // remove_filter('wp_mail_from_name', 'custom_email_from_name_for_dentist');
    // Send response back
    
    if ($result) {
        $last_insert_id = $wpdb->insert_id;

        // Get the current user object
        $current_user = wp_get_current_user();
        $recommendation_id = $dentist_id . '|' . $last_insert_id;
        $encoded_recommendation_id = base64_encode($recommendation_id);

        // Generate share URL based on user login status
        if ($current_user->exists()) {
            $username = $current_user->user_login;
           // $share_url = home_url('/dentist/' . $username);
            $share_url = add_query_arg(array(
                'recommendation_id' => $encoded_recommendation_id,
                'utm_source' => 'Dentist',
                'utm_medium' => 'Email',
                'utm_campaign' => 'Copeland'
            ), home_url('/dentist/' . $username));
            //$share_url = add_query_arg('recommendation_id', $encoded_recommendation_id, $share_url);
        } else {
            $share_url = home_url('/dentist/notfound');
        }
        $to = $email;
    $subject = 'Dr. '.$dentist_name.' - Product Recommendation Information';
    $message = '<p>As per our discussion in office, below is a link to some products we’d recommend you consider incorporating into your oral care routine.<br /></p>
    <a href="'. $share_url .'" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">View Recommended Products</a>
    <p><strong style="color: #007bff;">Special message from your dentist:</strong><br><br>' . $notes .'</p>';
$headers = array('Content-Type: text/html; charset=UTF-8');
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: 	Smile Brilliant 2 <dentist@smilebrilliant.com>'
    );
    //$result = wp_mail($to, $subject, $message, $headers);
    $address_parts = explode(',', get_user_meta($dentist_id, 'address',true ));
    $billing_phone = get_user_meta($dentist_id, 'billing_phone',true );
    $street = isset($address_parts[0]) ? trim($address_parts[0]) : '';
$city = isset($address_parts[1]) ? trim($address_parts[1]) : '';
$state = isset($address_parts[2]) ? trim($address_parts[2]) : '';
$country = isset($address_parts[3]) ? trim($address_parts[3]) : '';
$address = '';

// Concatenate address parts with <br> tags if they exist
if ($street) {
    $address .= $street . ' ';
}
if ($city) {
    $address .= $city . '<br />';
}
if ($state) {
    $address .= $state . ', ';
}
if ($country) {
    $address .= $country;
}
$user_info = get_userdata($dentist_id);
$username = $user_info->user_login;
$dentist_data = DENTIST_DATA;
$base_dir = get_stylesheet_directory_uri() . '/assets/images/dentists/';

// Construct the image path
$image_path = $base_dir . $username . '.png';

// Fallback image path
$fallback_image_path = $base_dir . 'sharing-icon.png';

// Check if the dentist-specific image exists
if (@getimagesize($image_path)) {
  $image_src = $image_path;
} else {
  $image_src = $fallback_image_path;
}
    $to = $email;
$subject = 'Dr. ' . $dentist_name . ' - Product Recommendation Information';
        $placeholders = array(
            'dentist_name' => $dentist_name,
            'practice_name' =>         get_user_meta($dentist_id, 'practice_name',true ),
            'dentist_address' =>        $address,
            'dentist_website' =>        isset($dentist_data[$username]['website'])?$dentist_data[$username]['website']:'',
            'dentist_logo' =>        $image_src,
            'url' => $share_url,
            'notes' => $notes,
            'billing_phone'=>$billing_phone,
            'message'=>$message
        );
        $data = '{
            "email": "' . $email . '",
            "profiles": {
              "email": "' . $email . '",
              "share_url": "' . $share_url . '",
              "first_name": "' . $first_name . '",
              "last_name": "' . $last_name . '",
              "Dentist-client": "yes",
              "Dentist-office": "' . $dentist_name . '"
            }
          }';
          klaviyo_partner_customer_list($data);
       //   echo $data;
   

       $message = load_email_template_dentist('page-templates/dental-email-template.php', $placeholders);

       $headers = array(
           'Content-Type: text/html; charset=UTF-8',
           'From: Smile Brilliant 2 <dentist@smilebrilliant.com>'
       );
       
       $message =  str_replace("\'", "'", $message);
       $message =  str_replace('\"', '"', $message);
       $result = wp_mail($to, $subject, $message, $headers);



       echo json_encode(array('success' => true,'message'=>$share_url));
    } else {
        echo json_encode(array('success' => false,'message'=>$wpdb->last_error));
    }

    wp_die();
}
function custom_email_headers_dentist($headers) {
    // Change From email and name
    $headers[] = 'From: 	Smile Brilliant <dentist@smilebrilliant.com>';

    return $headers;
}
function custom_email_from_for_dentist($original_email_address) {
    // Change sender's email address
    return 'dentist@smilebrilliant.com';
}

function custom_email_from_name_for_dentist() {
    // Change sender's name
    return '';
}

add_action('wp_ajax_nopriv_send_text_share_link', 'send_text_share_link');
add_action('wp_ajax_send_text_share_link', 'send_text_share_link');

function send_text_share_link() {
    global $wpdb;

    // Sanitize and validate inputs
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $url = isset($_POST['url']) ? esc_url_raw($_POST['url']) : '';
    $notes = isset($_POST['notes']) ? sanitize_textarea_field($_POST['notes']) : '';
    $notes = nl2br(wp_kses_post($notes));
    $dentist_name = isset($_POST['dentist_name']) ? sanitize_text_field($_POST['dentist_name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $dentist_id = isset($_POST['dentist_id']) ? sanitize_text_field($_POST['dentist_id']) : '';
    $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';

    // Validate phone number and add default country code if necessary
    if (!preg_match('/^\+/', $phone)) {
        $phone = '+92' . $phone; // Change the default country code as needed
    }

    // Prepare data for insertion
    $insertdata = array(
        'dentist_id' => $dentist_id,
        'dentist_name' => $dentist_name,
        'customer_email' => $email,
        'customer_first_name' => $first_name,
        'customer_last_name' => $last_name,
        'customer_phone' => $phone,
        'share_url' => $url,
        'dentist_note' => $notes
    );

    // Insert data into the database
    $table_name = 'dentist_data';
    $result = $wpdb->insert($table_name, $insertdata);

    if ($result) {
        $data = '{
            "phone_number": "' . $phone . '",
            "profiles": {
              "phone_number": "' . $phone . '",
              "first_name": "' . $first_name . '",
              "last_name": "' . $last_name . '",
              "share_url": "' . $url . '",
              "Dentist-client": "yes",
              "Dentist-office": "' . $dentist_name . '"
            }
          }';
          klaviyo_partner_customer_list($data);
        $last_insert_id = $wpdb->insert_id;

        // Get the current user object
        $current_user = wp_get_current_user();
        $recommendation_id = $dentist_id . '|' . $last_insert_id;
        $encoded_recommendation_id = base64_encode($recommendation_id);

        // Generate share URL based on user login status
        if ($current_user->exists()) {
            $username = $current_user->user_login;
           
            $share_url = add_query_arg(array(
                'recommendation_id' => $encoded_recommendation_id,
                'utm_source' => 'Dentist',
                'utm_medium' => 'SMS',
                'utm_campaign' => 'Copeland'
            ), home_url('/dentist/' . $username));
        } else {
            $share_url = home_url('/dentist/notfound');
        }

        // Prepare message and send SMS using Twilio
         $message = 'Below is the link to the product(s) that we would recommend for you from Dr. ' . $dentist_name . ' at Town Center Dental: ' . $share_url;
 
        $response = send_twilio_text_sms($phone, $message);

        // Check SMS response and return JSON result
        if (isset($response['status']) && $response['status'] != '200' && isset($response['message'])) {
            echo json_encode(array('success' => false, 'message' => $response['message']));
            wp_die();
        }

        echo json_encode(array('success' => true,'message'=>$share_url));
        wp_die();
    } else {
        echo json_encode(array('success' => false, 'message' => $wpdb->last_error));
    }

    wp_die();
}

add_action('template_redirect', 'flush_dentist_url');

function flush_dentist_url() {
    // Check if the 'dentist_name' query variable exists and is not empty
    if (get_query_var('dentist_name') && !empty(get_query_var('dentist_name'))) {
        // Check if the function 'w3tc_flush_url' exists
        if (function_exists('w3tc_flush_url')) {
            // Construct the URL
             $dentisturl_flush = home_url() . "/dentist/" . get_query_var('dentist_name') . "/";
           // die();
            // Flush the URL
            w3tc_flush_url($dentisturl_flush);
        }
    }
}


function get_ids_from_recommendation() {
    if (isset($_GET['recommendation_id'])) {
        $encoded_recommendation_id = sanitize_text_field($_GET['recommendation_id']);
        $decoded_recommendation_id = base64_decode($encoded_recommendation_id);
        
        list($dentist_id, $last_insert_id) = explode('|', $decoded_recommendation_id);

        return array(
            'dentist_id' => $dentist_id,
            'last_insert_id' => $last_insert_id
        );
    }
    return null;
}


function get_share_url_from_db($last_insert_id='') {
    global $wpdb;

    if ($last_insert_id!='') {
        
        $table_name = 'dentist_data';
        $share_url = $wpdb->get_var($wpdb->prepare(
            "SELECT share_url FROM $table_name WHERE id = %d",
            $last_insert_id
        ));

        if ($share_url) {
            return $share_url;
        }
    }
    return null;
}

function get_dentist_note_from_db($last_insert_id='') {
    global $wpdb;

    if ($last_insert_id!='') {
        
        $table_name = 'dentist_data';
        $dentist_note = $wpdb->get_var($wpdb->prepare(
            "SELECT dentist_note FROM $table_name WHERE id = %d",
            $last_insert_id
        ));

        if ($dentist_note) {
            return $dentist_note;
        }
    }
    return null;
}

function get_comma_seperated_cat_slugs($product_id) {
    // Get the categories for the given product ID
    $slugs_string_comp = '';
    $product_categories = wp_get_post_terms($product_id, 'product_cat', array(
        'fields' => 'slugs'
    ));
    
    // Check if any categories are found
    if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
        // Convert the slugs array to a comma-separated string
        $slugs_string = implode( ',', $product_categories );
        $slugs_string_comp = $slugs_string;
        // Return the comma-separated slugs string
      //  return $slugs_string;
    }
    $product_categories = wp_get_post_terms($product_id, 'type', array(
        'fields' => 'slugs'
    ));
    
    // Check if any categories are found
    if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
        // Convert the slugs array to a comma-separated string
        $slugs_string = implode( ',', $product_categories );
        
        // Return the comma-separated slugs string
        $slugs_string_comp .= ','.$slugs_string;
    }
    
    // Return an empty string if no categories are found
    return $slugs_string_comp;
}
