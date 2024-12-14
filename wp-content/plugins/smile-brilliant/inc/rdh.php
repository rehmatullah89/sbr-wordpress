<?php
//add_action('admin_menu', 'register_rdh_detail_info');


add_action('affwp_complete_referral', 'affwp_complete_referral_sbr', 10, 3);
/**
 * Action hook to complete the referral in the AffiliateWP plugin.
 *
 * @param int    $referral_id ID of the referral being completed.
 * @param object $referral    Referral object.
 * @param int    $reference   Reference ID associated with the referral.
 */
function affwp_complete_referral_sbr($referral_id = 0, $referral = '', $reference = 0)
{



    $affiliate = affwp_get_affiliate($referral->affiliate_id);
    $field_value = '';
    if ($reference) {
        if(function_exists('bp_is_active')){
        $field_value = bp_get_profile_field_data(array(
            'field' => 'Referral',
            'user_id' => $affiliate->user_id,

        ));
    }
        if ($field_value != '') {
            update_post_meta($reference, 'rdhc_user_id',  $affiliate->affiliate_id);
            $customer_id = get_post_meta($reference, '_customer_user',  true);
            if ($customer_id) {
                update_user_meta($customer_id, '_rdhc_user', $affiliate->user_id);
            }
        }
        //update_post_meta($reference, '_referral_id', $referral_id);
        update_post_meta($reference, '_referral_id', $referral_id);
        update_post_meta($reference, '_affiliate_id', $referral->affiliate_id);
    }
}


/**
 * Registers the RDH info submenu page.
 */
function register_rdh_detail_info()
{
    add_submenu_page(
        'edit.php?post_type=product',
        'RDH info',
        'RDH info',
        'manage_options',
        'rdh_info',
        'rdhDetailInfo_callback'
    );
}

/**
 * Callback function for the RDH info submenu page.
 */
function rdhDetailInfo_callback()
{
    global $wpdb;
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
    if ($user_id > 0) {
        $user_info = get_userdata($user_id);
        add_repeater_fields_admin_mbt($user_info);
    }
}


add_action('wp_ajax_rdhConnectQuery', 'rdhConnectQuery_callback');
add_action('wp_ajax_nopriv_rdhConnectQuery', 'rdhConnectQuery_callback');
/**
 * AJAX callback function for RDH connection query.
 */
function rdhConnectQuery_callback()
{
    $errors = array();
    if (!isset($_REQUEST['user-name']) || trim($_REQUEST['user-name']) == "") {
        $errors[] = 'Please fill your name.';
    }
    if (!isset($_REQUEST['user-email']) || trim($_REQUEST['user-email']) == "" || !is_email($_REQUEST['user-email'])) {
        $errors[] = 'Please fill your correct email address.';
    }
    if (!isset($_REQUEST['message']) || trim($_REQUEST['message']) == "") {
        $errors[] = 'Please type your message.';
    }

    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
        $errors[] = 'Please check the the captcha.';
    } else {
        $secretKey = "6LcpUbIeAAAAAE4_GcvvLdPslwRVqdl2sCueTXWh";
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);
        // should return JSON with success as true
        if ($responseKeys["success"]) {
        } else {
            $errors[] = 'You are a robot';
        }
    }


    if (count($errors) > 0) {
        echo '<div class="alert alert-danger" role="alert"><ul>';
        foreach ($errors as $e) {
            echo '<li>' . $e . '</li>';
        }
        echo '</ul></div>';
    } else {
        $user_id = $_REQUEST['user_id'];
        $user_info = get_userdata($user_id);
        $data = array(
            "rdh_id" => $user_id,
            "user_email" => $_REQUEST['user-email'],
            "full_name" => $_REQUEST['user-name'],
            "type" => $_REQUEST['type'],
            "message" => $_REQUEST['message'],

        );
        rdh_contact_db_query($data);
        $emails = WC()->mailer()->get_emails();
        $respose =   $emails['RDH_Contact_Email']->trigger($user_id);
        $to = $_REQUEST['user-email'];
        $name = $_REQUEST['user-name'];
        $url = registerNodeCustomer($name, $to, $user_info->user_email, $_REQUEST['message']);
        if ($url != 'error') {
            // Set the email subject
            $subject = 'Smile Brillaint RDH Query';
            $appendUrl = $_REQUEST['current_url'] . $url;
            // Set the message body with the HTML link
            $message = '<p>Dear ' . $name . ',</p>';
            $message .= '<p>:</p>';
            $message .= '<p><a href="' . $appendUrl . '">Please click on the following link for futher chat</a></p>';
            // Set the email headers to include HTML content
            $headers = array('Content-Type: text/html; charset=UTF-8');

            // Send the email using wp_mail
            //   wp_mail($to, $subject, $message, $headers);
        }
        echo '<div class="alert alert-success" role="alert">Thanks for contacting us, we’ll be in touch shortly.</div> <style> #rdhContactForm{ display: none;}</style>';
        // echo '<div class="alert alert-success" role="alert">Thanks for contacting us, we’ll be in touch shortly.</div>';
    }
    die;
}
/**
 * Inserts contact data into the 'rdh_contact' table in the WordPress database.
 *
 * @param array $param {
 *     Optional. An array of parameters for inserting contact data.
 *
 *     @type int    $rdh_id      RDH ID. Default is 0.
 *     @type string $user_email  User email. Default is empty.
 *     @type string $full_name   Full name. Default is empty.
 *     @type string $type        Type of contact. Default is empty.
 *     @type string $message     Message. Default is empty.
 *     @type string $created_at  Created date and time. Default is the current date and time.
 * }
 * @return int The ID of the inserted contact data.
 */
