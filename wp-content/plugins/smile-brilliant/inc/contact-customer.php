<?php
/**
 * Create or update a Zendesk ticket when the order status changes.
 *
 * @param WC_Order $orderObj The WooCommerce order object.
 * @param string   $req      The specific request type ('cancel', 'refund', 'replace', or empty for invoice payment).
 *
 * @return bool True if the Zendesk ticket creation/update is successful, false otherwise.
 */
function create_zendesk_ticket_status_changed($orderObj, $req = '')
{

    global $wpdb;
    $order_id = $orderObj->get_id();
    $user_email = $orderObj->get_billing_email();
    $requester_id = sb_search_user_zendesk($user_email);
    if (empty($requester_id)) {
        $data = array(
            'name' => $orderObj->get_billing_first_name() . ' ' . $orderObj->get_billing_last_name(),
            'email' => $user_email,
            'phone' => $orderObj->get_billing_phone(),
        );
        $requester_id = sb_create_user_zendesk($data);
    }
    $order_number = get_post_meta($order_id, 'order_number', true);
    if ($order_number == '') {
        $order_number = $orderObj->get_order_number();
    }
    if ($req == 'cancel') {
        $message = '<h3>Order is cancelled by customer </h3></br>';
        $message .= '<b>Order Number :</b> ' . $order_number . ' </br>';
        $message .= '<b>Reason:</b> ' . $_POST['reason_cancellation'] . ' </br>';
        $message .= '<b>Message:</b> ' . $_POST['message'] . ' </br>';
        $message .= '<b>Customer:</b> ' . $orderObj->get_billing_first_name() . ' ' . $orderObj->get_billing_last_name() . ' </br>';
        $message .= '<b>Customer Email:</b> ' . $user_email . ' </br>';
        $subject = $order_number . ' CANCELLED BY CUSTOMER';
    } elseif ($req == 'refund') {
        $items = $_POST['item'];
        $item_html = '';
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $itm) {
                if (trim($itm['name']) != '' && $itm['qty'] > 0) {
                    $item_html .= $itm['name'] . ' <b> Quantity:</b>' . $itm['qty'] . '<br />';
                }
            }
        }

        $message = '<h3>Refund request from customer </h3></br>';
        $message .= '<b>Order Number:</b> ' . $order_number . ' </br>';
        $message .= '<b>Reason:</b> ' . $_POST['reason_refund'] . ' </br>';
        $message .= '<b>Products:</b> <br /> ' . $item_html . ' </br>';
        $message .= '<b>Message:</b> ' . $_POST['message'] . ' </br>';
        $subject = $order_number . ' REFUND REQUEST FROM CUSTOMER';
    } elseif ($req == 'replace') {
        $items = $_POST['item'];
        $item_html = '';
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $itm) {
                if (trim($itm['name']) != '' && $itm['qty'] > 0) {
                    $item_html .= $itm['name'] . ' <b> Quantity:</b>' . $itm['qty'] . '<br />';
                }
            }
        }

        $message = '<h3>Item Replace Request from customer </h3></br>';
        $message .= '<b>Order Number:</b> ' . $order_number . ' </br>';
        $message .= '<b>Reason:</b> ' . $_POST['reason_refund'] . ' </br>';
        $message .= '<b>Products:</b> <br />' . $item_html . ' </br>';
        $message .= '<b>Message:</b> ' . $_POST['message'] . ' </br>';
        $subject = $order_number . ' Replace Request from customer';
    } else {
        $message = '<h3>INVOICE PAYMENT RECEIVED </h3></br>';
        $message .= '<b>Order Number:</b> ' . $order_number . ' </br>';
        $message .= '<b>Customer:</b> ' . $orderObj->get_billing_first_name() . ' ' . $orderObj->get_billing_last_name() . ' </br>';
        $message .= '<b>Customer Email:</b> ' . $user_email . ' </br>';
        $message .= '<b>Order Total:</b> ' . $orderObj->get_formatted_order_total() . ' </br>';
        $message .= '<b>Shipping Method:</b>  ' . $orderObj->get_shipping_to_display() . ' </br>';
        $message .= '<b>Payment Method:</b> ' . $orderObj->get_payment_method_title() . ' </br>';
        $message .= '<b>Transaction ID:</b> ' . $orderObj->get_transaction_id() . ' </br>';
        $message .= '<b>Billing Address:</b> ' . $orderObj->get_formatted_billing_address() . ' </br>';
        $message .= '<b>Shipping Address:</b> ' . $orderObj->get_formatted_shipping_address() . ' </br>';
        $subject = $order_number . ' INVOICE PAYMENT RECEIVED';
    }

    $arr = array();
    $arr['ticket'] = array(
        "subject" => $subject,
        "comment" => array(
            "html_body" => $message,
            "body" => $message,
        ),
        "requester_id" => $requester_id,
        "submitter_id" => SB_ZENDESK_AGENT,
        "assignee_id" => SB_ZENDESK_AGENT,
        //  "status" => "solved"
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
    curl_close($ch);
    $ticket_created = json_decode($result, true);
    if (isset($ticket_created['ticket']['id']) && $ticket_created['ticket']['id'] != '') {
        $wpdb->insert(SB_ZENDESK_TABLE, array(
            "ticket_id" => $ticket_created['ticket']['id'],
            "order_id" => $order_id,
            // "status" => "solved",
        ));
    }
    return true;
}

add_action('wp_ajax_send_ticket_message', 'send_ticket_message_callback');
add_action('wp_ajax_mbt_close_ticket', 'mbt_close_ticket');
/**
 * Close a Zendesk ticket.
 *
 * @param string $ticket_id The ID of the Zendesk ticket to be closed.
 * @param bool   $return    Whether to return the result as an array or echo it.
 *
 * @return array|void An array containing the status and message if $return is true, otherwise, echoes the JSON response.
 */
