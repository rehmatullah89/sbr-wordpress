<?php
add_action('wp_enqueue_scripts', 'zendesk_scripts_mbt');

function zendesk_scripts_mbt() {
    wp_enqueue_script('zendesk-script', get_stylesheet_directory_uri() . '/inc/Zendesk/assets/js/custom.js', array('jquery'), '', true);
    wp_register_style('support-custom', get_stylesheet_directory_uri() . '/inc/Zendesk/assets/css/zendesk.css');
}

add_action("wp_ajax_zendesk_get_commnets_by_id", "mbt_ticket_comments_zendesk");
add_action("wp_ajax_nopriv_zendesk_get_commnets_by_id", "mbt_ticket_comments_zendesk");
add_action("wp_ajax_zendesk_add_ticket", "mbt_create_ticket_zendesk");
add_action("wp_ajax_nopriv_zendesk_add_ticket", "mbt_create_ticket_zendesk");

add_action("wp_ajax_zendesk_send_comment", "add_comment_zendesk");
add_action("wp_ajax_nopriv_zendesk_send_comment", "add_comment_zendesk");


add_action("wp_ajax_zendesk_update_ticket", "zendesk_update_ticket");
add_action("wp_ajax_nopriv_zendesk_update_ticket", "zendesk_update_ticket");

function mbt_create_user_zendesk() {
    // add_user

    $data = array("name" => "Muhammad Ejaz", "email" => "kamran@mindblazetech", "role" => "end-user");
    $data_string = '{"user": {"name": "Muhammad Ejaz", "email": "kamran@mindblazetech.com"}}';
//print_r($data_string);
    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users.json');
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

//$result = curl_exec($ch);
}

function get_all_users_zendesk() {
    //get_users
    $data = array("name" => "Muhammad Ejaz", "email" => "kamran@mindblazetech.com", "role" => "end-user");
    $data_string = '{"user": {"name": "Muhammad Ejaz", "email": "kamran@mindblazetech.com"}}';
//print_r($data_string);
    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users.json?role[]=admin&role[]=end-user');
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

//$result = curl_exec($ch);
//print_r($result);
}

function mbt_search_user_zendesk($email) {
    // search user
    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/search.json?query="' . $email . '"');
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
      );
     */


    $result = curl_exec($ch);
    $results = json_decode($result);
    $user_id = $results->users[0]->id;
    return $user_id;
}

function zendesk_get_user_identity($user_id) {
    // search user
    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/' . $user_id . '/identities.json');
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
      );
     */


    $result = curl_exec($ch);
    $results = json_decode($result);
    print_r($results);
    die();
    $user_id = $results->users[0]->id;
    return $user_id;
}

function zendesk_update_identity($user_id, $identity_id, $new_email) {
    // search user
    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/' . $user_id . '/identities/' . $identity_id . '.json');
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    $data_string = array(
        'identity' => array(
            "value" => $new_email,
    ));
    $data_string = json_encode($data_string);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );



    $result = curl_exec($ch);
    $results = json_decode($result);
    print_r($results);
    die();
}

