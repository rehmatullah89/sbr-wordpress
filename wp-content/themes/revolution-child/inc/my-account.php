<?php

add_action('wp_ajax_send_ticket_message_customer', 'send_ticket_message_customer_callback');
function send_ticket_message_customer_callback()
{
    global $wpdb;
    $responseTicket = '';
    $responseData = array();

    $requester_id = $_REQUEST['zendesk_user_id'];
    $messagess = $_REQUEST['message'];
    $message = str_replace("&nbsp;", "", $messagess);
    $message = str_replace("\\", "", $message);
    $medium = isset($_REQUEST['medium']) ? $_REQUEST['medium'] : 'email';
    $attachments = isset($_REQUEST['tokenAttachment']) ? $_REQUEST['tokenAttachment'] : array();
    // $subject_request = $_REQUEST['zendesk_request'];
    $ticket_id = isset($_REQUEST['ticket_id']) ? $_REQUEST['ticket_id'] : 0;
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'general_inquiry';
    if ($message == '') {
        $responseData['status'] = 'error';
        $responseData['message'] = 'unable to add comment. Message Empty';
        echo json_encode($responseData);
        die();
    }
    if ($ticket_id) {

        $arr = array();

        $arr['ticket'] = array(
            "status" => 'open',
            "comment" => array(
                "html_body" => force_balance_tags($message),
                "uploads" => $attachments,
                "author_id" => $requester_id
            ),
            "custom_fields" => array(
                array(
                    "id" => 4417382819865,
                    "value" => $medium
                )
            )
        );
        $data_string = json_encode($arr);
        $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
            )
        );

        $result = curl_exec($ch);
        $results = json_decode($result, true);
        if (isset($results['ticket']['id']) && $results['ticket']['id'] > 0) {
            $ticketInfo = sb_ticket_comments_zendesk($results['ticket']['id']);
            if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
                $responseData['status'] = 'success';
            } else {
                $responseData['status'] = 'success';
            }
            $responseData['message'] = $ticketInfo['html'];
            echo json_encode($responseData);
            die();
        } else {
            $responseData['status'] = 'error';
            $responseData['message'] = 'Unable to add comment.';
            echo json_encode($responseData);
            die();
        }
    } else {



        $subject = ucwords(str_replace("_", " ", $type));
        $arr = array();
        $arr['ticket'] = array(
            "subject" => $subject,
            "comment" =>  array(
                "html_body" => force_balance_tags($message),
                "uploads" => $attachments,
                "author_id" => $requester_id
            ),
            "priority" => 'normal',
            "assignee_id" => SB_ZENDESK_AGENT,
            "requester_id" => $requester_id,
            // "submitter_id" => $requester_id,
            "custom_fields" => array(
                array(
                    "id" => 4417382819865,
                    "value" => $medium
                ),
                array(
                    "id" => 900010956323,
                    "value" => $type
                )
            )
        );
        $data_string = json_encode($arr);
        $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );

        $result = curl_exec($ch);

        $ticket_created = json_decode($result, true);
        if (isset($ticket_created['ticket']['id']) && $ticket_created['ticket']['id'] != '') {

            $ticketInfo = sb_ticket_comments_zendesk($ticket_created['ticket']['id']);
            if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
                $responseData['status'] = 'success';
            } else {
                $responseData['status'] = 'success';
            }
            $responseData['message'] = $ticketInfo['html'];
            echo json_encode($responseData);
            die();
        } else {

            $responseData['status'] = 'error';
            $responseData['message'] = 'Unable to add comment.';
            echo json_encode($responseData);
            die();
        }
    }
}


add_action('wp_ajax_oralProfile', 'oralProfile_callback');
function oralProfile_callback()
{
    $cUser = get_current_user_id();
    update_user_meta($cUser, 'teeth-color',  $_REQUEST['teeth-color']);
    update_user_meta($cUser, 'teeth-sensitivity',  $_REQUEST['teeth-sensitivity']);
    $response = array(
        'code' => 'success',
        'msg' => '<div class="alert alert-success" role="alert">Information Updated Successfully.</div>',
        'html' => oralProfileDisplay($cUser)
    );
    echo json_encode($response);
    die;
}



add_action('wp_ajax_customerBasicInformation', 'customerBasicInformation_callback');
function customerBasicInformation_callback()
{

    $cUser = get_current_user_id();
    $user_data = wp_update_user(array(
        'ID' => $cUser,
        'display_name' => $_REQUEST['display_name'],
        'first_name' => $_REQUEST['user_firstname'],
        'last_name' => $_REQUEST['user_lastname'],
        'user_email' => $_REQUEST['user_email']
    ));
    if (!filter_var($_REQUEST['user_email'], FILTER_VALIDATE_EMAIL)) {
        $response = array(
            'code' => 'error',
            'msg' => '<div class="alert alert-danger" role="alert">Invalid email address</div>',
            'html' => customerProfileDisplay($cUser)
        );
        echo json_encode($response);
        die;
    }
    update_user_meta($cUser, 'billing_phone',  $_REQUEST['billing_phone']);
    if (is_wp_error($user_data)) {
        $response = array(
            'code' => 'error',
            'msg' => '<div class="alert alert-danger" role="alert">' . $user_data->get_error_message() . '</div>',
            'html' => customerProfileDisplay($cUser)
        );
    } else {
        $response = array(
            'code' => 'success',
            'msg' => '<div class="alert alert-success" role="alert">Information updated successfully.</div>',
            'html' => customerProfileDisplay($cUser)
        );
    }
    echo json_encode($response);
    die;
}