function rdh_contact_db_query($param = array())
{
    global $wpdb;
    $data = array(
        "rdh_id" => isset($param['rdh_id']) ? $param['rdh_id'] : 0,
        "user_email" => isset($param['user_email']) ? $param['user_email'] : 0,
        "full_name" => isset($param['full_name']) ? $param['full_name'] : '',
        "type" => isset($param['type']) ? $param['type'] : '',
        "message" => isset($param['message']) ? $param['message'] : '',
        "created_at" => date("Y-m-d h:i:sa"),

    );
    $wpdb->insert('rdh_contact', $data);
    return $wpdb->insert_id;
}



/**
 * AJAX callback function for loading BB sign-ups data.
 * Retrieves and outputs user data for DataTables in the WordPress admin.
 */

add_action('wp_ajax_saveRDHC_information', 'saveRDHC_information_callback');
/**
 * AJAX callback function for saving RDHC information.
 * Updates user meta fields with new information sent via AJAX.
 */
function saveRDHC_information_callback()
{
    update_user_meta($_REQUEST['user_id'], 'first_name', $_REQUEST['first_name']);
    update_user_meta($_REQUEST['user_id'], 'last_name', $_REQUEST['last_name']);
    update_user_meta($_REQUEST['user_id'], 'description', $_REQUEST['meta_description']);
    echo 'RDHC Information Updated';
    die;
}


add_action('wp_ajax_editRDHC_information', 'editRDHC_information_callback');
/**
 * AJAX callback function for editing RDHC information.
 * Displays a form for editing RDHC profile information in the WordPress admin.
 */