function mbt_create_ticket_zendesk() {
    // Create Ticket
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        if ($subject == '') {
            echo 'sub_error';
            die();
        }

        $message = isset($_POST['message']) ? $_POST['message'] : '';
        if ($message == '') {
            echo 'mess_error';
            die();
        }

        // notification
        if (isset($_POST['ticket_type']) && $_POST['ticket_type'] == '_dispute') {

            $sender_id = isset($_POST['sender']) ? $_POST['sender'] : '';
            $receiver_id = isset($_POST['reciever']) ? $_POST['reciever'] : '';
            $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
            $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';

            //
            $update_order = array(
                'disputed' => true,
                'sender' => $sender_id,
            );
            update_post_meta($order_id, 'order_disputed', $update_order);
            //

            if ($user_type == '_customer') {
                $notification = array();
                $notification['sender_id'] = $sender_id;
                $notification['receiver_id'] = $receiver_id;
                $notification['Order_ID'] = $order_id;
                $notification['type'] = 'wc-dispute-from-client';
                exo_add_alert_notification($notification);
            }
            if ($user_type == '_author') {
                $notification = array();
                $notification['sender_id'] = $sender_id;
                $notification['receiver_id'] = $receiver_id;
                $notification['Order_ID'] = $order_id;
                $notification['type'] = 'wc-dispute-from-expert';
                exo_add_alert_notification($notification);
            }
        }
        //

        $username = $current_user->user_login;
        $email = $current_user->user_email;

        $attachment = "";

        $assignee_id = 114229119392;
        $assignee_email = "sajidoon@mindblazetech.com";
        $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets.json');
        $arr = array();
        $arr['ticket'] = array(
            "subject" => $subject,
            "requester" => array(
                "name" => $username,
                "email" => $email,
            ),
            "comment" => array(
                "body" => $message,
                "uploads" => [$attachment],
            ),
            "assignee_id" => $assignee_id,
            "assignee_email" => $assignee_email,
            "group_id" => 114094236951,
        );
        $data_string = json_encode($arr);


        //$data_string = '{"ticket": {"subject": "' . $subject . '", "requester":{"name":"' . $username . '","email":"' . $email . '"},"comment": { "body": "' . $message . '", "uploads":  ["' . $attachment . '"] },"assignee_id":"' . $assignee_id . '"}}';
        // $data = json_decode($data_string);


        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        $ticket_created = json_decode($result);




        if ($ticket_created->ticket->id != '') {
            echo 'success';
        } else if ($ticket_created->error != '') {
            echo 'zendesk error';
        }
    } else {
        echo 'please login to add the ticket';
    }


    die();
}

function mbt_create_ticket_zendesk_old() {
    // Create Ticket
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        if ($subject == '') {
            echo 'sub_error';
            die();
        }
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        if ($message == '') {
            echo 'mess_error';
            die();
        }
        $username = $current_user->user_login;
        $email = $current_user->user_email;

        $attachment = "";

        $assignee_id = 114229119392;
        $assignee_email = "sajidoon@mindblazetech.com";


        //$assignee_id = 114209095611;
        //$assignee_email="linton@' . SB_ZENDESK_HOST . 'living.com";

        $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets.json');
        $arr = array();
        $arr['ticket'] = array(
            "subject" => $subject,
            "requester" => array(
                "name" => $username,
                "email" => $email,
            ),
            "comment" => array(
                "body" => $message,
                "uploads" => [$attachment],
            ),
            "assignee_id" => $assignee_id,
            "assignee_email" => $assignee_email,
            "group_id" => 114094236951,
        );
        $data_string = json_encode($arr);


        //$data_string = '{"ticket": {"subject": "' . $subject . '", "requester":{"name":"' . $username . '","email":"' . $email . '"},"comment": { "body": "' . $message . '", "uploads":  ["' . $attachment . '"] },"assignee_id":"' . $assignee_id . '"}}';
        // $data = json_decode($data_string);


        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        $ticket_created = json_decode($result);


        if ($ticket_created->ticket->id != '') {
            echo '<h5 style="color:green">Message Sent <span style="font-family: wingdings; font-size: 150%;">&#252;</span></h5>';
        }
    } else {
        echo 'please login to add the ticket';
    }
    die();
}