function mbt_close_ticket($ticket_id = '', $return = false)
{
    $res = array();
    if ($ticket_id == '') {
        $ticket_id = isset($_GET['ticket_id']) ? $_GET['ticket_id'] : "";
    }
    if ($ticket_id == '') {
        $res['status'] = 'error';
        $res['message'] = 'please provide ticket id';
    }
    $arr = array();
    $arr['ticket'] = array(
        "status" => 'solved'
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
    curl_close($ch);
    $results = json_decode($result);

    if ($results->ticket->id != '') {
        $res['status'] = 'success';
        $res['message'] = 'Ticket updated';
    } else {
        $res['status'] = 'error';
        $res['message'] = 'Some thing went wrong';
    }
    if ($return) {
        return $res;
    } else {
        echo json_encode($res);
        die();
    }
}

add_action('wp_ajax_uploadTicketAttachment', 'uploadTicketAttachment_callback');
/**
 * AJAX callback function for uploading ticket attachments.
 */
function uploadTicketAttachment_callback()
{
    // Upload file 
    $uploadStatus = 0;
    $tokenAttachment = 0;
    $message = '';

    $fileType = '';
    $responseHtml = '';
    $valid_types = array("image/jpg", "image/jpeg", "image/bmp", "image/gif", "image/png", "application/pdf", "application/msword", "application/vnd.ms-office");
    if (isset($_REQUEST['multiple'])) {

        $count = count($_FILES["attachment"]['name']);
        for ($i = 0; $i < ($count); $i++) {
            $time = mt_rand();
            $contentType = $_FILES['attachment']['type'][$i];
            $fileName = $_FILES['attachment']['name'][$i];
            // echo '<pre>';
            // print_r($contentType);
            // echo '</pre>';
            if (in_array($_FILES['attachment']['type'][$i], $valid_types)) {


                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                if ($_FILES['attachment']['size'][$i] < 3145728) {
                    // Upload file to the server
                    //  $imagedata = file_get_contents($fileName);
                    $imagedata = file_get_contents($_FILES['attachment']['tmp_name'][$i]);
                    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/uploads/?filename=' . $fileName;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $imagedata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: ' . $contentType . '',
                        )
                    );
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $results = json_decode($result, true);
                    // echo '<pre>';
                    // print_r($results);
                    // echo '</pre>';
                    if (isset($results['upload']['token'])) {
                        $uploadStatus = 1;
                        $message = $fileName . ' - attachment uploaded.';
                        $tokenAttachment = $results['upload']['token'];

                        $data = base64_encode($imagedata);
                        switch ($fileType) {
                            case 'pdf':
                                $imageTag = '<img  class="imageThumbailType" src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/pdf.svg"  />';
                                break;
                            case 'doc':
                                $imageTag = '<img  class="imageThumbailType" src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/doc.svg"  />';
                                break;
                            case 'docx':
                                $imageTag = '<img  class="imageThumbailType" src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/doc.svg"  />';
                                break;
                            default:
                                $imageTag = '<img  class="imageThumbailType"  src="data:image/jpeg;base64,' . $data . '" alt="" />';
                        }
                        $responseHtml .= '<div id="uploadedFileInfo_' . $time . '" class="succuss-msg uploaded-file__info uploaded-file__info--active success-upload">';
                        $responseHtml .= '<span class="imageUploaderPreview">' . $imageTag . '</span>';
                        $responseHtml .= '<span class="uploaded-file__name">' . $message . '</span>';
                        $responseHtml .= '<input type="hidden" name="tokenAttachment[]" value="' . $tokenAttachment . '" />';
                        $responseHtml .= '<a href="javascript:;" class="removeUploadItem" onclick="removeUplodaedItem(' . $time . ')"><i class="fa fa-times" aria-hidden="true"></i></a>';
                        $responseHtml .= '</div>';
                    } else {
                        $uploadStatus = 0;
                        $message = $fileName . ' - File not uploaded on zendesk. Please contact with Dev team with attachment.';
                        $responseHtml .= '<div id="uploadedFileInfo_' . $time . '" class="error-msg uploaded-file__info uploaded-file__info--active success-upload">';
                        $responseHtml .= '<span class="uploaded-file__name">' . $message . '</span>';
                        $responseHtml .= '<a href="javascript:;" class="removeUploadItem" onclick="removeUplodaedItem(' . $time . ')">X</a>';
                        $responseHtml .= '</div>';
                    }
                } else {
                    $uploadStatus = 0;
                    $message = $fileName . ' - File size greater then 3MB. Please upload less then 3 MB.';
                    $responseHtml .= '<div id="uploadedFileInfo_' . $time . '" class="error-msg uploaded-file__info uploaded-file__info--active success-upload">';
                    $responseHtml .= '<span class="uploaded-file__name">' . $message . '</span>';
                    $responseHtml .= '<a href="javascript:;" class="removeUploadItem" onclick="removeUplodaedItem(' . $time . ')">X</a>';
                    $responseHtml .= '</div>';
                }
            }
        }
        echo $responseHtml;
        die;
    } else {
        $time = time();
        if (!empty($_FILES["attachment"]["name"])) {
            // File path config 
            $fileName = sanitize_file_name($_FILES["attachment"]["name"]);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            // Allow certain file formats 
            $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
            $imageTag = '';
            if (in_array($fileType, $allowTypes)) {

                if ($_FILES['attachment']['size'] < 3145728) {
                    // Upload file to the server
                    $imagedata = file_get_contents($_FILES['attachment']['tmp_name']);
                    $contentType = $_FILES['attachment']['type'];
                    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/uploads/?filename=' . $fileName;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $imagedata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt(
                        $ch,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: ' . $contentType . '',
                        )
                    );
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $results = json_decode($result, true);
                    //                echo '<pre>';
                    //                print_r($results);
                    //                echo '</pre>';
                    if (isset($results['upload']['token'])) {
                        $uploadStatus = 1;
                        $message = $fileName . ' - attachment uploaded.';
                        $tokenAttachment = $results['upload']['token'];

                        $data = base64_encode($imagedata);
                        switch ($fileType) {
                            case 'pdf':
                                $imageTag = '<img  class="imageThumbailType" src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/pdf.svg"  />';
                                break;
                            case 'doc':
                                $imageTag = '<img  class="imageThumbailType" src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/doc.svg"  />';
                                break;
                            case 'docx':
                                $imageTag = '<img  class="imageThumbailType" src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/doc.svg"  />';
                                break;
                            default:
                                $imageTag = '<img  class="imageThumbailType"  src="data:image/jpeg;base64,' . $data . '" alt="" />';
                        }
                    } else {
                        $uploadStatus = 0;
                        $message = $fileName . ' - File not uploaded on zendesk. Please contact with Dev team with attachment.';
                    }
                } else {
                    $uploadStatus = 0;
                    $message = $fileName . ' - File size greater then 3MB. Please upload less then 3 MB.';
                }
            } else {
                $uploadStatus = 0;
                $message = $fileName . ' - Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
            }
        } else {
            $uploadStatus = 0;
            $message = 'No file found.';
        }
        if ($uploadStatus) {
            $responseHtml = '<div id="uploadedFileInfo_' . $time . '" class="succuss-msg uploaded-file__info uploaded-file__info--active success-upload">';
            $responseHtml .= '<span class="imageUploaderPreview">' . $imageTag . '</span>';
            $responseHtml .= '<span class="uploaded-file__name">' . $message . '</span>';
            $responseHtml .= '<input type="hidden" name="tokenAttachment[]" value="' . $tokenAttachment . '" />';
            $responseHtml .= '<a href="javascript:;" class="removeUploadItem" onclick="removeUplodaedItem(' . $time . ')"><i class="fa fa-times" aria-hidden="true"></i>
        </a>';
            $responseHtml .= '</div>';
        } else {

            $responseHtml = '<div id="uploadedFileInfo_' . $time . '" class="error-msg uploaded-file__info uploaded-file__info--active success-upload">';
            $responseHtml .= '<span class="uploaded-file__name">' . $message . '</span>';
            $responseHtml .= '<a href="javascript:;" class="removeUploadItem" onclick="removeUplodaedItem(' . $time . ')">X</a>';
            $responseHtml .= '</div>';
        }
        echo $responseHtml;
    }
    die;
}
/**
 * AJAX callback function for sending ticket messages.
 */