function editRDHC_information_callback()
{
    $user_id = isset($_REQUEST['user_id']) ?  $_REQUEST['user_id'] :  0;
    if ($user_id) {
        $new_user = get_userdata($user_id); //$user_id is passed as a parameter
        $first_name = $new_user->first_name;
        $user_login = $new_user->user_login;
        $last_name = $new_user->last_name;
        $meta_description = get_the_author_meta('description', $user_id);
?>
        <form id="rdhcManagement">
            <div class="search-shipement">
                <h3><span class="dashicons dashicons-networking"></span>&nbsp;Edit RDHC Profile Information</h3>
            </div>
            <div class="loading-sbr" style="display: none;">
                <div class="inner-sbr"></div>
            </div>

            <table class="form-table" role="presentation">
                <tbody>
                    <tr class="user-user-login-wrap">
                        <th><label for="user_login">Username</label></th>
                        <td><input type="text" name="" id="user_login" value="<?php echo $user_login; ?>" disabled="disabled" class="regular-text"> <span class="description">Usernames cannot be changed.</span></td>
                    </tr>


                    <tr class="user-first-name-wrap">
                        <th><label for="first_name">First Name</label></th>
                        <td><input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" class="regular-text"></td>
                    </tr>

                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">Last Name</label></th>
                        <td><input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" class="regular-text"></td>
                    </tr>
                    <tr class="user-last-name-wrap">
                        <th><label for="last_name">Meta description / Products</label></th>
                        <td><textarea name="meta_description" id="meta_description" class="regular-text"><?php echo $meta_description; ?></textarea> </td>
                    </tr>
                    <tr class="">
                        <td colspan="2">
                            <input type="hidden" name="action" value="saveRDHC_information" />
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                            <p class="submit"><input type="button" name="submit" id="edit_rdhc_informationUpdate" class="button button-primary" value="Update User"><span class="spinner"></span></p>
                        </td>
                    </tr>

                </tbody>
            </table>
        </form>
    <?php
    } else {
        echo 'User not a register user in system.';
    }

    ?>


<?php

    die;
}
/**
 * Enqueues necessary scripts and styles, and generates the RDH management form with a DataTable.
 * Handles AJAX requests for loading RDH data and updating RDH information.
 *
 * @return void Outputs the HTML content for the RDH management form.
 */
function sbr_rdhManagement()
{

    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);
    wp_enqueue_script('dataTablesbtn0', 'https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/datatables.min.js', '1.0.0', true);
    wp_enqueue_script('dataTablesbtn2', 'https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js', '1.0.0', true);
    wp_enqueue_script('dataTablesbtn1', 'https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js', '1.0.0', true);