function get_tickets_zendesk($user_id) {
    // get tickets
    $current_user_id = get_current_user_id();
    $user_info = get_userdata($current_user_id);
    $user_name = $user_info->first_name;
    $user_name .= ' ' . $user_info->first_name;
    $avatar_photo = get_user_meta($current_user_id, 'avatar', true);
    if ($avatar_photo == '') {
        $avatar_photo = get_stylesheet_directory_uri() . '/home-assets/images/logos.png';
    }
    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/' . $user_id . '/tickets/requested.json?query=sort_by=created_at&sort_order=desc');

    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


    $result = curl_exec($ch);

    $results = json_decode($result);

    /*
      echo "<pre>";
      print_r($results);
      echo "</pre>";
     */
    $html_solved = '';
    $html_open = '';
    foreach ($results->tickets as $res) {
        /* if ($res->status == 'pending') {
          $color = "red";
          }
          if ($res->status == 'open') {
          $color = "blue";
          }
         * */
        $ticket_id = $res->id;
        //$ticket_comments = mbt_ticket_comments_zendesk($ticket_id, $user_id);
        $ticket_comments = '';
        $ticket_date = $res->created_at;
        $ticket_date = explode("T", $ticket_date);
        $ticket_date = $ticket_date[0];
        $ticket_date = date("m-d-Y", strtotime($ticket_date));

        if ($res->status == 'solved') {
            $color = "green";
            $html_solved .= '<li class="clearfix" id="' . $ticket_id . '">
											<div class="ticket-box">
												<div class="technial-left-box">
													<h4>Technical</h4>
													<span><i class="fa fa-life-buoy" aria-hidden="true"></i></span>
												</div>
												<div class="body-cnt-box">
													<h5 class="ticket-subject"><span>Ticket #' . $res->id . ':</span> ' . $res->subject . '. </h5>
													<span class="date-show">' . $ticket_date . '</span>
												</div>
												<div class="answerd-righpanal">
                                                                                                <form action="' . home_url() . '/ticket-detail" method="GET">
                                                                                                    <input type="hidden" name="ticket_id" value="' . $res->id . '">
                                                                                                     <input type="hidden" name="ticket_title" value="' . $res->subject . '">
													<!-- <a href="javascript:;" class="ans-btn" data-ticketid="' . $ticket_id . '" data-userid="' . $user_id . '">View Detail</a> <span class="seprator-line"> | </span> -->
													<!-- <a href="javascript:;" class="view-detail-btn" data-ticketid="' . $ticket_id . '" data-userid="' . $user_id . '">View Detail</a> -->
<input class="view-detail" type="submit" value="view detail" name="submit">
</form>
</div>
											</div>

												<!-- ticket-box -->
                                                                                          <div class="ticket_wrap_container" style="display:none">
											<div class="appenddata"></div>
                                                                                        </div>
<!-- replay-box -->
										</li>';
        }
        if ($res->status == 'pending' || $res->status == 'open' || $res->status == 'new') {


            $html_open .= '<li class="clearfix" id="' . $ticket_id . '">
											<div class="ticket-box" >
												<div class="technial-left-box">
													<h4>Technical</h4>
													<span><i class="fa fa-life-buoy" aria-hidden="true"></i></span>
												</div>
												<div class="body-cnt-box">
													<h5 class="ticket-subject"><span>Ticket #' . $res->id . ':</span> ' . $res->subject . ' </h5>
													<span class="date-show">' . $ticket_date . '</span>
												</div>
												<div class="answerd-righpanal">
													<!--  <a href="javascript:;" class="ans-btn" data-ticketid="' . $ticket_id . '" data-userid="' . $user_id . '">View Detail</a> <span class="seprator-line"> | </span> -->
													 <form action="' . home_url() . '/ticket-detail" method="GET">
                                                                                                    <input type="hidden" name="ticket_id" value="' . $res->id . '">
                                                                                                     <input type="hidden" name="ticket_title" value="' . $res->subject . '">
													<!-- <a href="javascript:;" class="ans-btn" data-ticketid="' . $ticket_id . '" data-userid="' . $user_id . '">View Detail</a> <span class="seprator-line"> | </span> -->
													<!-- <a href="javascript:;" class="view-detail-btn" data-ticketid="' . $ticket_id . '" data-userid="' . $user_id . '">View Detail</a> -->
<input type="submit" class="view-detail" value="view detail" name="submit">
</form>
												</div>
											</div>
												<!-- ticket-box -->
                                                                                               <div class="ticket_wrap_container" style="display:none">
												<div class="ticket-box view-detail-panel">
														<div class="technial-left-box avator-imag">
																<span class="avadar-icon">
																		<img src="' . $avatar_photo . '" style="height:auto;" alt="S6" class="">
																</span>
																<span class="support-admin">' . $user_name . '</span>
														</div>
														<div class="body-cnt-box">
															<p class="descption-shrt-st">
																' . $res->description . '
															</p>
														</div>
														<div class="answerd-righpanal replay-btn-top">
																<a href="javascript:;"> Replay</a>
														</div>
													</div>

                                                                                             <div class="appenddata"></div>
											<div class="replay-box clearfix">
                                                                                            <form class="comment-zendesk" method="POST" id="commnet-form-' . $res->id . '" action="">
												<textarea name="comment-rep" placeholder="Type Your Answer" id="comment-rep"></textarea>
												<input type="hidden" name="action" value="zendesk_send_comment">
                                                                                                <input type="hidden" name="ticket_id" value="' . $res->id . '">
                                                                                                <input type="submit" value="Send" />
                                                                                                <div class="response-div"></div>

                                                                                             </form>
                                                                                             <button data-ticketid="' . $res->id . '" class="close_ticket btn button">Close Ticket</button>

											</div>
                                                                                        <div>
											<!-- replay-box -->
										</li>';
        }

        // echo '<strong>' . $res->subject . '<span style="color:' . $color . '"> ' . $res->status . '</strong></h2>';
        // echo '<p>' . $res->description . '</p>';
        $ticket_id = $res->id;
        //mbt_ticket_comments_zendesk($ticket_id, $user_id);
        if ($res->status == 'solved') {
            //echo $html_solved;
        } else {
            //echo $html_open;
        }
    }
    ?>
    <div id="open-tickets" class="tab-pane fade in active">

        <ul class="ticketing-listing">

    <?php
    echo $html_open;
    ?>
        </ul>



    </div>
    <div id="closed-tickets" class="tab-pane fade">

        <ul class="ticketing-listing">

    <?php
    echo $html_solved;
    ?>

        </ul>

    </div>
    <?php
}