function send_ticket_message_callback()
{
    global $wpdb;
    $responseTicket = '';
    $responseData = array();
    if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] <> '') {

        $requester_id = $_REQUEST['zendesk_user_id'];
        $messagess = $_REQUEST['message'];
        $message = str_replace("&nbsp;", "", $messagess);
        $message = str_replace("\\", "", $message);
        $item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : 0;
        $order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : 0;
        $ticket_id = isset($_REQUEST['ticket_id']) ? $_REQUEST['ticket_id'] : 0;
        $ticket_status = isset($_REQUEST['ticket_status']) ? $_REQUEST['ticket_status'] : 'open';
        $medium = isset($_REQUEST['medium']) ? $_REQUEST['medium'] : 'email';
        //$medium = 'email';
        $attachments = isset($_REQUEST['tokenAttachment']) ? $_REQUEST['tokenAttachment'] : array();
        $subject_request = $_REQUEST['zendesk_request'];
        if ($message == '') {
            $responseData['status'] = 'error';
            $responseData['message'] = 'unable to add comment. Message Empty';
            echo json_encode($responseData);
            die();
        }
        if ($ticket_id) {

            $arr = array();
            $arr['ticket'] = array(
                "status" => $ticket_status,
                "subject" => $subject_request,
                "comment" => array(
                    "html_body" => force_balance_tags($message),
                    "assignee_id" => $requester_id,
                    "uploads" => $attachments,
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
            curl_close($ch);
            $results = json_decode($result, true);
            if (isset($results['ticket']['id']) && $results['ticket']['id'] > 0) {
                /*
                $ticketInfo = sb_ticket_comments_zendesk($results['ticket']['id']);
                if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
                    $responseData['status'] = 'success';
                } else {
                    $responseData['status'] = 'success';
                }
                $responseData['message'] = $ticketInfo['html'];
                */
                $responseData['status'] = 'success';
            } else {
                $responseData['status'] = 'error';
                $responseData['message'] = 'Unable to add comment.';
            }
            echo json_encode($responseData);
            die();
        } else {

            $subject = $_REQUEST['zendesk_request'];
            $arr = array();
            $arr['ticket'] = array(
                "subject" => $subject,
                "comment" => array(
                    "html_body" => force_balance_tags($message),
                    "uploads" => $attachments,
                ),
                "requester_id" => $requester_id,
                "submitter_id" => SB_ZENDESK_AGENT,
                "assignee_id" => $requester_id,
                "custom_fields" => array(
                    array(
                        "id" => 4417382819865,
                        "value" => $medium
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
            curl_close($ch);
            $ticket_created = json_decode($result, true);
            if (isset($ticket_created['ticket']['id']) && $ticket_created['ticket']['id'] != '') {
                if ($item_id > 0) {
                    $update = array(
                        'ticket_id' => $ticket_created['ticket']['id']
                    );
                    $condition = array(
                        'order_id' => $order_id,
                        'item_id' => $item_id,
                    );
                    $wpdb->update(SB_ORDER_TABLE, $update, $condition);
                } else {
                    $wpdb->insert(SB_ZENDESK_TABLE, array(
                        "ticket_id" => $ticket_created['ticket']['id'],
                        "order_id" => $order_id,
                    ));
                }
                /*
                $ticketInfo = sb_ticket_comments_zendesk($ticket_created['ticket']['id']);
                if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
                    $responseData['status'] = 'success';
                } else {
                    $responseData['status'] = 'success';
                }
                $responseData['message'] = $ticketInfo['html'];
                */
                $responseData['status'] = 'success';
            } else {
                $responseData['status'] = 'error';
                $responseData['message'] = 'Unable to add comment.';
            }
            echo json_encode($responseData);
            die();
        }
    } else {
        $responseData['status'] = 'error';
        $responseData['message'] = 'Unable to add comment. Order ID missing.';
        echo json_encode($responseData);
        die();
    }
}

/**
 * Get the mapping of SBR system items to their associated Zendesk tickets.
 *
 * @return array Associative array where keys are item IDs and values are corresponding Zendesk ticket IDs.
 */
function get_tickets_sbr_system_items()
{
    global $wpdb;
    echo $query_sbr = "SELECT  item_id ,  ticket_id FROM  " . SB_ORDER_TABLE . " WHERE ticket_id != 0";
    $query_response = $wpdb->get_results($query_sbr);
    $order_tickets = array();

    foreach ($query_response as $res) {
        $order_tickets[$res->item_id] = $res->ticket_id;
    }
    return $order_tickets;
}
/**
 * Get the mapping of SBR system orders to their associated Zendesk tickets.
 *
 * @return array Associative array where keys are order IDs and values are corresponding Zendesk ticket IDs.
 */
function get_tickets_sbr_system_order()
{
    global $wpdb;
    $query_sbr = "SELECT ticket_id,order_id FROM  " . SB_ZENDESK_TABLE;
    $query_response = $wpdb->get_results($query_sbr);
    $order_tickets = array();

    foreach ($query_response as $res) {
        $order_tickets[$res->order_id] = $res->ticket_id;
    }

    return $order_tickets;
}

add_action('wp_ajax_create_customer_popup', 'create_customer_popup_callback');
/**
 * Callback function for handling the create customer ticket popup
 */
function create_customer_popup_callback()
{
    echo ' <h1 class="customer_contact_area">Customer Contact Area</h1>';
    echo '<div class="status-res"></div>';
    $order_id = 0;
    if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] <> '') {

        global $wpdb;
        $order_id = $_REQUEST['order_id'];
        $item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : 0;
        $order = wc_get_order($order_id);
        $ticket_id = 0;
        $ticket_status = '';
        if ($item_id > 0) {
            $ticket = $wpdb->get_row("SELECT  ticket_id , ticket_status FROM  " . SB_ORDER_TABLE . " WHERE order_id = $order_id and item_id = $item_id", 'ARRAY_A');

            if (isset($ticket['ticket_id']) && $ticket['ticket_id'] > 0) {
                $ticket_id = $ticket['ticket_id'];
                $ticket_status = $ticket['status'];
            }
        } else {
            $ticket = $wpdb->get_row("SELECT ticket_id,status FROM  " . SB_ZENDESK_TABLE . " WHERE order_id = " . $_REQUEST['order_id'], 'ARRAY_A');
            if (isset($ticket['ticket_id']) && $ticket['ticket_id'] > 0) {
                $ticket_id = $ticket['ticket_id'];
                $ticket_status = $ticket['status'];
            }
        }

        $user_email = $order->get_billing_email();
        $zendesk_user_id = sb_search_user_zendesk($user_email);
        if ($zendesk_user_id) {
        } else {
            $data = array(
                'name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                'email' => $user_email,
                'phone' => $order->get_billing_phone(),
            );
            $zendesk_user_id = sb_create_user_zendesk($data);
        }


        $subjectTicketId = 'Customer Support';
        $source = 'email';
        $responseTicket = '';
        if ($order_id) {
            $order_number = get_post_meta($order_id, 'order_number', true);
            if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] > 0) {
                $subjectTicketId = $order_number . ' - ' . get_the_title($_REQUEST['product_id']);
            }
        }

        if ($ticket_id) {
            $ticketInfo = sb_ticket_comments_zendesk($ticket_id);
            if (isset($ticketInfo['error']) && $ticketInfo['error'] == false) {
                $responseTicket = $ticketInfo['html'];
                $ticket_status = $ticketInfo['status'];
                $subjectTicketId = $ticketInfo['subject'];
                $source = $ticketInfo['source'];
                if (isset($ticketInfo['error']) && $ticketInfo['error'] === true) {

                    echo '<div class="ticket-info-area">';
                    echo '<div class="mbt-ticket-id"><strong>Ticket ID: #' . $ticket_id . ' - </strong>';
                    $advnceUrl = '<a class="button-primary" target = _blank href="https://smilebrilliant.zendesk.com/agent/tickets/' . $ticket_id . '">Advance Mode </a>';
                    echo $responseTicket . ' Please Check in ' . $advnceUrl;
                    echo '</div>';
                    die;
                }
            }


            if (count($ticket) > 0 && $ticket_id != '' && $ticket_id != 0) {
                echo '<div class="ticket-info-area">';
                echo '<div class="mbt-ticket-id"><div class="mbt-combine-container"><strong>Ticket ID: #' . $ticket_id . '</strong><a class="button-primary" target = _blank href="https://smilebrilliant.zendesk.com/agent/tickets/' . $ticket_id . '">Advance Mode </a></div></div>';
                echo '<div class="mbt-ticket-status"><strong>Ticket Status: <span class="tickestatus ' . $ticket_status . '">' . ucfirst($ticket_status) . '</span></strong></div>';
                echo '</div>';
            }
?>

            <h5>
                <div class="customer-ticket-info">
                    <span class="user-name">User Name: <?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?> </span>
                    <span class="user-email">Email: <?php echo $user_email; ?> </span>
                    <span class="user-call">Call: <?php echo $order->get_billing_phone(); ?></span>
                </div>
            </h5>
        <?php
        }
        ?>



        <div id="chat_container">

            <!--   <hr class="seprator-hr"> -->
            <form id="customer_zendesk_chat" enctype="multipart/form-data">

                <div class="flex-cont">
                    <?php
                    $close_ticket_url = add_query_arg(
                        array(
                            'action' => 'mbt_close_ticket',
                            'ticket_id' => $ticket_id,
                        ),
                        admin_url('admin-ajax.php')
                    );
                    ?>
                    <label class="mbt-label-zendesk">
                        <h3>Ticket title</h3>
                        <input type="text" name="zendesk_request" id="" value="<?php echo $subjectTicketId; ?>" placeholder="<?php echo $subjectTicketId; ?>" />
                    </label>

                    </br>
                    <div class="message-container-sbr">

                        <div id="response_chat">
                            <?php echo force_balance_tags($responseTicket); ?>
                        </div>
                    </div>




                    <div class="message-box-container">
                        <h3 class="typeMEssageText">Type Message</h3>
                        <input type="hidden" id="zendesk_ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>" />
                        <input type="hidden" id="ticket_type" name="item_id" value="<?php echo $item_id; ?>" />
                        <input type="hidden" name="action" value="send_ticket_message" />
                        <input type="hidden" id="order_id_zendesk" name="order_id" value="<?php echo $order_id; ?>" />
                        <input type="hidden" name="zendesk_user_id" value="<?php echo $zendesk_user_id; ?>" />
                        <?php
                        $description = '';
                        $description_field = 'message_input_' . rand();
                        //Provide the settings arguments for this specific editor in an array
                        $description_args = array('media_buttons' => false, 'textarea_rows' => 30, 'textarea_name' => 'message', 'wpautop' => false, 'quicktags' => false);
                        wp_editor($description, $description_field, $description_args);
                        ?>


                        <div class="parent-div-field">
                            <?php
                            $macro_options = '<option value="0">---</option>';
                            $macros_response = sb_zendesk_macros_list();
                            foreach ($macros_response as $key_id => $macro_title) {
                                $macro_options .= '<option value="' . $key_id . '">' . $macro_title . '</option>';
                            }
                            ?>
                            <div class="field-select-option">
                                <h3><label for="zendesk_macro">Zendesk Macros </label></h3>
                                <select id="zendesk_macro" name="zendesk_macro" onchange="sb_zendesk_macro(this.value);" style="margin-top: 5px; margin-bottom: 5px;">
                                    <?php echo $macro_options; ?>
                                </select>

                            </div>
                            <?php if ($ticket_id) : ?>
                                <div class="field-select-option">
                                    <h3><label for="ticket_status">Ticket Status </label></h3>
                                    <select id="ticket_status" name="ticket_status" style="margin-top: 5px; margin-bottom: 5px;">
                                        <option value="open" <? if ($ticket_status == 'open') echo 'selected=""'; ?>>Open</option>
                                        <option value="pending" <? if ($ticket_status == 'pending') echo 'selected=""'; ?>>Pending</option>
                                        <option value="solved" <? if ($ticket_status == 'solved') echo 'selected=""'; ?>>Solved</option>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <div class="field-select-option">
                                <h3><label for="medium">Medium</label></h3>
                                <select id="medium" name="medium" style="margin-top: 5px; margin-bottom: 5px;">
                                    <option value="email">Email</option>
                                    <option value="text">SMS</option>
                                </select>
                            </div>

                            <div id="fileUploadZendesk">


                                <!-- Upload Area -->
                                <div id="uploadArea" class="upload-area">
                                    <!-- Header -->
                                    <div class="upload-area__header">
                                        <h1 class="upload-area__title">Upload your files</h1>
                                        <p class="upload-area__paragraph">
                                            Only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.
                                            <strong class="upload-area__tooltip" style="display: none;">
                                                Like
                                                <span class="upload-area__tooltip-data">jpeg, .png, .gif</span>
                                            </strong>
                                        </p>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Drop Zoon -->
                                    <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                                        <input type="file" name="uploadTicketAttachment[]" id="attachments_zendesk" onchange="uploadTicketAttachment()" />
                                        <span class="drop-zoon__icon">

                                            <span class="bx bxs-file-image dashicons dashicons-images-alt2"></span>
                                        </span>
                                        <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                                        <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                                        <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">

                                    </div>
                                    <!-- End Drop Zoon -->

                                    <!-- File Details -->
                                    <div id="fileDetails" class="upload-area__file-details file-details">
                                        <!--                            <h3 class="file-details__title">Uploaded File</h3>-->


                                        <div class="progress" style="display: none">
                                            <div class="progress-bar" style="width: 0%;"></div>
                                        </div>
                                        <div id="attachmentContainer">

                                        </div>

                                    </div>
                                </div>
                                <!-- End File Details -->
                            </div>
                            <!-- End Upload Area -->

                        </div>
                    </div>


                </div>

                <button type="button" id="btn_customer_zendesk_chat" class="btn btn-danger button message-send">Send Message</button>
                <?php
                $stylet = 'display:none';

                if ($ticket_id == 0) {
                    $stylet = 'display:none';
                } else if ($ticket_status != 'solved') {
                    $stylet = 'display:inline-block';
                }
                ?>
                <a class="close_ticket" style="<?php echo $stylet; ?>" href="javascript:void(0);" data-close-ticket="<?php echo $close_ticket_url; ?>">Mark as solved</a>

            </form>
        </div>


        <script>
            function removeUplodaedItem(item_id) {
                jQuery('#chat_container').find('#uploadedFileInfo_' + item_id).remove();
            }

            function uploadTicketAttachment() {
                if (document.getElementById("attachments_zendesk").files.length > 0) {

                    jQuery('#chat_container').find('.progress-bar').css('width', 0 + "%");
                    jQuery('#chat_container').block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                    var property = document.getElementById('attachments_zendesk').files[0];
                    var image_name = property.name;
                    var fileType = property.type;
                    var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
                    if (!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))) {
                        alert('Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.');
                        jQuery("#attachmentContainer").val('');
                        jQuery('#chat_container').find('.progress').hide();
                        jQuery('#chat_container').unblock();
                    } else {
                        jQuery('#chat_container').find('.progress').show();
                        var form_data = new FormData();
                        form_data.append("action", "uploadTicketAttachment");
                        form_data.append("file_name", image_name);
                        form_data.append("attachment", property);
                        jQuery.ajax({
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                // Upload progress
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = evt.loaded / evt.total;
                                        //Do something with upload progress
                                        console.log(percentComplete);
                                        jQuery('#chat_container').find('.progress-bar').css('width', 100 * percentComplete + "%");
                                    }
                                }, false);
                                // Download progress
                                xhr.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = evt.loaded / evt.total;
                                        // Do something with download progress
                                        console.log(percentComplete);
                                        jQuery('#chat_container').find('.progress-bar').css('width', 100 * percentComplete + "%");
                                    }
                                }, false);
                                return xhr;
                            },
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            data: form_data,
                            async: true,
                            method: 'POST',
                            success: function(data) {
                                jQuery('#chat_container').find('.progress').hide();
                                jQuery('#attachmentContainer').append(data);
                                jQuery('#chat_container').unblock();
                                jQuery("#attachmentContainer").val('');
                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });
                    }
                }
            }

            function sb_zendesk_macro(macro_id) {
                jQuery('#chat_container').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        "macro_id": macro_id,
                        "action": 'sb_zendesk_macros_content'
                    },
                    async: true,
                    method: 'POST',
                    success: function(response) {
                        jQuery('#chat_container').unblock();
                        tinyMCE.get('<?php echo $description_field; ?>').setContent(response);
                    }
                });
            }

            jQuery("body").find('#smile_brillaint_order_modal').addClass('addOn_mbt customer-area-chat');



            function backend_row_refreshZD() {
                setTimeout(function() {
                    <?php if (isset($_REQUEST['screen']) && in_array($_REQUEST['screen'], array('pending-lab', 'waiting-impression'))) {
                    ?>
                        reloadOrderEntry_ByStatus(<?php echo $order_id; ?>, '<?php echo $_REQUEST['screen']; ?>');
                    <?php
                    } else {
                    ?>
                        reloadOrderEntry(<?php echo $order_id; ?>);
                    <?php
                    }
                    ?>
                }, 3000);
            }
        </script>

        <?php
          \_WP_Editors::enqueue_scripts();
          //print_footer_scripts();
          \_WP_Editors::editor_js();
          /*
        //var_dump(strpos(wp_get_referer(), 'wp-admin/post.php?post='));
        //echo wp_get_referer();
        if (strpos(wp_get_referer(), 'wp-admin/post.php?post=') === false) {
            \_WP_Editors::enqueue_scripts();
            //print_footer_scripts();
            \_WP_Editors::editor_js();
        } else {
        ?>
            <script>
                tinyMCE.execCommand('mceAddEditor', false, '<?php echo $description_field; ?>');
                quicktags({
                    id: '<?php echo $description_field; ?>'
                });
            </script>
    <?php
        }
*/
        die;
    }
}
/**
 * Create a user in Zendesk and update WordPress user meta with Zendesk profile ID.
 *
 * @param array $data User data including name, email, and phone.
 *
 * @return int|false User's Zendesk profile ID on success, false on failure.
 */