add_action('wp_ajax_contactBasicInformation', 'contactBasicInformation_callback');
function contactBasicInformation_callback()
{
    $error = false;
    $err = '';
    if (!filter_var($_REQUEST['s_instagram'], FILTER_VALIDATE_URL) && $_REQUEST['s_instagram'] != '') {
        $err .= "<div class='alert alert-danger'> Invalid instagram url</div>";
        $error = true;
    }
    if (!filter_var($_REQUEST['s_twitter'], FILTER_VALIDATE_URL) && $_REQUEST['s_twitter'] != '') {
        $err .= "<div class='alert alert-danger'> Invalid twitter url</div>";
        $error = true;
    }
    if (!filter_var($_REQUEST['s_facebook'], FILTER_VALIDATE_URL) && $_REQUEST['s_facebook'] != '') {
        $err .= "<div class='alert alert-danger'> Invalid facebook url</div>";
        $error = true;
    }
    if (!filter_var($_REQUEST['s_youtube'], FILTER_VALIDATE_URL) && $_REQUEST['s_youtube'] != '') {
        $err .= "<div class='alert alert-danger'> Invalid youtube url</div>";
        $error = true;
    }
    if (!filter_var($_REQUEST['s_pinterest'], FILTER_VALIDATE_URL) && $_REQUEST['s_pinterest'] != '') {
        $err .= "<div class='alert alert-danger'> Invalid pinterest url</div>";
        $error = true;
    }
    if (!filter_var($_REQUEST['s_blog'], FILTER_VALIDATE_URL) && $_REQUEST['s_blog'] != '') {
        $err .= "<div class='alert alert-danger'> Invalid blog url</div>";
        $error = true;
    }
    if (!filter_var($_REQUEST['s_tikTok'], FILTER_VALIDATE_URL) && $_REQUEST['s_tikTok'] != '') {
        $err .= "<div class='alert alert-danger'> Invalid tiktok url</div>";
        $error = true;
    }
    $cUser = get_current_user_id();
    if ($error) {
        $response = array(
            'code' => 'error',
            'msg' =>  $err,
            'html' => soicalProfileDisplay($cUser)
        );
        echo json_encode($response);
        die;
    }

    update_user_meta($cUser, 's_instagram', $_REQUEST['s_instagram']);
    update_user_meta($cUser, 's_twitter', $_REQUEST['s_twitter']);
    update_user_meta($cUser, 's_facebook', $_REQUEST['s_facebook']);
    update_user_meta($cUser, 's_youtube', $_REQUEST['s_youtube']);
    update_user_meta($cUser, 's_pinterest', $_REQUEST['s_pinterest']);
    update_user_meta($cUser, 's_blog', $_REQUEST['s_blog']);
    update_user_meta($cUser, 's_tikTok', $_REQUEST['s_tikTok']);
    update_user_meta($cUser, 's_linkedin', $_REQUEST['s_linkedin']);
    global $wpdb;
    $result = $wpdb->delete(
        'buddy_user_meta',

        array('user_id' => $cUser, 'key' => 'social')
    );
    $social = array(
        'facebook' => $_REQUEST['s_facebook'],
        'instagram' => $_REQUEST['s_instagram'],
        'linkedin' => $_REQUEST['s_linkedin'],
        'twitter' => $_REQUEST['s_twitter'],
        'tiktok' => $_REQUEST['s_tikTok'],
        'blog' => $_REQUEST['s_blog'],
        'youtube' => $_REQUEST['s_youtube']
    );
    $wpdb->insert('buddy_user_meta', array(
        'user_id' => $cUser,
        'key' => 'social',
        'value' => json_encode($social),
    ));
    $response = array(
        'code' => 'success',
        'msg' => '<div class="alert alert-success" role="alert">Information Updated Successfully.</div>',
        'html' => soicalProfileDisplay($cUser)
    );
    echo json_encode($response);
    die;
}
function customerProfileDisplay()
{
    $curuserid =  get_current_user_id();
    $current_userr = wp_get_current_user();
    $fname = $current_userr->user_firstname;
    if ($fname == '') {
        update_user_meta($curuserid, 'first_name', get_user_meta($curuserid, 'first_name_temp', true));
    }
    $current_user = wp_get_current_user();

    ob_start();
?>
    <li>
        <div class="cardWrapper">
            <div class="flex-div-wrapper">
                <div class="profile-image-avatar">
                    <img src="<?php echo esc_url(get_avatar_url(get_current_user_id())); ?>" class="avatar img-circle img-thumbnail" alt="avatar">
                    <!-- <h6>Upload a different photo...                </h6> -->
                    <?php if (function_exists('bp_is_active')) { ?>
                        <a href="/members/<?php echo bp_core_get_username(get_current_user_id()); ?>/profile/change-avatar" class="editProfilePhoto loaderActive"><i class="fa fa-pencil" aria-hidden="true"></i> <span>edit photo</span></a>
                    <?php } ?>
                </div>
                <div class="contentToShow">
                    <div class="row">
                        <div class="col-12 displayField">
                            <span>Username:</span>
                        </div>
                        <div class="col-12 displayFieldResults">
                            <span class="customerIdNumber"><a href="javascipt:void(0);" class=""><?php echo $current_user->user_login; ?></a></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 displayField">
                            <span>Email:</span>
                        </div>
                        <div class="col-12 displayFieldResults">
                            <div class="infoCDisplay"><?php echo esc_html($current_user->user_email); ?></div>
                            <div class="infoCEdit"> <span class="customerIdNumber"><a href="javascipt:void(0);" class=""><?php echo $current_user->user_email; ?></a></span><input type="email" class="form-control custom-req" readonly name="user_email" value="<?php echo esc_html($current_user->user_email); ?>" style="display:none"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 displayField">
                            <span>Customer ID Number:</span>
                        </div>
                        <div class="col-12 displayFieldResults">
                            <span class="customerIdNumber"><a href="javascipt:;" class="">C-<?php echo $current_user->ID; ?></a></span>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </li>

    <li>
        <div class="row">
            <div class="col-12 displayField">

                <span>First Name:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo esc_html($current_user->user_firstname); ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="user_firstname" value="<?php echo esc_html($current_user->user_firstname); ?>"></div>
            </div>
        </div>
    </li>
    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>Last Name:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo esc_html($current_user->user_lastname); ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="user_lastname" value="<?php echo esc_html($current_user->user_lastname); ?>"></div>
            </div>
        </div>
    </li>


    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>Phone Number:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo get_user_meta($current_user->ID, 'billing_phone', true); ?></div>
                <div class="infoCEdit"><input type="text" class="form-control custom-req" name="billing_phone" value="<?php echo get_user_meta($current_user->ID, 'billing_phone', true); ?>"></div>
            </div>
        </div>
    </li>


<?php
    return ob_get_clean();
}
function customerProfileDisplayOld()
{
    $current_user = wp_get_current_user();
    ob_start();
?>
    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>Username:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <span class="customerIdNumber"><a href="javascipt:void(0);" class="text-blue"><?php echo $current_user->user_login; ?></a></span>
            </div>
        </div>
    </li>
    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>Email:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo esc_html($current_user->user_email); ?></div>

                <div class="infoCEdit"> <span class="customerIdNumber"><a href="javascipt:void(0);" class="text-blue"><?php echo $current_user->user_email; ?></a></span><input type="email" class="form-control custom-req" readonly name="user_email" value="<?php echo esc_html($current_user->user_email); ?>" style="display:none"></div>
            </div>
        </div>
    </li>
    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>First Name:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo esc_html($current_user->user_firstname); ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="user_firstname" value="<?php echo esc_html($current_user->user_firstname); ?>"></div>
            </div>
        </div>
    </li>
    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>Last Name:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo esc_html($current_user->user_lastname); ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="user_lastname" value="<?php echo esc_html($current_user->user_lastname); ?>"></div>
            </div>
        </div>
    </li>


    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>Phone Number:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo get_user_meta($current_user->ID, 'billing_phone', true); ?></div>
                <div class="infoCEdit"><input type="text" class="form-control custom-req" name="billing_phone" value="<?php echo get_user_meta($current_user->ID, 'billing_phone', true); ?>"></div>
            </div>
        </div>
    </li>
    <li>
        <div class="row">
            <div class="col-12 displayField">
                <span>Customer ID Number:</span>
            </div>
            <div class="col-12 displayFieldResults">
                <span class="customerIdNumber"><a href="javascipt:;" class="text-blue">C-<?php echo $current_user->ID; ?></a></span>
            </div>
        </div>
    </li>

<?php
    return ob_get_clean();
}