function mbt_ticket_comments_zendesk($ticket_id, $user_id) {

    $current_user_id = get_current_user_id();
    $user_info = get_userdata($current_user_id);
    $user_name = $user_info->first_name;
    $user_name .= ' ' . $user_info->last_name;

    //$ticket_id = $_POST['ticket_id'];
    //$user_id = $_POST['user_id'];

    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '/comments.json');
    $data_string = '{"ticket": {"subject": "My printer is on fire 2!", "requester":{"name":"Muhammad Ejaz","email":"ejaz@mindblazeteh.com"},"comment": { "body": "The smoke is very colorful." }}}';
    $data = json_decode($data_string);
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
      );
     * */

    $result = curl_exec($ch);
    $results = json_decode($result);
    /*
      echo "<pre>";
      print_r($results);
      echo "</pre>";
     */
    $counter = 0;
    $chat_user = '';
    $html = '';
    if (count($results->comments) > 1) {

        foreach ($results->comments as $comment) {
            if ($counter != 0 && $comment->public == 1) {
                $date = $comment->created_at;
                $date = explode("T", $date);
                $date = $date[0];
                $date = date("m-d-Y", strtotime($date));
                //print_r($comment);
                $comment_author = $comment->author_id;
                $html .= '<li>';
                if ($comment_author != $user_id) {
                    $chat_user = '<span class="support-admin">Support</span>';
                    $style = 'background:#f4f4f4';
                    $avatar_photo = get_stylesheet_directory_uri() . '/home-assets/images/logos.png';
                } else {
                    $chat_user = '<span class="support-admin">' . $user_name . '</span>';
                    $style = '';
                    $avatar_photo = get_user_meta($current_user_id, 'avatar', true);
                    if ($avatar_photo == '') {
                        $avatar_photo = get_stylesheet_directory_uri() . '/home-assets/images/logos.png';
                    }
                }
                $show_date = '<span class="date-show">' . $date . '</span>';


                $comment_desc = $comment->plain_body;
                $html .= '<div class="ticket-box view-detail-panel" style="display:block; ' . $style . '">
														<div class="technial-left-box avator-imag">
																<span class="avadar-icon">
																		<img src="' . $avatar_photo . '" style="auto" alt="S6" class="">
																</span>
																<span class="support-admin">' . $chat_user . '</span>
														</div>
														<div class="body-cnt-box">
															<p class="descption-shrt-st">
																' . $comment_desc . '
															</p>
                                                                                                                         ' . $show_date . '
														</div>

														<div class="answerd-righpanal replay-btn-top">
																<a href="javascript:;"> Replay</a>
														</div>
													</div>';
                $html .= '</li>';
            }
            $counter++;
        }

        echo $html;
    } else {
        echo '<h4 style="padding-top: 15px;"> No comments yet </h4>';
    }
}