function sb_create_user_zendesk($data)
{

    $userData = array(
        'user' => array(
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'verified' => 1,
        ),
    );
    $data_string = json_encode($userData);
    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users.json';
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
    curl_close($ch);
    $response = json_decode($result);
    if (isset($response->user)) {
        $user = $response->user;
        if (isset($user->id)) {
            $wordpress_user = get_user_by('email', $data['email']);
            update_user_meta($wordpress_user->ID, 'zendesk_profile_id', $user->id);
        }
        return $user->id;
    } else {
        return false;
    }
}
/**
 * Retrieve Zendesk ticket comments and related information.
 *
 * @param int $ticket_id The ID of the Zendesk ticket.
 *
 * @return array Array containing ticket information and HTML representation of comments.
 */
function sb_ticket_comments_zendesk($ticket_id)
{

    $html = '';
    $source = 'email';
    if ($ticket_id) {
        $ticket_url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '.json';
        $ch = curl_init($ticket_url);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($result, true);
        if (isset($results['ticket']['custom_fields'])) {
            foreach ($results['ticket']['custom_fields'] as $custom_field) {
                if ($custom_field['id'] == 4417382819865 && $custom_field['value'] <> '') {
                    $source = $custom_field['value'];
                    break;
                }
            }
        }
        $subject = isset($results['ticket']['subject']) ? $results['ticket']['subject'] : 'Order Request';
        if (isset($results['error'])) {
            $status = $results['error'];
        } else {
            $status = isset($results['ticket']['status']) ? $results['ticket']['status'] : 'New';
        }

        $created_at = sbr_datetime($results['ticket']['created_at']);
        $updated_at = sbr_datetime($results['ticket']['updated_at']);
        $data = array();
        $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '/comments.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($result, true);
        if (isset($results['count']) && $results['count'] > 0) {
            $html .= '<div class="previousZendeskChat">';
            $html .= '<h3 class="hidden">Messages</h3>';
            foreach ($results['comments'] as $key => $comment) {

                if ($comment['author_id'] === SB_ZENDESK_AGENT) {
                    $html .= '<div class="inner-section agent">';
                } else {
                    $html .= '<div class="inner-section customer">';
                }
                $html .= '<div class="author_info">';
                $html .= '<div class="name">';
                if ($comment['author_id'] === SB_ZENDESK_AGENT) {
                    $html .= ' Agent';
                } else {
                    $html .= ' Customer';
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<div class="response_text_parent">';
                $html .= '<div class="response_text">';

                if ($comment['html_body'] == '') {
                    $html .= $comment['body'];
                } else {
                    $html .= $comment['html_body'];
                }
                $html .= '<div class="reply-time">';
                $created = date("Y-m-d h:i:sa", strtotime($comment['created_at']));
                $html .= $created;
                if (isset($comment['attachments']) && count($comment['attachments']) > 0) {

                    $html .= '<div class="attachmentTicket">';
                    $html .= '<span class="attachmentsHeading">Attachments</span><span class="attachmentLinks">';
                    foreach ($comment['attachments'] as $attachment) {
                        $fileType = pathinfo($attachment['file_name'], PATHINFO_EXTENSION);
                        $html .= '<a href="' . $attachment['content_url'] . '" target="_blank" title="' . $attachment['file_name'] . '">';
                        if ($fileType == 'pdf') {
                            $html .= '<img src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/pdf.svg" alt="" width="" height="" />';
                        } else if ($fileType == 'doc' || $fileType == 'docx') {
                            $html .= '<img src="' . get_stylesheet_directory_uri() . '/assets/images/myaccount/doc.svg" alt="" width="" height="" />';
                        } else {
                            $html .= '<img src="' . $attachment['content_url'] . '" alt="" width="" height="" />';
                        }
                        $html .= '</a>';
                    }
                    $html .= '</span></div>';
                }
                $html .= '<div class="attachmentTicket channelWapper">';
                $html .= '<span class="attachmentsHeading">Channel</span><span class="attachmentLinks">';
                if ($comment['via']['channel'] === 'web' || $comment['via']['channel'] === 'api') {
                    if (isset($comment['via']['source']['from']) && count($comment['via']['source']['from']) > 0) {
                        if ($comment['via']['source']['from']['phone'] != '') {
                            $html .= 'Voice';
                        } else {
                            if ($comment['via']['channel'] === 'api') {
                                $html .= 'SBR Dashboard';
                            } else {
                                $html .= 'Zendesk Dashboard';
                            }
                        }
                    } else {
                        $user = wp_get_current_user();
                        if (in_array('customer', (array) $user->roles)) {
                            $html .= 'Dashboard';
                        } else {
                            $html .= 'Sms';
                        }
                    }
                } else {
                    $html .= ucfirst($comment['via']['channel']);
                }
                $html .= '</span></div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';

            $data = array(
                'error' => false,
                'status' => $status,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
                'source' => $source,
                'subject' => $subject,
                'html' => $html
            );
        } else {
            $data = array(
                'error' => false,
                'status' => 'Closed',
                'html' => 'Record Not found.'
            );
        }
    }

    return $data;
}

add_action('wp_ajax_sb_zendesk_macros_content', 'sb_zendesk_macros_content_callback');
/**
 * Callback function to retrieve content for a Zendesk macro based on the provided macro ID.
 *
 * @return void Outputs the content of the Zendesk macro action value or 'no record found'.
 */
function sb_zendesk_macros_content_callback()
{
    if (isset($_REQUEST['macro_id']) && $_REQUEST['macro_id'] != 0) {
        $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/macros/' . $_REQUEST['macro_id'] . '.json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($result, true);
        echo isset($results['macro']['actions'][0]['value']) ? $results['macro']['actions'][0]['value'] : '';
    } else {
        echo 'no record found';
    }
    die;
}
/**
 * Retrieve a list of active Zendesk macros.
 *
 * @return array Associative array containing macro IDs as keys and macro titles as values.
 */
function sb_zendesk_macros_list()
{

    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/macros/active';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result, true);
    $macros = array();
    if (isset($results['count']) && $results['count'] > 0) {

        foreach ($results['macros'] as $macro) {
            $macros[$macro['id']] = $macro['title'];
        }
    }
    return $macros;
}
/**
 * Search for a user in Zendesk based on the provided email address.
 *
 * @param string $email The email address of the user to search for.
 *
 * @return int The Zendesk profile ID of the user if found, otherwise 0.
 */
function sb_search_user_zendesk($email)
{
    // search user
    $wordpress_user = get_user_by('email', $email);
    $zendesk_profile_id = get_user_meta($wordpress_user->ID, 'zendesk_profile_id', true);
    if ($zendesk_profile_id) {
        return $zendesk_profile_id;
    } else {
        $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/search.json?query="' . $email . '"';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($result);
        if (isset($results->users[0]->id)) {
            update_user_meta($wordpress_user->ID, 'zendesk_profile_id', $results->users[0]->id);
            return $results->users[0]->id;
        } else {
            return 0;
        }
    }
}
/**
 * Search for a user in Zendesk based on the provided user ID.
 *
 * @param int $user_id The Zendesk user ID to search for.
 *
 * @return array|null Associative array containing user information if found, otherwise null.
 */
function sb_search_user_zendesk_by_id($user_id)
{
    // search user

    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/users/' . $user_id . '.json';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result, true);
    return $results;
}

/*
 * function get zendesk open tikcets
 */

function get_open_tickets_zendesk()
{
    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets.json';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result);
    $open_tickets = array();
    if (isset($results->tickets) && count($results->tickets) > 0) {
        foreach ($results->tickets as $tick) {
            $open_tickets[$tick->id] = $tick->status;
        }
    }

    return $open_tickets;
}
/**
 * Search for a user in Zendesk based on the provided user ID.
 *
 * @param int $user_id The Zendesk user ID to search for.
 *
 * @return array|null Associative array containing user information if found, otherwise null.
 */
function zendeskUpdateDashboardCounts($ticket_id = 0)
{
    // $ticket_id = 0;
    $notification_count = get_ticketsCountBystatus('open');
    update_option('open_zendesk_tickets', $notification_count);
    global $wpdb;
    if ($ticket_id) {
        $ticket_url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/' . $ticket_id . '.json';
        $ch = curl_init($ticket_url);
        curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($result, true);

        if (isset($results['ticket']) && count($results['ticket']) > 0) {
            $order_id = $wpdb->get_var("SELECT  order_id  FROM  " . SB_ORDER_TABLE . " WHERE ticket_id = $ticket_id");
            if ($order_id) {
                $wpdb->update(SB_ORDER_TABLE, array('ticket_status' => $results['ticket']['status']), array('ticket_id' => $results['ticket']['id']));
            } else {
                $wpdb->update(SB_ZENDESK_TABLE, array('status' => $results['ticket']['status']), array('ticket_id' => $results['ticket']['id']));
            }
        }
    }
}
/**
 * Search for a user in Zendesk based on the provided user ID.
 *
 * @param int $user_id The Zendesk user ID to search for.
 *
 * @return array|null Associative array containing user information if found, otherwise null.
 */
function zendeskUpdateDashboardCounts_bkkk()
{
    global $wpdb;

    $url = 'https://' . MBT_ZENDESK_HOST . '.zendesk.com/api/v2/search/count?query=status:open';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result, true);
    if (isset($results['count'])) {
        $notification_count = $results['count'];
        update_option('open_zendesk_tickets', $notification_count);
    }

    $url = 'https://' . SB_ZENDESK_HOST . '.zendesk.com/api/v2/tickets.json';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, SB_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result);
    $open_tickets = array();
    if (isset($results->tickets) && count($results->tickets) > 0) {
        foreach ($results->tickets as $tick) {
            $open_tickets[$tick->id] = $tick->status;
            $wpdb->update(SB_ZENDESK_TABLE, array('status' => $tick->status), array('ticket_id' => $tick->id));
            $wpdb->update(SB_ORDER_TABLE, array('ticket_status' => $tick->status), array('ticket_id' => $tick->id));
        }
    }

    die();
}