?>

    <form id="saleManagement">
        <div class="search-shipement">
            <h3><span class="dashicons dashicons-networking"></span>&nbsp; RDH management</h3>
            <a class="button btn" href="javascript:void(0);" id="getValuesButton"> Send Message </a>

        </div>
        <div class="loading-sbr" style="display: none;">
            <div class="inner-sbr"></div>
        </div>

        <table id="sale" class="data-table" style="width:99%">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>User Email</th>

                    <th>Reference</th>
                    <th>Invite Code / Usage Limit</th>
                    <th>Registered</th>
                    <th>Profile pic</th>
                    <th>Intro</th>
                    <th>Jobs</th>
                    <th>Education</th>
                    <th>Login Frequency</th>

                    <th>Video embed code</th>

                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>

        </table>

    </form>

    <style>
        table.dataTable tbody tr {
            background-color: #fff;
            text-align: center;
        }

        .ims_edit_icon {
            margin-top: 0px;
            /* display: block;
                position: relative;
                top: -34px;
                margin-left: auto; */
            text-align: right;
            width: 20px;
            background: #ffffff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            z-index: 1;
            justify-content: end;
            /* right: -18px; */
            text-decoration: none;
        }

        .ims_edit_icon::before {
            font-family: Dashicons;
            speak: none;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            margin: 0;
            text-indent: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            content: "\f464";
            position: relative;
            font-size: 18px;
        }
    </style>
    <script type="text/javascript">
        var datatable_rdhc;
        jQuery(document).ready(function() {

            datatable_rdhc = jQuery('#sale').DataTable({
                "ordering": false,
                "searching": true,
                "bPaginate": true,
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }],
                "dom": "Bfrtip",
                "processing": true,
                "serverSide": false,
                "clientSide": true,
                "pageLength": 15,
                "ajax": {
                    url: "<?php echo admin_url('admin-ajax.php?action=sbr_loadBbSignUps'); ?>",
                    type: "GET",
                    "data": function(d) {

                    },
                    "complete": function(response) {

                        // add custom filter controls to columns 9-12
                        datatable_rdhc.columns([8, 9, 10, 11]).every(function() {
                            var column = this;
                            var select = jQuery('<select><option value="">All</option><option value="yes">Yes</option><option value="no">No</option></select>')
                                .appendTo(jQuery(column.header()).empty())
                                .on('change', function() {
                                    var val = jQuery.fn.dataTable.util.escapeRegex(
                                        jQuery(this).val()
                                    );

                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
                        });
                        jQuery('#sale').find('tr th:nth(8)').prepend('Profile Pic');
                        jQuery('#sale').find('tr th:nth(9)').prepend('Intro');
                        jQuery('#sale').find('tr th:nth(10)').prepend('Experience');
                        jQuery('#sale').find('tr th:nth(11)').prepend('Education');
                        jQuery('.loading-sbr').hide();
                    }

                },
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }],
            });

        });

        var checkedValues = [];

        function handleCheckboxChange(checkbox) {
            var value = checkbox.value;

            // Check if the checkbox is checked
            if (checkbox.checked) {
                // Add the value to the array if not already present
                if (!checkedValues.includes(value)) {
                    checkedValues.push(value);
                }
            } else {
                // Remove the value from the array if present
                var index = checkedValues.indexOf(value);
                if (index !== -1) {
                    checkedValues.splice(index, 1);
                }
            }

            // Optional: Display the current checkedValues array in the console
            console.log(checkedValues);
        }
        document.getElementById("getValuesButton").addEventListener("click", function() {

            // var checkboxes = document.querySelectorAll("input[name='rdh_address[]']:checked");
            //   var checkedValues = [];

            //   checkboxes.forEach(function(checkbox) {
            //     checkedValues.push(checkbox.value);
            //   });

            if (checkedValues.length > 0) {
                var commaSeparatedString = checkedValues.join(',');
                window.location.href = '<?php echo home_url(); ?>/my-account/support/?active-tab=chat&rdh_address=' + commaSeparatedString;
                console.log("Comma-Separated String: ", commaSeparatedString);
                // Perform any action on the comma-separated string here
            } else {
                alert("please select at leaset one RDH");
            }
        });

        jQuery('body').on('click', '#edit_rdhc_informationUpdate', function() {

            jQuery('body').find('#rdhcManagement').block({
                message: '',
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            var elementT = document.getElementById("rdhcManagement");
            var formdata = new FormData(elementT);
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                method: 'POST',
                dataType: 'html',
                success: function(response) {
                    // datatable_rdhc.ajax.reload();
                    jQuery('body').find('#rdhcManagement').unblock();
                    smile_brillaint_order_modal.style.display = "none";
                    Swal.fire(response, '', 'success');
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });
        jQuery('body').on('click', '.btnIMSUpdate', function() {
            var get_parent = jQuery(this).parentsUntil('.imsWapper');
            var user__id = get_parent.find('.user__id').val();
            var type = get_parent.find('.type').val();
            get_parent.find('.ims_inputDiv').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            if (type == 'rdhc') {
                var inviteCode = get_parent.find('.inviteCode').val();
                var limit = get_parent.find('.limit').val();
                var data = {
                    action: 'updateRdhcInfo',
                    user_id: user__id,
                    inviteCode: inviteCode,
                    limit: limit,
                    type: type,
                };
            } else {
                var videoUrl = get_parent.find('.video_url').val();
                var data = {
                    action: 'updateRdhcInfo',
                    user_id: user__id,
                    videoUrl: videoUrl,
                    type: type,
                };
            }


            //Sending data
            jQuery.ajax({
                url: ajaxurl,
                data: data,
                method: 'POST',
                //  dataType: 'JSON',
                // async: false,
                success: function(response) {
                    Swal.fire(response, '', 'info');
                    datatable_rdhc.ajax.reload();
                    //alert(response);
                    get_parent.find('.ims_inputDiv').unblock();
                    get_parent.find('span').show();
                    get_parent.find('.ims_inputDiv').hide();
                    get_parent.find('.ims_edit_icon').show();
                },
                error: function(response) {
                    get_parent.find('.ims_inputDiv').unblock();
                }
            });
        });
        jQuery('body').on('click', '.btnIMSUpdateeeee', function() {
            var get_parent = jQuery(this).parentsUntil('.imsWapper');
            var videoUrl = get_parent.find('.video_url').val();
            var user__id = get_parent.find('.user__id').val();
            var type = get_parent.find('.type').val();


            get_parent.find('.ims_inputDiv').block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            //Sending data
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    action: 'updateRdhcInfo',
                    user_id: user__id,
                    videoUrl: videoUrl,
                    type: type,
                },
                method: 'POST',
                //  dataType: 'JSON',
                // async: false,
                success: function(response) {
                    datatable_rdhc.ajax.reload();
                    get_parent.find('.ims_inputDiv').unblock();
                    get_parent.find('span').show();
                    get_parent.find('.ims_inputDiv').hide();
                    get_parent.find('.ims_edit_icon').show();
                },
                error: function(response) {
                    get_parent.find('.ims_inputDiv').unblock();
                }
            });
        });
        jQuery('body').on('click', '.ims_edit_icon', function() {
            $this = jQuery(this);
            var get_parent = jQuery(this).parentsUntil('.imsWapper');
            console.log(get_parent)
            get_parent.find('span').hide();
            $this.hide();
            get_parent.find('.ims_inputDiv').show();
            get_parent.find('.btnIMScancel').show();
        });
        jQuery('body').on('click', '.btnIMScancel', function() {
            $this = jQuery(this);
            var get_parent = jQuery(this).parentsUntil('.imsWapper');
            get_parent.find('span').show();
            get_parent.find('.ims_inputDiv').hide();
            get_parent.find('.ims_edit_icon').show();
        });
    </script>