function add_comment_zendesk() {
//$ticket_id, $comment, $author_id, $token;
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();

        $message = isset($_POST['comment-rep']) ? $_POST['comment-rep'] : '';

        //$message=htmlentities($message, ENT_QUOTES, "UTF-8");


        if ($message == '') {
            echo 'mess_error';
            die();
        }
        $username = $current_user->user_login;
        $email = $current_user->user_email;

        $ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : '';
        if ($ticket_id == '') {
            echo 'unable to add comment';
            die();
        }
        $token = '';





        $author_id = mbt_search_user_zendesk($email);
        $arr = array();
        $arr['ticket'] = array(
            "status" => 'open',
            "comment" => array(
                "body" => $message,
                "uploads" => [$token],
                "author_id" => $author_id,
            )
        );
        $data_string = json_encode($arr);
//print_r($data_string);
//echo "<br />";
        $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '.json');
        //$data_string = '{"ticket": {"comment": { "body": "' . $message . '", "uploads":  ["' . $token . '"],"author_id": ' . $author_id . ' }}}';
        //print_r($data_string);
        //$data = json_decode($data_string);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
                //'Content-Length: ' . strlen($data_string)
                )
        );


        $result = curl_exec($ch);
        $results = json_decode($result);

        if ($results->ticket->id != '') {
            echo '<h5 style="color:green">Message Sent <span style="font-family: wingdings; font-size: 150%;">&#252;</span></h5>';
        }
    } else {
        echo "please login to add comment";
    }
    die();
}

function zendesk_attachment_token($uploadedfile) {


    if (!function_exists('wp_handle_upload')) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }




    $upload_overrides = array('test_form' => false);

    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        echo "File is valid, and was successfully uploaded.\n";
        $filePath = $movefile['file'];
        $fileName = basename($filePath);
        $file = fopen($filePath, "r");
        $size = filesize($filePath);
        $data_string = '{"user": {"name": "Muhammad Ejaz", "email": "kamran@mindblazetech.com"}}';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_URL, 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/uploads.json?filename=' . $fileName . '');
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/binary'));
        curl_setopt($ch, CURLOPT_POST, true);
        $file = fopen($filePath, 'r');
        $size = filesize($filePath);
        $fildata = fread($file, $size);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fildata);
        curl_setopt($ch, CURLOPT_INFILE, $file);
        curl_setopt($ch, CURLOPT_INFILESIZE, $size);
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($output);
        return $token = $decoded->upload->token;
    } else {
        /**
         * Error generated by _wp_handle_upload()
         * @see _wp_handle_upload() in wp-admin/includes/file.php
         */
        echo $movefile['error'];
    }
}