function soicalProfileDisplay($cUser)
{
    ob_start();
    $input_instagram = $s_instagram = get_user_meta($cUser, 's_instagram', true);
    $input_twitter = $s_twitter = get_user_meta($cUser, 's_twitter', true);
    $input_facebook = $s_facebook = get_user_meta($cUser, 's_facebook', true);
    $input_youtube = $s_youtube = get_user_meta($cUser, 's_youtube', true);
    $input_linkedin = $s_linkedin = get_user_meta($cUser, 's_linkedin', true);
    $input_blog = $s_blog = get_user_meta($cUser, 's_blog', true);
    $input_tikTok = $s_tikTok = get_user_meta($cUser, 's_tikTok', true);

    if (empty($s_instagram)) {
        $s_instagram = 'N/A';
    }
    if (empty($s_twitter)) {
        $s_twitter = 'N/A';
    }
    if (empty($s_facebook)) {
        $s_facebook = 'N/A';
    }
    if (empty($s_youtube)) {
        $s_youtube = 'N/A';
    }
    if (empty($s_pinterest)) {
        $s_pinterest = 'N/A';
    }
    if (empty($s_blog)) {
        $s_blog = 'N/A';
    }
    if (empty($s_tikTok)) {
        $s_tikTok = 'N/A';
    }
?>

    <li>
        <div class="row align-items-center">
            <div class="col-12 displayField">
                <span class="d-flex align-items-center">
                    <span class="social-icon">
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </span>
                    <span class="socialName">
                        Instagram
                    </span>
                </span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo $s_instagram; ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="s_instagram" value="<?php echo $input_instagram; ?>"></div>
            </div>
        </div>
    </li>

    <li>
        <div class="row align-items-center">
            <div class="col-12 displayField">
                <span class="d-flex align-items-center">
                    <span class="social-icon">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </span>
                    <span class="socialName">
                        Twitter
                    </span>
                </span>
            </div>
            <div class="col-12 displayFieldResults">
                <div class="infoCDisplay"><?php echo $s_twitter; ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="s_twitter" value="<?php echo $input_twitter; ?>"></div>
            </div>
        </div>
    </li>

    <li>
        <div class="row align-items-center">
            <div class="col-12 displayField">
                <span class="d-flex align-items-center">
                    <span class="social-icon">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </span>
                    <span class="socialName">
                        Facebook
                    </span>
                </span>
            </div>
            <div class="col-12 displayFieldResults">

                <div class="infoCDisplay"><?php echo $s_facebook; ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="s_facebook" value="<?php echo $input_facebook; ?>"></div>
            </div>
        </div>
    </li>
    <li>
        <div class="row align-items-center">
            <div class="col-12 displayField">
                <span class="d-flex align-items-center">
                    <span class="social-icon">
                        <i class="fa fa-youtube" aria-hidden="true"></i>
                    </span>
                    <span class="socialName">
                        Youtube
                    </span>
                </span>
            </div>
            <div class="col-12 displayFieldResults">

                <div class="infoCDisplay"><?php echo $s_youtube; ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="s_youtube" value="<?php echo $input_youtube; ?>"></div>
            </div>
        </div>
    </li>
    <li>
        <div class="row align-items-center">
            <div class="col-12 displayField">
                <span class="d-flex align-items-center">
                    <span class="social-icon">
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                    </span>
                    <span class="socialName">
                        Linkedin
                    </span>
                </span>
            </div>
            <div class="col-12 displayFieldResults">

                <div class="infoCDisplay"><?php echo $s_linkedin; ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="s_linkedin" value="<?php echo $input_linkedin; ?>"></div>
            </div>
        </div>
    </li>
    <li>
        <div class="row align-items-center">
            <div class="col-12 displayField">
                <span class="d-flex align-items-center">
                    <span class="social-icon">
                        <img class="tiktokIcon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tiktok.svg" alt="" />
                        <i class="fa fa-tiktok" aria-hidden="true"></i>
                    </span>
                    <span class="socialName">
                        TikTok
                    </span>
                </span>
            </div>
            <div class="col-12 displayFieldResults">

                <div class="infoCDisplay"><?php echo $s_tikTok; ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="s_tikTok" value="<?php echo $input_tikTok; ?>"></div>
            </div>
        </div>
    </li>

    <li>
        <div class="row align-items-center">
            <div class="col-12 displayField">
                <span class="d-flex align-items-center">
                    <span class="social-icon">
                        <i class="fa fa-link" aria-hidden="true"></i>
                    </span>
                    <span class="socialName">
                        Blog
                    </span> </span>
            </div>
            <div class="col-12 displayFieldResults">

                <div class="infoCDisplay"><?php echo $s_blog; ?></div>
                <div class="infoCEdit"><input type="text" class="form-control" name="s_blog" value="<?php echo $input_blog; ?>"></div>
            </div>
        </div>
    </li>

<?php
    return ob_get_clean();
}