// create custom plugin settings menu
add_action('admin_menu', 'zendesk_plugin_create_menu');
/**
 * Create Zendesk plugin menu in the WordPress admin.
 *
 * @return void
 */
function zendesk_plugin_create_menu()
{
    $notification_count = get_option('open_zendesk_tickets');
    add_menu_page('Inbox', $notification_count ? sprintf('Inbox <span class="awaiting-mod">%d</span>', $notification_count) : 'Inbox', 'manage_options', 'support-inbox', 'getZendeskCustomerTickets', 'dashicons-welcome-widgets-menus', 10);
    //add_menu_page('Inbox', 'Inbox', 'manage_options', 'smile_brillaint_get_tickets_zendesk', '', 'dashicons-welcome-widgets-menus', 90);
    /*
      add_menu_page('Zendesk', 'Zendesk', 'manage_options', 'mbt_zendesk');
      add_submenu_page('mbt_zendesk', 'Zendesk Tickets', 'Zendesk Tickets', 'manage_options', 'mbt_zendesk_tickets', 'get_tickets_zendesk');
      add_submenu_page('mbt_zendesk', 'Zendesk Ticket Detail', 'Zendesk Ticket Detail', 'manage_options', 'mbt_zendesk_ticket_detail', 'get_ticket_detail');
      add_submenu_page('mbt_zendesk', 'Zendesk Settings', 'Zendesk Settings', 'manage_options', 'mbt_zendesk_setting', 'zendesk_settings_page');
      //call register settings function

     * 
     */
}