<?php
}

add_action('wp_ajax_updateRdhcInfo', 'updateRdhcInfo_callback');

/**
 * Callback function for updating RDHC information via AJAX.
 *
 * @return void Echoes the result of the operation.
 */
function updateRdhcInfo_callback()
{

    if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0) {
        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'rdhc') {
            echo sbr_rdhc_insert_or_update_invite_code($_REQUEST['user_id'], $_REQUEST['inviteCode'], $_REQUEST['limit']);
        } else {
            update_user_meta($_REQUEST['user_id'], 'rdhc_video_', $_REQUEST['videoUrl']);
            echo 'RDHC Information Updated';
        }
    } else {
        echo 'User ID missing.';
    }

    die;
}


/**
 * Inserts or updates an invite code for a user in the RDHC system.
 *
 * @param int    $user_id The user ID.
 * @param string $code    The invite code.
 * @param int    $limit   The usage limit.
 *
 * @return string Result message indicating the outcome of the operation.
 */
function sbr_rdhc_insert_or_update_invite_code($user_id, $code, $limit)
{
    global $wpdb;
    $table_name = 'sbr_rdhc_invite_codes';
    $user_email = $wpdb->get_var($wpdb->prepare(
        "SELECT user_email FROM $wpdb->users WHERE ID = %d",
        $user_id
    ));
    if (!$user_email) {
        return 'User ID not found';
    }

    if (!$code) {
        return 'Invite code not found';
    }
    if (!$user_id) {
        return 'User ID not found';
    }
    if (!$limit) {
        return 'Usage limit not found';
    }

    if (strlen($code) > 50) {
        return 'Code is too long';
    }

    $existing_user = $wpdb->get_var("SELECT user_id FROM $table_name WHERE code = '$code'");
    if (!empty($existing_user) && ($existing_user != $user_id)) {
        return 'Code already exists';
    }

    $existing_entry = $wpdb->get_row("SELECT * FROM $table_name WHERE user_id = $user_id AND user_email = '$user_email'");
    if ($existing_entry) {
        $wpdb->update(
            $table_name,
            array(
                'code' => $code,
                'limit' => $limit,
                'created_at' => current_time('mysql')
            ),
            array('user_id' => $user_id)
        );
        return 'Update existing entry';
    } else {
        $existing_code = $wpdb->get_var("SELECT code FROM $table_name WHERE user_id != $user_id AND code = '$code'");
        if ($existing_code) {
            return 'Code already linked to another user';
        }
        $wpdb->insert(
            $table_name,
            array(
                'user_id' => $user_id,
                'user_email' => $user_email,
                'code' => $code,
                'limit' => $limit,
                'created_at' => current_time('mysql')
            )
        );
        return 'Insert new entry';
    }
}

/**
 * Generates a unique invite code for RDHC.
 *
 * @return string The generated invite code.
 */