function zendesk_update_ticket() {
    if (is_user_logged_in()) {
        $ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : '';
        $message = isset($_POST['comment']) ? $_POST['comment'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        if ($ticket_id == '') {
            echo 'Ticket cannot be updated';
            die();
        }
        if ($status == '') {
            echo 'Ticket cannot be updated';
            die();
        } else {
            if ($status == 1) {
                $status = 'solved';
            }
            if ($status == 2) {
                $status = 'open';
            }
        }

        $current_user = wp_get_current_user();
        $username = $current_user->user_login;
        $email = $current_user->user_email;
        $author_id = mbt_search_user_zendesk($email);

        $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '.json');
        $arr = array();

        $arr['ticket'] = array(
            "status" => $status,
            "comment" => array(
                "body" => $message,
                "author_id" => $author_id,
            )
        );
        $data_string = json_encode($arr);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
                //'Content-Length: ' . strlen($data_string)
                )
        );


        $result = curl_exec($ch);
        $results = json_decode($result);
        if ($results->ticket->id != '') {
            echo '<h5 style="color:green">Your Ticket has been updated</h5>';
        } else {
            echo '<h3 style="color:red">something wennt wrong</h3>';
        }
        die();
    }
}

function mbt_zendesk_get_ticket_by_id($ticket_id = '') {
    if ($ticket_id != '') {

        $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '.json');
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
                //'Content-Length: ' . strlen($data_string)
                )
        );
        $result = curl_exec($ch);
        $results = json_decode($result);

        $created = $results->ticket->created_at;
        $created = explode("T", $created);
        $created = $created[0];
        $created = date("m-d-Y", strtotime($created));

        $ticket_status = $results->ticket->status;
        $content_array = array();
        $current_user = wp_get_current_user();
        $username = $current_user->user_login;
        $comp_name = $current_user->first_name . ' ' . $current_user->last_name;
        if ($current_user->first_name == '' && $current_user->last_name == '') {
            $comp_name = $comp_name;
        }

        $avatar = get_user_meta($current_user->ID, 'avatar', true);
        if ($avatar == '') {
            $avatar = get_stylesheet_directory_uri() . '/home-assets/images/logos.png';
        }

        $content_array['content'] = '<li>
            <div class="ticket-box">
                <div class="technial-left-box">
                    <h4> ' . $ticket_status . '</h4>

                   <div class="avator-imag">
																<span class="avadar-icon">
																		<img src="' . $avatar . '" style="height:auto" alt="S6" class="">
																</span>
																<span class="support-admin"><span class="support-admin">' . $comp_name . '</span></span>
														</div>
                </div>

                <div class="body-cnt-box">
                   <h5 class="ticket-subject"><span style="float:left">Ticket #' . $results->ticket->id . ':</span> <div class="date-show">Posted On: ' . $created . '</div> <br /><div class="subject-title">' . $results->ticket->subject . ' </div></h5>
                    <p> ' . $results->ticket->description . ' </p>
                    
                </div>


            </div>
        </li>';
        $content_array['status'] = $results->ticket->status;
        return $content_array;
    }
}

function update_identity_zendesk($user_id, $update_email) {

    $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/' . $user_id . '/identities.json');
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
      );
     * */

    $result = curl_exec($ch);
    $results = json_decode($result);
    $identity_id = $results->identities[0]->id;
    $identity_id = (int) $identity_id;
    if ($identity_id != '') {
        $ch = curl_init('https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/' . $user_id . '/identities/' . $identity_id . '.json');
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        $arr['identity'] = array(
            "id" => $identity_id,
            "user_id" => $user_id,
            "verified" => true,
            "primary" => true,
            "type" => "email",
            "value" => $update_email,
        );
        $data_string = json_encode($arr);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );


        $result = curl_exec($ch);
        $results = json_decode($result);
        if ($results->identity->id != '') {
            return 'yes';
        } else {
            return 'no';
        }
    } else {
        return 'no';
    }
}
?>