//add_action('admin_init', 'register_zendesk_plugin_settings');
/**
 * Get the count of Zendesk tickets based on their status.
 *
 * @param string $status The status of the tickets to count. If not provided, counts all tickets.
 *
 * @return int The count of Zendesk tickets.
 */
function get_ticketsCountBystatus($status = 0)
{
    if ($status) {
        $url = 'https://' . MBT_ZENDESK_HOST . '.zendesk.com/api/v2/search/count?query=status:' . $status;
    } else {
        $url = 'https://' . MBT_ZENDESK_HOST . '.zendesk.com/api/v2/tickets/count.json';
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result, true);


    if (isset($results['count'])) {
        if (isset($results['count']['value'])) {
            $notification_count = $results['count']['value'];
        } else {
            $notification_count = $results['count'];
        }
    } else {
        $notification_count = 0;
    }
    return $notification_count;
}
/**
 * Display the Zendesk customer tickets in a table.
 */
function getZendeskCustomerTickets()
{
    wp_enqueue_script('dataTables', 'https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery'), true);
    wp_enqueue_style('dataTables', 'https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css', '1.0.0', true);

    $openTickets = get_option('open_zendesk_tickets');
    if ($openTickets == '') {
        $openTickets = 0;
    }

    $pendingTickets = get_ticketsCountBystatus('pending');
    $totalTickets = get_ticketsCountBystatus();
    $solvedTickets = get_ticketsCountBystatus('solved');
    ?>

    <style>
        .flex-row {

            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            background-color: #f0f0f0;
            box-shadow: inset -1px -1px 0 #e0e0e0;
            width: 98%;
            -webkit-box-align: center !important;
            -ms-flex-align: center !important;
            align-items: center !important;
        }

        .flex-child {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
            border-top: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            background: #fff;
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .flex-row .flex-child:first-child {
            border-left: 1px solid #e0e0e0;
        }

        .flex-child h4 {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-weight: 600;
            font-size: 18px;
            line-height: 15px;
        }

        #example {
            border-collapse: collapse;
            width: 98%;
            margin-top: 30px;
            border: 1px solid #ccc;
        }

        #example tr th,
        #example tr td {
            padding: 10px 10px;
            background-color: #fff;

            white-space: nowrap;
            text-align: left;
            border-left: 1px solid #ccc;
        }

        #example tr td {
            font-weight: normal;
            border-bottom: 1px solid #ccc;
        }

        #example tr th {
            border-bottom: 1px solid #ccc;
            border-left: 1px solid #ccc;
        }

        #example thead tr th {
            border-bottom: 1px solid #ccc;
            border-left: 1px solid #ccc;
            padding: 10px 10px;
            background: #f2f2f2;
            border-bottom: 1px solid #ccc;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
            text-transform: uppercase;
        }

        .diplaytickets-mbt tr td {
            font-size: 14px;
        }

        .diplaytickets-mbt .flex-mbt-container .flex-mbt>div {
            display: flex;
            justify-content: space-between;
            padding-bottom: 4px;
            border-bottom: 1px solid #cccccc96;
            margin-bottom: 4px;
            margin-left: -10px;
            margin-right: -10px;
            padding-left: 10px;
            padding-right: 10px;
            font-weight: bold;
        }

        .flex-mbt-container .flex-mbt>div:last-child {
            border-bottom: 0px;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .flex-mbt-container .flex-mbt>div p {
            margin: 0;
            font-weight: normal;
            font-size: 14px;
        }

        a.action-icon-inbox {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #000;
            text-decoration: none;
        }

        #example.diplaytickets-mbt tr td,
        #example.diplaytickets-mbt tfoot th {
            text-align: center;
        }
    </style>

    <div class="flex-row contianer-mbt">
        <div class="flex-child">
            <h4>Total Tickets</h4>
            <h4><?php echo $totalTickets; ?></h4>
        </div>

        <div class="flex-child">
            <h4>Open Tickets</h4>
            <h4><?php echo $openTickets; ?></h4>
        </div>
        <div class="flex-child">
            <h4>Pending Tickets</h4>
            <h4><?php echo $pendingTickets; ?></h4>
        </div>
        <div class="flex-child">
            <h4>Close Tickets</h4>
            <h4><?php echo $solvedTickets; ?></h4>
        </div>



    </div>

    <table id="shipmentRecord" class="data-table" style="width:99%">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Request</th>
                <th>Ticket Status</th>
                <th>Created Date</th>
                <th>Customer</th>
                <th>Order</th>
                <th>Product</th>
                <th>Tray Number</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>

        </tbody>

    </table>
    <style>
        table.dataTable tbody tr {
            background-color: #fff;
            text-align: center;
        }
    </style>
    <script>
        var datatable = '';
        jQuery(document).ready(function() {
            datatable = jQuery('#shipmentRecord').DataTable({
                "ordering": false,
                "searching": false,
                "processing": true,
                "serverSide": true,
                "retrieve": true,
                "ajax": {
                    url: "<?php echo admin_url('admin-ajax.php?action=getZendeskTicketsRecords'); ?>",
                    type: "GET",
                    "data": function(d) {

                        //  d.contact_request = 1
                    },
                    "complete": function(response) {


                    }

                }
            });
        });
    </script>