function generateRMCode()
{
    global $wpdb;
    $characters = '23456789ABCDEFGHJKMNPQRSTUVWXYZ'; // exclude 0,o,L,i,Q,1
    $code = 'RM';
    for ($i = 0; $i < 3; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    $code .= rand(2, 9);
    $existing_code = $wpdb->get_var("SELECT code FROM sbr_rdhc_invite_codes WHERE code = '$code'");
    if ($existing_code) {
        // If the code already exists, generate a new one recursively
        return generateRMCode();
    } else {
        return $code;
    }
}
/**
 * Retrieves the invite code information for a given user identifier.
 *
 * @param int|string $identifier User ID or user email.
 *
 * @return object|false Invite code information if found, otherwise false.
 */
function sbr_rdhc_retrieve_invite_code($identifier)
{
    global $wpdb;
    $table_name = 'sbr_rdhc_invite_codes';

    if (is_numeric($identifier)) {
        // Search by user_id
        $response = $wpdb->get_row("SELECT * FROM $table_name WHERE user_id = $identifier");
    } else {
        // Search by user_email
        $response = $wpdb->get_row("SELECT * FROM $table_name WHERE user_email = $identifier");
    }

    return $response;
}
/**
 * Retrieves all invite codes.
 *
 * @return array Array of invite codes.
 */
function sbr_rdhc_all_retrieve_invite_codes()
{
    global $wpdb;
    $table_name = 'sbr_rdhc_invite_codes';
    $response = $wpdb->get_col("SELECT code FROM $table_name");
    return $response;
}

/**
 * Inserts a new invite code record for the given user ID.
 *
 * @param int $user_id The user ID.
 *
 * @return int|false The inserted record ID if successful, otherwise false.
 */
function sbr_rdhc_invite_codes_query($user_id)
{
    global $wpdb;
    $table_name = 'sbr_rdhc_invite_codes';
    $user_email = $wpdb->get_var($wpdb->prepare(
        "SELECT user_email FROM $wpdb->users WHERE ID = %d",
        $user_id
    ));
    $data = array(
        'user_id' => $user_id,
        'user_email' =>  $user_email,
        'code' =>  generateRMCode(),
        'limit' => 5,
        'created_at' => current_time('mysql')
    );

    $wpdb->insert($table_name, $data);

    return $wpdb->insert_id;
}

/**
 * Generates and displays HTML for the custom RDHC invite code section.
 *
 * @param int $user_id User ID.
 *
 * @return string HTML output for the custom RDHC invite code section.
 */
function sbr_rdhc_invite_code_html($user_id)
{

    ob_start();
    $data =  sbr_rdhc_retrieve_invite_code($user_id);
    $code = '';
    $limit = '0';
    $display = 'Add';
    if (isset($data->code)) {
        $code = $data->code;
        $limit = $data->limit;
        $display = $code . '/' . $limit;
    }

?>
    <div class="imsWapper customRDHCInviteCode">
        <div class="ims_container" user_id="<?php echo $user_id; ?>">

            <div class="IMSEditDiv">
                <span><?php echo $display; ?></span>
                <a class="ims_edit_icon" href="javascript:;"></a>
            </div>


            <div class="ims_inputDiv flex-row-mbt" style="display: none;">
                <b><?php echo  generateRMCode(); ?></b>
                <br />
                <label>Invite Code.
                    <input type="text" class="ims-input inviteCode" name="inviteCode" placeholder="invite Code" value="<?php echo $code; ?>">
                </label>
                <label>Usage Limit.
                    <input type="text" class="ims-input limit" name="limit" placeholder="Usage Limit" value="<?php echo $limit; ?>">
                </label>
                <input type="hidden" class="type" value="rdhc">
                <input type="hidden" class="user__id" value="<?php echo $user_id; ?>">

                <div class="button-parent-batch-print">
                    <div class="btn_save"><button class="btnIMSUpdate" type="button">Save</button></div>
                    <div class="btn_cancel"><button class="btnIMScancel" type="button">Cancel</button></div>
                </div>
            </div>
        </div>
    </div>
<?php
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}

/**
 * Updates the login count for a user.
 *
 * @param string $user_login User login name.
 * @param WP_User $user      User object.
 */
function update_user_login_count($user_login, $user)
{
    $user_id = $user->ID;
    $current_count = get_user_meta($user_id, 'login_count_mbt', true) ?: 0;
    $updated_count = $current_count + 1;
    update_user_meta($user_id, 'login_count_mbt', $updated_count);
}
add_action('wp_login', 'update_user_login_count', 10, 2);