function oralProfileDisplay($cUser)
{
    ob_start();

?>

    <form id="oralProfile">



        <?php
        $cUser = get_current_user_id();
        $teethColor = get_user_meta($cUser, 'teeth-color', true);
        $teethSensitivity =  get_user_meta($cUser, 'teeth-sensitivity',  true);
        $teethColorData = array(
            'Off White', 'Pale white', 'Normal'
        );

        ?>
        <div id="teeth_info">
            <div class="card cartWithShahdow mb-3 no-radius">
                <div class="otionDisplay padd20">
                    <h4 class="weight-600 fnt-16 text-left">
                        Teeth Color
                    </h4>
                    <div class="row align-items-center teethColorDiv">
                        <?php

                        foreach ($teethColorData as $key =>  $tc) {
                            $activeClass = '';
                            $checked = '';
                            if ($teethColor == $tc) {
                                $activeClass = 'active';
                                $checked = 'checked=""';
                            }

                        ?>
                            <div class="option col-6 customRadioButton  <?php echo $activeClass ?>">
                                <div class="radioButtons">
                                    <input id="radio-<?php echo $key ?>" class="radio-custom" value="<?php echo $tc ?>" name="teeth-color" type="radio" <?php echo $checked ?> />
                                    <label for="radio-<?php echo $key ?>" class="radio-custom-label"> <span class="optionColor"><?php echo $tc ?></span></label>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>



            <div class="card cartWithShahdow mb-3 no-radius">

                <div class="otionDisplay padd20">
                    <h4 class="weight-600 fnt-16 text-left">
                        Teeth Sensitivity
                    </h4>
                    <div class="row align-items-center teethSensitivityDiv">
                        <?php

                        foreach ($teethColorData as $key =>  $ts) {
                            $activeClass = '';
                            $checked = '';
                            if ($teethSensitivity == $ts) {
                                $activeClass = 'active';
                                $checked = 'checked=""';
                            }

                        ?>
                            <div class="option col-6 customRadioButton <?php echo $activeClass ?>">
                                <div class="radioButtons">
                                    <input id="radio-5<?php echo $key ?>" class="radio-custom" value="<?php echo $ts ?>" name="teeth-sensitivity" type="radio" <?php echo $checked ?> />
                                    <label for="radio-5<?php echo $key ?>" class="radio-custom-label"> <span class="optionColor"><?php echo $ts ?></span></label>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="button text-right">
            <a href="javascript:;" class="buttonDefault smallRipple ripple-button blueBg " id="editProfileTab">edit info</a>
        </div>
        <div class="button text-right">
            <a href="javascript:;" class="buttonDefault smallRipple ripple-button" id="editProfileTabCancel">Cancel</a>
        </div>






    </form>

    <?php
    return ob_get_clean();




    $teethColor = get_user_meta($cUser, 'teeth-color', true);
    $teethSensitivity = get_user_meta($cUser, 'teeth-sensitivity', true);
    $teathVales = array(
        'Off White', 'Pale White', 'Normal'
    );

    ?>
    <div class="otionDisplay pb-3">
        <h4 class="weight-600 fnt-16 text-left">
            Teeth Color
        </h4>
        <div class="row align-items-center">
            <?php
            if ($teathVales) {
                foreach ($teathVales as $teath) {
                    $classteeth = 'crossIcon';
                    $textClass = '';
                    if ($teethColor == $teath) {
                        $classteeth = 'tickIcon';
                        $textClass = 'text-blue';
                    }
            ?>
                    <div class="option col-4 <?php echo $textClass; ?>">
                        <span class="checkIcon <?php echo $classteeth; ?>">
                            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                        </span>
                        <span class="optionColor"><?php echo $teath; ?></span>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>


    <div class="otionDisplay pb-3">
        <h4 class="weight-600 fnt-16 text-left">
            Teeth Sensitivity
        </h4>
        <div class="row align-items-center">
            <?php
            if ($teathVales) {
                foreach ($teathVales as $teath) {
                    $classteeth = 'crossIcon';
                    $textClass = '';
                    if ($teethSensitivity == $teath) {
                        $classteeth = 'tickIcon';
                        $textClass = 'text-blue';
                    }
            ?>
                    <div class="option col-4 <?php echo $textClass; ?>">
                        <span class="checkIcon <?php echo $classteeth; ?>">
                            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                        </span>
                        <span class="optionColor"><?php echo $teath; ?></span>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}


add_action('wp_ajax_getCustomerMyAccountOrders', 'getCustomerMyAccountOrders_callback');
function getCustomerMyAccountOrders_callback()
{
    global $wpdb;
    $paged = isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1;
    $postsPerPage = 10;
    $numorders = wc_get_customer_order_count(get_current_user_id());
    $customer_orders = get_posts(

        apply_filters(
            'woocommerce_my_account_my_orders_query',
            array(
                'numberposts' => $postsPerPage,
                'meta_key'    => '_customer_user',
                'paged' => $paged,
                'meta_value'  => get_current_user_id(),
                'post_type'   => wc_get_order_types('view-orders'),
                'post_status' => array_keys(wc_get_order_statuses()),
            )
        )

    );


    $customer_orders_count = get_posts(
        array(
            'posts_per_page'  => -1,
            'fields'          => 'ids',
            'meta_key'    => '_customer_user',
            'meta_value'  => get_current_user_id(),
            'post_type'   => wc_get_order_types('view-orders'),
            'post_status' => array_keys(wc_get_order_statuses()),
        )

    );
    // echo '<pre>';
    // print_r($customer_orders_count);
    // echo '</pre>';

    foreach ($customer_orders as  $customer_order) {
        $order      = wc_get_order($customer_order);
        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
    ?>

        <div class="card cardSection mb-3">
            <div class="cardHeader weight-600 uppercase">
                Order No: <span class="text-blue"><?php echo $order->get_order_number(); ?></span>
            </div>
            <div class="cardBody">
                <div class="row">
                    <div class="col publishDate">
                        <p class="mb-0"> Date: <span class="weight-600"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></span></p>
                    </div>
                    <div class="col publishStatus">
                        <p class="mb-0"> Status: <span class="weight-600"><?php echo esc_html(wc_get_order_status_name($order->get_status())); ?></span></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col publishPrice">
                        <p class="mb-0"> Price: <span class="weight-600">
                                <?php
                                echo $order->get_formatted_order_total();
                                ?>
                            </span></p>
                    </div>
                    <div class="col publishItems">
                        <p class="mb-0"> Items: <span class="weight-600"><?php echo $item_count; ?></span></p>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col detailsButton">
                        <div class="button">
                            <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="buttonDefault smallRipple ripple-button">Details</a>
                        </div>

                    </div>
                    <?php
                    if (in_array($order->get_status(), array('partial_ship', 'shipped', 'completed', 'on-hold', 'refunded'))) {
                        $order_number = $order->get_id();
                        $query = "SELECT  st.easyPostShipmentTrackingUrl FROM " . SB_EASYPOST_TABLE . " as st";
                        $query .= " JOIN " . SB_SHIPMENT_ORDERS_TABLE . " as l ON l.shipment_id=st.shipment_id";
                        $query .= " WHERE  l.order_id = $order_number AND st.shipmentState IS  NULL";
                        $query .= " ORDER BY st.shipment_id DESC ";
                        $query_tracking_number = $wpdb->get_var($query);
                        if ($query_tracking_number) {
                    ?>
                            <div class="col publishPackage">
                                <p class="text-blue mb-0"> <a href="<?php echo $query_tracking_number; ?>" target="_blank">Track package</a></p>
                            </div>
                    <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>

    <?php
    }
    ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php


            $total_pages = ceil(count($customer_orders_count) / $postsPerPage);
            /*
            if ($pages) :

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($paged === $i) {
                        echo '<li class="page-item"><a class="page-link active"  href="javascript:;">' . $i . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" onclick="getMoreOrders(' . $i . ')"  href="javascript:;">' . $i . '</a></li>';
                    }
                }
            endif;

*/

            echo "<ul class='pagination'>";
            if ($paged > 1)
                echo "<li class='page-item'><a class='page-link' onclick='getMoreOrders(" . ($paged - 1) . ")'  href='javascript:void(0)' ><</a></li>";

            $show = 0;
            for ($i = $paged; $i <= $total_pages; $i++) {
                $show++;
                if ($paged == $i)
                    echo "<li class='active page-item'>" . $i . "</li>";
                else if (($show < 5) || ($total_pages == $i))
                    echo "<li class='page-item'><a class='page-link' onclick='getMoreOrders(" . ($i) . ")'  href='javascript:void(0)'>" . $i . "</a></li>";
                else
                    echo "<li class='dot page-item'>.</li>";
            }

            if ($total_pages > $paged)
                echo "<li class='page-item'><a onclick='getMoreOrders(" . ($paged + 1) . ")'  href='javascript:void(0)'  class='page-link'>></a></li>";
            echo "</ul>";


            ?>
        </ul>
    </nav>
    <?php
    if (isset($_REQUEST['action'])) {
        die;
    }
}






add_action('wp_ajax_changePasswordScreen', 'changePasswordScreen_callback');
function changePasswordScreen_callback()
{

    // Processing form data when form is submitted
    $oldPassword = $newpassword = $newCpassword = '';
    $error = array();
    // Check if oldPassword is empty
    if (empty(trim($_REQUEST["oldPassword"]))) {
        $error[] = 'Old Password Filed is Empty !!';
    } else {
        $oldPassword = trim($_REQUEST["oldPassword"]);
    }

    // Check if password is empty
    if (empty(trim($_POST['newPass']))) {
        $error[] = 'New Password Filed is Empty !!';
    } else {
        $newpassword = trim($_POST['newPass']);
    }

    // Check if password is empty
    if (empty(trim($_POST['newConfirmPass']))) {
        $error[] = 'Confirm Password Filed is Empty !!';
    } else {
        $newCpassword = trim($_POST['newConfirmPass']);
    }

    // $number = preg_match('@[0-9]@', $newpassword);
    // $uppercase = preg_match('@[A-Z]@', $newpassword);
    // $lowercase = preg_match('@[a-z]@', $newpassword);
    // $specialChars = preg_match('@[^\w]@', $newpassword);

    // Validate credentials
    if (count($error) == 0) {

        if ($newpassword == $newCpassword) {
            if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $newpassword)) {
                $error[] = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
            } else {
                $cUser = wp_get_current_user();
                if (wp_check_password($oldPassword, $cUser->data->user_pass, $cUser->ID)) {
                    // Change password.
                    wp_set_password($newpassword, $cUser->ID);

                    // Log-in again.
                    wp_set_auth_cookie($cUser->ID);
                    wp_set_current_user($cUser->ID);
                    do_action('wp_login', $cUser->user_login, $cUser);
                } else {
                    $error[] = 'Old password not match. Please type correct password. ';
                }
            }
        } else {
            $error[] = 'Password and Confirm Password Field do not match  !!';
        }
    }

    if (count($error) > 0) {
        $errorList = '<ul>';
        foreach ($error as $key => $value) {
            $errorList .= '<li>' . $value . ' </li>';
        }
        $errorList .= '</ul>';
        $response = array(
            'code' => 'error',
            'msg' => '<div class="alert alert-danger" role="alert">' . $errorList . '</div>',
        );
    } else {
        $response = array(
            'code' => 'success',
            'msg' => '<div class="alert alert-success" role="alert">Password change successfully.</div>',
        );
    }

    echo json_encode($response);
    die;
}


/*
Refund Order
*/
function refundOrderButton($order_id, $orderNumber = '')
{
    ob_start();
    ?>
    <a href="javascript:void(0)" class="button btn-primary-blue" onclick="RefundOrderByIDMbt('<?php echo $order_id; ?>','<?php echo $orderNumber; ?>')">Replace/Return</a>

    <?php
    return ob_get_clean();
}

/*
Cancel Order
*/
function cancelOrderButton($order_id, $orderNumber = '')
{
    ob_start();
    //subscription#RB[1109-1121]
    $subscription_order = get_post_meta($order_id, '_subscriptionId', true);
    if ($subscription_order) {
    ?>
        <a href="javascript:void(0)" class="button btn-primary-blue cancelButtonListDetailPage" onclick="CancelOrderByIDMbt('<?php echo $order_id; ?>','<?php echo $orderNumber; ?>');CancelOrderSubscriptions('<?php echo $order_id; ?>');">Cancel<span class="displayOnlyDetailPage">&nbsp;Order</span> </a>
        <script>
            function CancelOrderSubscriptions(orderId) {
                if (orderId != '') {
                    jQuery('.loading-sbr').show();
                    jQuery.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: {
                            action: 'unsubscribe_order_items',
                            order_id: orderId
                        },
                        success: function(response) {
                            console.log(response);
                            jQuery('.loading-sbr').hide();
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }
        </script>

    <?php
    } else {
    ?>
        <a href="javascript:void(0)" class="button btn-primary-blue cancelButtonListDetailPage" onclick="CancelOrderByIDMbt('<?php echo $order_id; ?>','<?php echo $orderNumber; ?>')">Cancel<span class="displayOnlyDetailPage">&nbsp;Order</span> </a>
    <?php
    }
    //  return ob_get_clean();
    ?>


<?php
    return ob_get_clean();
}
add_action('wp_ajax_cancel_order_by_id_mbt', 'cancel_order_by_id_mbt');

function cancel_order_by_id_mbt($order_id = '')
{
    try {
        if ($order_id == '') {
            $order_id = $_POST['order_id'];
            $reason_cancellation = $_POST['reason_cancellation'];
            $message = $_POST['message'];
        }
        if ($order_id != '' && $reason_cancellation != '') {
            $order = new WC_Order($order_id);
            if (!empty($order)) {
                if ('processing' == $order->get_status() || 'pending' == $order->get_status()) {
                    insert_refund_reason('cancel', $reason_cancellation, $order_id);
                    $order->update_status('cancelled');
                    create_zendesk_ticket_status_changed($order, 'cancel');
                } else {
                    echo "Order cannot be cancelled as it's current status is " . $order->get_status();
                    die();
                }
            }
        }
        $res =  'success';
        $res  = preg_replace('/\s+/', '', $res);
        echo $res;
        die();
    } catch (\Exception $ex) {
        echo $ex->getMessage();
        die();
    }
}

add_action('wp_ajax_replace_order_by_id_mbt', 'replace_order_by_id_mbt');

function replace_order_by_id_mbt($order_id = '')
{
    try {
        if ($order_id == '') {
            $order_id = $_POST['order_id'];
            $reason_cancellation = $_POST['reason_refund'];
            $message = $_POST['message'];
        }
        if ($order_id != '' && $reason_cancellation != '') {
            $order = new WC_Order($order_id);
            if (!empty($order)) {
                if ('processing' != $order->get_status() || 'pending' != $order->get_status()) {
                    insert_refund_reason('replace', $reason_cancellation, $order_id);
                    create_zendesk_ticket_status_changed($order, 'replace');
                } else {
                    echo "Items cannot be replaced as current status of order is " . $order->get_status();
                    die();
                }
            }
        }
        $res =  'success';
        $res  = preg_replace('/\s+/', '', $res);
        echo $res;
        die();
    } catch (\Exception $ex) {
        echo $ex->getMessage();
        die();
    }
}

add_action('wp_ajax_refund_order_by_id_mbt', 'refund_order_by_id_mbt');

function refund_order_by_id_mbt($order_id = '')
{
    try {
        if ($order_id == '') {
            $order_id = $_POST['order_id'];
            $reason_cancellation = $_POST['reason_refund'];
            $message = $_POST['message'];
        }
        if ($order_id != '' && $reason_cancellation != '') {
            $order = new WC_Order($order_id);
            if (!empty($order)) {
                if ('processing' != $order->get_status() || 'pending' != $order->get_status()) {
                    insert_refund_reason('refund', $reason_cancellation, $order_id);

                    create_zendesk_ticket_status_changed($order, 'refund');
                } else {
                    echo "Items cannot be refunded as current status of order is " . $order->get_status();
                    die();
                }
            }
        }
        $res =  'success';
        $res  = preg_replace('/\s+/', '', $res);
        echo $res;
        die();
    } catch (\Exception $ex) {
        echo $ex->getMessage();
        die();
    }
}

function insert_refund_reason($type, $reason, $order_id)
{
    global $wpdb;
    $wpdb->insert('cancellation_refund_reasons', array(
        'type' => $type,
        'reason' => $reason,
        'order_id' => $order_id, // ... and so on
    ));
}



function getReorderKitButton($product_id, $item_id, $status)
{
    if (in_array($status, array('processing', 'on-hold'))) {
        return false;
    }
    if (has_term('addon', 'product_cat', $product_id)) {
        return false;
    }
    global $wpdb;
    //$tray_number = $wpdb->get_var("SELECT  tray_number FROM  " . SB_ORDER_TABLE . " WHERE item_id = $item_id");

    $night_guard_reorder_product = 739363;
    $night_guard_reorder_product_3mm = 795483;
    $whitening_product_id = 793962;
    $tray_price3mm = 0;
    $key3mm = 0;
    $html = '';
    $producttitle = get_the_title($product_id);
    $tray_price = get_post_meta($night_guard_reorder_product, 'any_whitening_system', true);
    $key = 'any_whitening_system';

    $titleHeading = 'Guards';
    /********************************* Start*************************/
    $itemData = $wpdb->get_row("SELECT tray_number , created_date FROM  " . SB_ORDER_TABLE . " WHERE item_id = $item_id");
    $tray_number = isset($itemData->tray_number) ? $itemData->tray_number : '';
    $created_date = isset($itemData->created_date) ? $itemData->created_date : '';
    $specific_date = '2024-04-01';
    $created_date = strtotime($created_date);
    $specific_date = strtotime($specific_date);
    if ($producttitle == '1 ULTRA-DURABLE NIGHT GUARD' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm)' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (Deluxe)' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm) (Deluxe)') {
        $key = '1_nightguards_package';
        $key3mm = '1_nightguards_package_3mm';
        if ($created_date > $specific_date) {
            $key = '1_nightguards_package_new';
            $key3mm = '1_nightguards_package_3mm_new';
        }

        $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
        $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
    } else if ($producttitle == '2 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm)' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (Deluxe)' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm) (Deluxe)') {


        $key3mm = '2_nightguards_package_3mm';
        $key = '2_nightguards_package';
        if ($created_date > $specific_date) {
            $key = '2_nightguards_package_new';
            $key3mm = '2_nightguards_package_3mm_new';
        }
        $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
        $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
    } else if ($producttitle == '4 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm)' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (Deluxe)' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm) (Deluxe)') {

        $key3mm = '4_nightguards_package_3mm';
        $key = '4_nightguards_package';
        if ($created_date > $specific_date) {
            $key = '4_nightguards_package_new';
            $key3mm = '4_nightguards_package_3mm_new';
        }
        $tray_price = get_post_meta($night_guard_reorder_product, $key, true);
        $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, $key, true);
    } else {
        $titleHeading = 'Tray';
    }
    /********************************* End*************************/
    /*
    if ($producttitle == '1 ULTRA-DURABLE NIGHT GUARD' || $producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm)') {
        $tray_price = get_post_meta($night_guard_reorder_product, '1_nightguards_package', true);
        $key = '1_nightguards_package';

        $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, '1_nightguards_package', true);
        $key3mm = '1_nightguards_package_3mm';
    } else if ($producttitle == '2 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm)') {
        $tray_price = get_post_meta($night_guard_reorder_product, '2_nightguards_package', true);
        $key = '2_nightguards_package';


        $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, '2_nightguards_package', true);
        $key3mm = '2_nightguards_package_3mm';
    } else if ($producttitle == '4 ULTRA-DURABLE NIGHT GUARDS' || $producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm)') {
        $tray_price = get_post_meta($night_guard_reorder_product, '4_nightguards_package', true);
        $key = '4_nightguards_package';

        $tray_price3mm = get_post_meta($night_guard_reorder_product_3mm, '4_nightguards_package', true);
        $key3mm = '4_nightguards_package_3mm';
    } else {
        $titleHeading = 'Tray';
    }
*/
$_3mmChecked  = "";
$_2mmChecked  = "checked";
if (strpos($producttitle, "3mm") !== false) {
    $_2mmChecked  = "";
    $_3mmChecked  = "checked";
}
    ob_start();
?>

    <div class="reorderSystemWrapper">
        <?php if (in_array($status, array('shipped', 'completed'))) { ?>
            <div class="reOrderWrapper">
                <button type="button" class="expander btn btn-outline-secondary btn-primary-orange">Re-order Trays <span class="caret"></span></button>

                <div class="mmWrapper mmContainerWrapper" style="display: none">
                    <div class="wrapper-repeater-mbt">
                        <div class="nightGuardsMmPorudctOption wrapper flex-wrapper">
                            <p class="guardsHeadingcol-12"><?php echo $titleHeading; ?></p>
                            <div class="buttonProducts wrapper flex-wrapper">
                                <?php if ($key3mm) : ?>


                                    <div class="form-group-radio-custom">
                                        <input autocomplete="false" class="nightguard_classs nightguard_classs22 option" type="radio" nightKey="<?php echo $key; ?>" nightKeyOther="<?php echo $key3mm; ?>" reOrderPrice="<?php echo $tray_price; ?>" <?php echo $_2mmChecked;?> name="ultra4night_<?php echo $item_id; ?>" value="<?php echo $night_guard_reorder_product; ?>" id="ultra4_night_guard2mm_<?php echo $item_id; ?>">
                                        <label for="ultra4_night_guard2mm_<?php echo $item_id; ?>">
                                            <div class="dot"></div>
                                            <span class="mmAmount">2mm</span>
                                        </label>
                                    </div>
                                    <div class="form-group-radio-custom">
                                        <input autocomplete="false" class="nightguard_classs option" type="radio" nightKey="<?php echo $key3mm; ?>" nightKeyOther="<?php echo $key; ?>" reOrderPrice="<?php echo $tray_price3mm; ?>" name="ultra4night_<?php echo $item_id; ?>" <?php echo $_3mmChecked;?> value="<?php echo $night_guard_reorder_product_3mm; ?>" id="ultra4_night_guard3mm_<?php echo $item_id; ?>">
                                        <label for="ultra4_night_guard3mm_<?php echo $item_id; ?>">
                                            <div class="dot"></div>
                                            <span class="mmAmount">3mm</span>
                                        </label>
                                    </div>
                                    <div class="priceToDisplay">
                                        <i role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                                        <span class="product-selection-price-text price_NightGuard" style="display: inline;"><?php echo $tray_price; ?></span>
                                    </div>

                                    <div class="re-orderButton full-width">
                                        <button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart nightGuard" href="?add-to-cart=<?php echo $night_guard_reorder_product; ?>" data-tray_number="<?php echo $tray_number ?>" data-quantity="1" data-product_id="<?php echo $night_guard_reorder_product; ?>" data-<?php echo $key; ?>="<?php echo $tray_price; ?>" data-action="woocommerce_add_order_item">Buy Now</button>
                                    </div>

                                <?php else : ?>
                                    <div class="form-group-radio-custom full-width-standard">
                                        <label class="option ">
                                            <span class="mmAmount">2mm Standard</span>
                                        </label>
                                    </div>
                                    <div class="priceToDisplay">
                                        <i role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                                        <span class="product-selection-price-text" style="display: inline;"><?php echo $tray_price; ?></span>
                                    </div>

                                    <div class="re-orderButton full-width">
                                        <button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=<?php echo $whitening_product_id; ?>" data-tray_number="<?php echo $tray_number ?>" data-quantity="1" data-product_id="<?php echo $whitening_product_id; ?>" data-action="woocommerce_add_order_item">Buy Again</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- <button class="btn btn-primary-blue btn-lg product_type_simple grayButton add_to_cart_button ajax_add_to_cart" href="?add-to-cart=130255" data-quantity="1" data-product_id="130255" data-action="woocommerce_add_order_item">Re-Order Kit</button> -->
                    <?php $_productObj = wc_get_product($product_id); ?>
                    <div class="wrapper-repeater-mbt composite-kit-wrapper">
                        <div class="nightGuardsMmPorudctOption wrapper flex-wrapper">
                            <p class="guardsHeadingcol-12">Complete Kit</p>
                            <div class="buttonProducts wrapper flex-wrapper">
                                <div class="priceToDisplay">
                                    <i role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                                    <span class="product-selection-price-text price_ultra4Night2mm" style="display: inline;"><?php echo $_productObj->get_regular_price(); ?></span>
                                </div>

                                <div class="re-orderButton full-width">
                                    <button class="btn btn-primary-blue  btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" data-product_id="<?php echo $product_id ?>" data-action="woocommerce_add_order_item">Buy Again</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <!-- reOrderWrapper -->
        <?php  } ?>

        <div class="reOrderWrapper">

            <button class="btn btn-outline-secondary border-gray  btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=<?php echo $product_id; ?>" data-quantity="1" data-product_id="<?php echo $product_id ?>" data-action="woocommerce_add_order_item" style="display:none;">Re-order System</button>
        </div>


    </div>
    <!-- reorderSystemWrapper -->

<?php


    $data = ob_get_clean();
    return $data;
}



function getReorderKitButtonPreviousVersion($product_id, $item_id)
{
    global $wpdb;
    $tray_number = $wpdb->get_var("SELECT  tray_number FROM  " . SB_ORDER_TABLE . " WHERE item_id = $item_id");
    $night_guard_reorder_product = 739363;
    $night_guard_reorder_product_3mm = 795483;
    $whitening_product_id = 793962;
    if (has_term('addon', 'product_cat', $product_id)) {
        return false;
    }
    $producttitle = get_the_title($product_id);
    $tray_price = get_post_meta($night_guard_reorder_product, 'any_whitening_system', true);
    $key = 'any_whitening_system';
    if ($producttitle == '1 ULTRA-DURABLE NIGHT GUARD') {
        $tray_price = get_post_meta($night_guard_reorder_product, '1_nightguards_package', true);
        $key = '1_nightguards_package';
    } else if ($producttitle == '2 ULTRA-DURABLE NIGHT GUARDS') {
        $tray_price = get_post_meta($night_guard_reorder_product, '2_nightguards_package', true);
        $key = '2_nightguards_package';
    } else if ($producttitle == '4 ULTRA-DURABLE NIGHT GUARDS') {
        $tray_price = get_post_meta($night_guard_reorder_product, '3_nightguards_package', true);
        $key = '4_nightguards_package';
    } elseif ($producttitle == '1 ULTRA-DURABLE NIGHT GUARD (3mm)') {
        $tray_price = get_post_meta($night_guard_reorder_product_3mm, '1_nightguards_package', true);
        $key = '1_nightguards_package_3mm';
    } else if ($producttitle == '2 ULTRA-DURABLE NIGHT GUARDS (3mm)') {
        $tray_price = get_post_meta($night_guard_reorder_product_3mm, '2_nightguards_package', true);
        $key = '2_nightguards_package_3mm';
    } else if ($producttitle == '4 ULTRA-DURABLE NIGHT GUARDS (3mm)') {
        $tray_price = get_post_meta($night_guard_reorder_product_3mm, '3_nightguards_package', true);
        $key = '4_nightguards_package_3mm';
    } else {
        return '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $whitening_product_id . '" data-quantity="1" data-tray_number="' . $tray_number . '" data-product_id="' . $whitening_product_id . '" data-action="woocommerce_add_order_item">RE-Order Tray</button>';
        //return '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $whitening_product_id . '" data-quantity="1" data-product_id="' . $whitening_product_id . ' data-action="woocommerce_add_order_item">RE-Order Tray</button>';
    }
    if ($key == '2_nightguards_package_3mm' || $key == '4_nightguards_package_3mm' || $key == '1_nightguards_package_3mm') {
        return '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart " href="?add-to-cart=' . $night_guard_reorder_product_3mm . '" data-tray_number="' . $tray_number . '" data-quantity="1" data-product_id="' . $night_guard_reorder_product_3mm . '" data-' . $key . '="' . $tray_price . '" data-action="woocommerce_add_order_item">Reorder Guard(s)</button>';
    }

    return '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart " href="?add-to-cart=' . $night_guard_reorder_product . '" data-tray_number="' . $tray_number . '" data-quantity="1" data-product_id="' . $night_guard_reorder_product . '" data-' . $key . '="' . $tray_price . '" data-action="woocommerce_add_order_item">Reorder Guard(s)</button>';
}

function getReorderKitButton_bkkk($product_id, $night_guard_reorder_product = '739363', $whitening_product_id = 793962)
{
    if (has_term('addon', 'product_cat', $product_id)) {
        return false;
    }
    $producttitle = get_the_title($product_id);
    $tray_price = get_post_meta($night_guard_reorder_product, 'any_whitening_system', true);
    $key = 'any_whitening_system';
    if ($producttitle == '1 ULTRA-DURABLE NIGHT GUARD') {
        $tray_price = get_post_meta($night_guard_reorder_product, '1_nightguards_package', true);
        $key = '1_nightguards_package';
    } else if ($producttitle == '2 ULTRA-DURABLE NIGHT GUARDS') {
        $tray_price = get_post_meta($night_guard_reorder_product, '2_nightguards_package', true);
        $key = '2_nightguards_package';
    } else if ($producttitle == '4 ULTRA-DURABLE NIGHT GUARDS') {
        $tray_price = get_post_meta($night_guard_reorder_product, '3_nightguards_package', true);
        $key = '4_nightguards_package';
    } else {
        return '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $whitening_product_id . '" data-quantity="1" data-product_id="' . $whitening_product_id . '" data-action="woocommerce_add_order_item">RE-Order Tray</button>';
        //return '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $whitening_product_id . '" data-quantity="1" data-product_id="' . $whitening_product_id . ' data-action="woocommerce_add_order_item">RE-Order Tray</button>';
    }
    return '<button class="btn btn-primary-blue btn-lg product_type_simple add_to_cart_button ajax_add_to_cart " href="?add-to-cart=' . $night_guard_reorder_product . '" data-quantity="1" data-product_id="' . $night_guard_reorder_product . '" data-' . $key . '="' . $tray_price . '" data-action="woocommerce_add_order_item">Reorder Guard(s)</button>';
}

add_action('wp_ajax_get_order_products_html_by_order_id_mbt', 'get_order_products_html_by_order_id_mbt');
function get_order_products_html_by_order_id_mbt($order_id = '')
{
    if ($order_id == '') {
        $order_id = $_POST['order_id'];
    }
    if ($order_id != '') {
        $html = '';
        $order = wc_get_order($order_id);
        $counter = 0;
        foreach ($order->get_items() as $item_id => $item) {
            if (wc_cp_get_composited_order_item_container($item, $order)) {
                continue;
            } else {
                $product_id = $item->get_product_id();
                $product = $item->get_product();
                $get_quantity = $item->get_quantity();
                $quantity_drop = '';
                if ($get_quantity > 1) {
                    $options = '';
                    for ($i = 1; $i <= $get_quantity; $i++) {
                        $options .= '<option value="' . $i . '">' . $i . '</option>';
                    }
                    $quantity_drop = ' <div class="quantityBoxPop">          
                    <select name="item[' . $counter . '][qty]">
                        ' . $options . '                                                                                                                                                      
                    </select>
                </div>';
                } else {
                    $quantity_drop = ' <div class="quantityBoxPop" style="display:none">          
                <select name="item[' . $counter . '][qty]">
                        <option value="1">1</option>                                                                                                                                                     
                    </select>
                </div>';
                }
                $checked = '';
                if ($counter == 0) {
                    $checked = 'checked';
                }

                $image = $product->get_image();
                $html .= '<div class="productItemsList customCheckboxmbt">
            <input type="checkbox" name="item[' . $counter . '][name]" ' . $checked . ' id="checkbox-' . $item_id . '" value="' . $item->get_name() . '">
            <label class="d-flex align-items-center" for="checkbox-' . $item_id . '">
                <div class="productItemRepeater">
                    <div class="sbr-orderItemLeft d-flex align-items-center">
                        <div class="orderImage ">
                            ' . wp_kses_post(apply_filters('woocommerce_order_item_thumbnail', $image, $item)) . '
                        <div class="orderTitle  d-flex align-items-center">
                            <h4 class="productNameAndQuantity mb-0 "> <a href="javascript: void(0)" style="cursor: initial">' . $item->get_name() . ' </a> × <span class="text-blue">' . $get_quantity . '</span></h4>
                           ' . $quantity_drop . '
                        </div>
                    </div>
                </div>
                </div>
            </label>
        </div>';
            }
            $counter++;
        }
        echo $html;
        die();
    }
}