<?php
}
/**
 * Get Zendesk customer data based on the provided user ID.
 *
 * @param int $user_id The user ID for which to retrieve Zendesk customer data.
 */
function getZendeskCustomerData($user_id)
{
    // search user
    $ch = curl_init('https://' . MBT_ZENDESK_HOST . '.zendesk.com/api/v2/users/' . $user_id . '/identities.json');
    curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /* curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
      );
     */


    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result);
    print_r($results);
}

/**
 * Get the Zendesk custom field option name based on the provided ticket field ID,
 * ticket field option ID, and request type.
 *
 * @param int    $ticket_field_id        The ID of the Zendesk ticket field.
 * @param int    $ticket_field_option_id The ID of the Zendesk ticket field option.
 * @param string $getRequestType         The request type to be determined.
 *
 * @return string The name of the custom field option corresponding to the given IDs and request type.
 */
function getZendeskCustomField($ticket_field_id, $ticket_field_option_id, $getRequestType)
{
    $url = "https://" . MBT_ZENDESK_HOST . ".zendesk.com/api/v2/ticket_fields/$ticket_field_id/options.json";
    //$url = 'https://smilebrilliant.zendesk.com/api/v2/ticket_fields/900010956323/options/900009491503.json';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result);
    // echo 'Data: <pre>' .print_r($results,true). '</pre>';
    if (isset($results->custom_field_options)) {
        foreach ($results->custom_field_options as $options) {
            if (isset($options->value) && $options->value == $ticket_field_option_id) {
                $getRequestType = $options->name;
                break;
            }
        }
    }
    return $getRequestType;
    //return $results;
}
// Add AJAX action hook for handling Zendesk ticket records
add_filter('wp_ajax_getZendeskTicketsRecords', 'getZendeskTicketsRecords_callback');
/**
 * Callback function for handling the retrieval of Zendesk ticket records via AJAX.
 */
function getZendeskTicketsRecords_callback()
{
    global $wpdb;
    if (!empty($_GET)) {
        //    echo '<pre>';
        //    print_r($_GET);
        //    echo '</pre>';
        $orderByColumnIndex = 0;
        // $orderBy = 'desc';
        /* SEARCH CASE : Filtered data */
        /* Useful $_REQUEST Variables coming from the plugin */
        $draw = $_GET["draw"]; //counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
        if (isset($_GET['order'][0]['column']) && $_GET['order'][0]['column'] > 0) {
            $orderByColumnIndex = $_GET['order'][0]['column']; // index of the sorting column (0 index based - i.e. 0 is the first record)
            if (isset($_GET['columns'][$orderByColumnIndex]['data'])) {
                $orderBy = $_GET['columns'][$orderByColumnIndex]['data']; //Get name of the sorting column from its index
            }
        }
        $orderType = 'DESC';
        if (isset($_GET['order'][0]['dir']) && $_GET['order'][0]['dir'] != '') {
            $orderType = $_GET['order'][0]['dir']; // ASC or DESC    
        }

        $start = $_GET["start"]; //Paging first record indicator.
        $length = $_GET['length']; //Number of records that the table can display in the current draw
        $searchValue = $_GET['search']['value'];
        $searchQuery = " ";
        $searchDateQuery = " ";
        //  $offset = ($draw-1) * $length;
        $currentPage = floor($start / $length) + 1;
        //   echo 'Data: <pre>' .print_r($currentPage,true). '</pre>';die;
        //  echo 'Data: <pre>' .print_r($start,true). '</pre>';
        if (!empty($_GET['search']['value'])) {
        }

        global $wpdb;
        $url = "https://" . MBT_ZENDESK_HOST . ".zendesk.com/api/v2/tickets.json?sort_order=desc&sort_by=updated_at&&per_page=$length&page=$currentPage";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($result);
        date_default_timezone_set('America/Chicago');
        $modified_data = array();
        foreach ($results->tickets as $res) {
            // echo 'Data: <pre>' .print_r($res,true). '</pre>';
            // if ($res->status == 'pending' || $res->status == 'open' || $res->status == 'new') {
            $ticket_id = $res->id;
            $ticket_date = $res->created_at;
            // $ticket_date = explode("T", $ticket_date);
            //   $ticket_date = date('M-D-Y' , strtotime($ticket_date));
            $ticket_date = sbr_datetime($ticket_date);
            $response = $res->description;

            $user_id = 0;
            $order_id = 0;
            $tray_number = '';
            $product_id = 0;
            $query_response = $wpdb->get_row("SELECT  * FROM  " . SB_ORDER_TABLE . " WHERE ticket_id = $ticket_id");
            if ($query_response) {
                $user_id = isset($query_response->user_id) ? $query_response->user_id : 0;
                $order_id = isset($query_response->order_id) ? $query_response->order_id : 0;
                $tray_number = isset($query_response->tray_number) ? $query_response->tray_number : 0;
                $product_id = isset($query_response->product_id) ? $query_response->product_id : 0;
                $statusCode = isset($query_response->status) ? $query_response->status : 0;
            } else {
                $query_response = $wpdb->get_row("SELECT  * FROM  " . SB_ZENDESK_TABLE . " WHERE ticket_id = $ticket_id");
                $order_id = isset($query_response->order_id) ? $query_response->order_id : 0;
                if ($order_id) {
                    $user_id = get_post_meta($order_id, '_customer_user', true);
                }
            }


            $statusAllow = array(1, 2, 3, 5, 6, 7, 8);
            $status = 'N/A';
            if (!empty($statusCode) && in_array($statusCode, $statusAllow)) {
                if ($statusCode == 2 || $statusCode == 6) {
                    $status = 'Shipped';
                } else if ($statusCode == 1) {
                    $status = 'Ready for ship';
                } else if ($statusCode == 3) {
                    $status = 'Waiting for impression';
                } else {
                    $status = 'Pending lab work';
                }
            }
            //echo 'Data: <pre>' .print_r($res->id,true). '</pre>';
            $getRequestType = NULL;
            if ($res->custom_fields) {
                foreach ($res->custom_fields as $field) {
                    if (isset($field->id) && $field->id == 900010956323 && trim($field->value) <> '') {
                        $ticket_field_option_id = $field->value;
                        $getRequestType = getZendeskCustomField(900010956323, $ticket_field_option_id, $getRequestType);
                        // echo 'Data: <pre>' .print_r($getRequestType,true). '</pre>';
                    }

                    //  echo 'Data: <pre>' .print_r($getRequestType,true). '</pre>';
                }
            }
            if (empty($getRequestType)) {
                $getRequestType = $res->subject;
            }

            $user_html = '';
            if ($user_id) {
                // $user = get_userdata($user_id);
                $user_name = get_user_meta($user_id, 'billing_first_name', true) . ' ' . get_user_meta($user_id, 'billing_last_name', true);
                //if($user_id && $user_name){
                $user_html = '<a href= "' . admin_url('?page=customer_history&customer_id=' . $user_id) . '" class="button-primary" target = "_blank">' . $user_name . '</a>';
            }

            $order_html = '';
            if ($order_id) {
                $order_number = get_post_meta($order_id, 'order_number', true);
                $orderURL = get_admin_url(null, 'post.php?post=' . $order_id . '&action=edit');
                $order_html = '<a href="' . $orderURL . '"  class="button-primary" target="_blank" >' . $order_number . '</a>';
            }
            $product_html = '';
            if ($product_id) {
                $product_html = get_the_title($product_id);
            }


            $modified_data[] = array(
                $ticket_id, $getRequestType,
                ucfirst($res->status),
                $ticket_date,
                $user_html,
                $order_html,
                $product_html,
                $tray_number,
                '<a class="action-icon-inbox" target = _blank href="https://smilebrilliant.zendesk.com/agent/tickets/' . $ticket_id . '"> <span class="dashicons dashicons-visibility"></span></a>'
            );
        }

        //$page = (isset($_GET['page']) && $_GET['page'] > 0) ? intval($_GET['page']) : 1;

        $results = array(
            "draw" => intval($draw),
            "iTotalRecords" => $results->count,
            "iTotalDisplayRecords" => $results->count,
            "data" => $modified_data
        );
        // echo 'results: <pre>' .print_r($results,true). '</pre>';
        echo json_encode($results);
    }
    die;
}
/**
 * Callback function for handling the retrieval of Zendesk ticket records for dashboard.
 */
function smile_brillaint_get_tickets_zendesk()
{

    $openTickets = get_option('open_zendesk_tickets');
    if ($openTickets == '') {
        $openTickets = 0;
    }

    $pendingTickets = get_ticketsCountBystatus('pending');
    $totalTickets = get_ticketsCountBystatus();
    $solvedTickets = get_ticketsCountBystatus('solved');


    $url = 'https://' . MBT_ZENDESK_HOST . '.zendesk.com/api/v2/tickets.json';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, MBT_ZENDESK_USERPWD);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $results = json_decode($result);

    $html_solved = '';
    $html_open = '';
    foreach ($results->tickets as $res) {
        if ($res->status == 'pending' || $res->status == 'open' || $res->status == 'new') {
            $ticket_id = $res->id;

            $ticket_date = $res->created_at;
            $ticket_date = explode("T", $ticket_date);
            $ticket_date = $ticket_date[0];

            global $wpdb;

            $query_response = $wpdb->get_row("SELECT  * FROM  " . SB_ORDER_TABLE . " WHERE ticket_id = $ticket_id");
            $user_id = isset($query_response->user_id) ? $query_response->user_id : 0;
            $order_id = isset($query_response->order_id) ? $query_response->order_id : 0;
            $tray_number = isset($query_response->tray_number) ? $query_response->tray_number : 0;
            $product_id = isset($query_response->product_id) ? $query_response->product_id : 0;
            $statusCode = isset($query_response->status) ? $query_response->status : 0;
            $order_number = get_post_meta($order_id, 'order_number', true);
            //echo 'Data: <pre>' .print_r($query_response->user_id,true). '</pre>';
            $user_name = get_user_meta($user_id, 'billing_first_name', true) . ' ' . get_user_meta($user_id, 'billing_last_name', true);

            $statusAllow = array(1, 2, 3, 5, 6, 7, 8);
            $status = 'N/A';
            if (!empty($statusCode) && in_array($statusCode, $statusAllow)) {
                if ($statusCode == 2 || $statusCode == 6) {
                    $status = 'Shipped';
                } else if ($statusCode == 1) {
                    $status = 'Ready for ship';
                } else if ($statusCode == 3) {
                    $status = 'Waiting for impression';
                } else {
                    $status = 'Pending lab work';
                }
            }

            $orderURL = get_admin_url(null, 'post.php?post=' . $order_id . '&action=edit');

            $htmlTicketInfo = '<div class="flex-mbt-container">
        <div class="flex-mbt">
            <div>Ticket #
                <p>' . $ticket_id . '</p>
            </div>         
            <div>Ticket Status
                <p>' . ucfirst($res->status) . '</p>
            </div>
            <div>Created
                <p>' . $ticket_date . '</p>
            </div> 
        </div>';

            $html_open .= '<tr>
                <td>' . $htmlTicketInfo . '</td>
                <td>' . $user_name . '</td>
                <td><a href="' . $orderURL . '" target="_blank" >' . $order_number . '</a></td>
                <td>' . get_the_title($product_id) . '</td>
                <td>' . $tray_number . '</td>
                <td>' . $status . '</td>
                <td><a class="action-icon-inbox" target = _blank href="https://smilebrilliant.zendesk.com/agent/tickets/' . $ticket_id . '"><span class="dashicons dashicons-controls-repeat"></span> <span class="dashicons dashicons-visibility"></span></a></td>
            </tr>';
        }
    }
?>

    <style>
        .flex-row {

            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            background-color: #f0f0f0;
            box-shadow: inset -1px -1px 0 #e0e0e0;
            width: 98%;
            -webkit-box-align: center !important;
            -ms-flex-align: center !important;
            align-items: center !important;
        }

        .flex-child {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            max-width: 100%;
            border-top: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            background: #fff;
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .flex-row .flex-child:first-child {
            border-left: 1px solid #e0e0e0;
        }

        .flex-child h4 {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-weight: 600;
            font-size: 18px;
            line-height: 15px;
        }

        #example {
            border-collapse: collapse;
            width: 98%;
            margin-top: 30px;
            border: 1px solid #ccc;
        }

        #example tr th,
        #example tr td {
            padding: 10px 10px;
            background-color: #fff;

            white-space: nowrap;
            text-align: left;
            border-left: 1px solid #ccc;
        }

        #example tr td {
            font-weight: normal;
            border-bottom: 1px solid #ccc;
        }

        #example tr th {
            border-bottom: 1px solid #ccc;
            border-left: 1px solid #ccc;
        }

        #example thead tr th {
            border-bottom: 1px solid #ccc;
            border-left: 1px solid #ccc;
            padding: 10px 10px;
            background: #f2f2f2;
            border-bottom: 1px solid #ccc;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
            text-transform: uppercase;
        }

        .diplaytickets-mbt tr td {
            font-size: 14px;
        }

        .diplaytickets-mbt .flex-mbt-container .flex-mbt>div {
            display: flex;
            justify-content: space-between;
            padding-bottom: 4px;
            border-bottom: 1px solid #cccccc96;
            margin-bottom: 4px;
            margin-left: -10px;
            margin-right: -10px;
            padding-left: 10px;
            padding-right: 10px;
            font-weight: bold;
        }

        .flex-mbt-container .flex-mbt>div:last-child {
            border-bottom: 0px;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .flex-mbt-container .flex-mbt>div p {
            margin: 0;
            font-weight: normal;
            font-size: 14px;
        }

        a.action-icon-inbox {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #000;
            text-decoration: none;
        }

        #example.diplaytickets-mbt tr td,
        #example.diplaytickets-mbt tfoot th {
            text-align: center;
        }
    </style>

    <div class="flex-row contianer-mbt">
        <div class="flex-child">
            <h4>Total Tickets</h4>
            <h4><?php echo $totalTickets; ?></h4>
        </div>

        <div class="flex-child">
            <h4>Open Tickets</h4>
            <h4><?php echo $openTickets; ?></h4>
        </div>
        <div class="flex-child">
            <h4>Pending Tickets</h4>
            <h4><?php echo $pendingTickets; ?></h4>
        </div>
        <div class="flex-child">
            <h4>Close Tickets</h4>
            <h4><?php echo $solvedTickets; ?></h4>
        </div>



    </div>
    <table id="example" class="display diplaytickets-mbt">
        <thead>
            <tr>
                <th>Ticket Info</th>
                <th>Customer</th>
                <th>Order#</th>
                <th>Product</th>
                <th>Tray#</th>
                <th>Order Item Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $html_open; ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Ticket Info</th>
                <th>Customer</th>
                <th>Order#</th>
                <th>Product</th>
                <th>Tray#</th>
                <th>Order Item Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
<?php
}
