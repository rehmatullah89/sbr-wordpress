<?php

/**
 * Search for a user in Zendesk based on their email address.
 *
 * @param string $email The email address of the user to search for.
 *
 * @return int|null The user ID if found, or null if the user is not found.
 */
function search_user_zendesk($email)
{
    // search user
    $ch = curl_init('https://mindblazetech.zendesk.com/api/v2/users/search.json?query="' . $email . '"');
    curl_setopt($ch, CURLOPT_USERPWD, "abidoon@mindblazetech.com:xlma2190");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $results = json_decode($result);
    $user_id = $results->users[0]->id;
    return $user_id;
}
/**
 * Retrieve user information from Zendesk based on the user ID.
 *
 * @param int $user_id The ID of the user to retrieve information for.
 *
 * @return object|null The user information as an object if found, or null if the user is not found.
 */
function search_user_zendesk_by_id($user_id)
{
    // search user
    $ch = curl_init('https://mindblazetech.zendesk.com/api/v2/users/' . $user_id . '.json');
    curl_setopt($ch, CURLOPT_USERPWD, "abidoon@mindblazetech.com:xlma2190");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $results = json_decode($result);
    return $results;
}

add_action('wp_ajax_send_reply_to_csutomer', 'send_reply_to_csutomer_callback');
/**
 * Callback function for sending a reply to a customer ticket via AJAX.
 */
function send_reply_to_csutomer_callback()
{

    $message = isset($_REQUEST['reply']) ? $_REQUEST['reply'] : '';
    if ($message == '') {
        echo 'unable to add comment. Message Empty';
        die();
    }


    $ticket_id = isset($_REQUEST['ticket_id']) ? $_REQUEST['ticket_id'] : '';
    if ($ticket_id == '') {
        echo 'unable to add comment';
        die();
    }


    //  $author_id = search_user_zendesk($email);
    $arr = array();
    $arr['ticket'] = array(
        "status" => 'open',
        "comment" => array(
            "body" => $message,
            //   "uploads" => [$token],
            "author_id" => 413830874013,
        )
    );
    $data_string = json_encode($arr);

    $ch = curl_init('https://mindblazetech.zendesk.com/api/v2/tickets/' . $ticket_id . '.json');
    curl_setopt($ch, CURLOPT_USERPWD, "abidoon@mindblazetech.com:xlma2190");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            //'Content-Length: ' . strlen($data_string)
        )
    );


    $result = curl_exec($ch);
    $results = json_decode($result);

    if ($results->ticket->id != '') {
        echo '<h5 style="color:green">Message Sent <span style="font-family: wingdings; font-size: 150%;">&#252;</span></h5>';
    }

    die;
}

add_action('wp_ajax_ticketChatByOrderItem', 'ticketChatByOrderItem_callback');
add_action('wp_ajax_zendesk_ticket_replies', 'zendesk_ticket_replies_callback');
/**
 * AJAX callback function for handling ticket chat by order item.
 */
function zendesk_ticket_replies_callback()
{
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'zendesk_ticket_replies') {
        $ticket_id = $_REQUEST['ticket_id'];
        echo ticket_comments_zendesk($ticket_id);
    }
    die;
}

function ticket_comments_zendesk($ticket_id)
{
    $html = '';
    if ($ticket_id) {
        $ch = curl_init('https://mindblazetech.zendesk.com/api/v2/tickets/' . $ticket_id . '/comments.json');
        curl_setopt($ch, CURLOPT_USERPWD, "abidoon@mindblazetech.com:xlma2190");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $result = curl_exec($ch);
        $results = json_decode($result);

        if (isset($results->count) && $results->count > 0) :

            foreach ($results->comments as $key => $comment) {

                $comment_results = search_user_zendesk_by_id($comment->author_id);
                $html .= '<tr>';
                $html .= '<td>';
                $html .= $comment_results->user->name;
                if ($comment_results->user->ticket_restriction === 'requested') {
                    $html .= ' (Customer)';
                } else {
                    $html .= ' (Agent)';
                }
                $html .= '</td>';
                $html .= '<td>';
                $html .= $comment->body;
                $html .= '</td>';
                $html .= '<td>';
                $created = $comment->created_at;
                $created = date("Y-m-d h:i:sa", strtotime($created));
                $html .= $created;
                $html .= '</td>';
                $html .= '</tr>';
            }
        endif;
    } else {
        $html = 'Unable to retrive data. Please Try Agian';
    }

    return $html;
}

add_action('wp_ajax_create_shipping_request', 'create_shipping_request_callback');
/**
 * Callback function create shipping request  via AJAX.
 */
function create_shipping_request_callback()
{
?>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th class="txt-left col1">Product Name</th>
                <th class="txt-left col2">QTY</th>
                <th class="txt-left statusbx col3">Shipped</th>
                <th class="txt-left col4">Left to Ship</th>
                <th class="txt-left col4">Shipping Now</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $order_id = $_REQUEST['order_id'];
            $order = wc_get_order($order_id);

            foreach ($order->get_items() as $item_id => $item) {
                $product_id = $item->get_product_id();
                $product = $item->get_product();
                $product_visibility = $product->get_catalog_visibility();


                if ($product_visibility == 'visible') {
            ?>

                    <tr>
                        <td class="txt-left col1"><?php echo $product->get_name(); ?></td>
                        <td class="txt-left col2">1</td>
                        <td class="txt-left statusbx col3">1</td>
                        <td class="txt-left col4">2</td>
                        <td class="txt-left col4"><select>
                                <option>1</option>
                            </select></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <h2 style="font-size: 16px">Shipping Setup</h2>


    <table class="table">

        <tbody>

            <tr>
                <td class="txt-left ">Method <br>
                    <select>
                        <option>USPS</option>
                    </select>
                </td>

                <td class="txt-left ">Shipping Label <br>
                    <input type="text">
                </td>
                <td class="txt-left ">Shipping Product <br>
                    <input type="text">
                </td>
                <td class="txt-left ">Shipping Date <br>
                    <input type="text">
                </td>
                <td class="txt-left "></td>
            </tr>

            <tr>
                <td class="txt-left ">Package <br>
                    <input type="text">
                </td>

                <td class="txt-left ">Length (Inch)<br>
                    <input type="text">
                </td>
                <td class="txt-left ">Width (Inch)<br>
                    <input type="text">
                </td>
                <td class="txt-left ">Height (Inch)<br>
                    <input type="text">
                </td>
                <td class="txt-left ">Weight (grams)<br>
                    <input type="text">
                </td>
            </tr>

            <tr>
                <td class="txt-left " colspan="5">
                    <h5>Add Shipping Note</h5>
                    <textarea name=" " rows="4" cols="100"></textarea>
                </td>
            </tr>

            <tr>
                <td class="txt-left ">Email Shippment Confirmation <br>
                    <input type="text">
                </td>

                <td class="txt-left ">Close Order<br>
                    <input type="text">
                </td>
                <td class="txt-left ">Print Packing Slip<br>
                    <input type="text">
                </td>
                <td class="txt-left ">
                </td>
                <td class="txt-left ">
                </td>
            </tr>

            <tr>
                <td class="txt-left " colspan="5">
                    <h5>Customer Shipping Address</h5>
                    <input type="text" style="width: 100%;  max-width: 500px">
                </td>
            </tr>



            <tr>
                <td class="txt-left ">City<br>
                    <input type="text">
                </td>

                <td class="txt-left ">State<br>
                    <input type="text">
                </td>
                <td class="txt-left ">Country<br>
                    <input type="text">
                </td>
                <td class="txt-left ">
                </td>
                <td class="txt-left ">
                </td>
            </tr>

            <tr>
                <td class="txt-left ">
                    <button>Print</button>
                </td>

                <td class="txt-left ">
                    <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
                    <label for="vehicle3">Print Shipping Details</label>

                </td>
                <td class="txt-left "> <button>Ship Order</button>
                </td>
                <td class="txt-left ">
                </td>
                <td class="txt-left ">
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    die;
}
/**
 * Callback function for ticket chat by order item via AJAX.
 */
function ticketChatByOrderItem_callback()
{
    $ticket_id = isset($_REQUEST['ticket_id']) ? $_REQUEST['ticket_id'] : 0;
    $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
    $order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : 0;
    $user_name = get_user_meta($user_id, 'billing_first_name', true) . ' ' . get_user_meta($user_id, 'billing_last_name', true);
    if ($ticket_id) {
        //  $results = zendesk_get_ticket_by_id($ticket_id);
    ?>
        <h2><?php echo 'Order Number: ' . $order_id; ?>
            <br />
            <?php echo 'Customer Name: ' . $user_name; ?>
        </h2>
        <div class="loading" style="display: none"></div>
        <style>
            .loading {
                height: 0;
                width: 0;
                padding: 15px;
                border: 6px solid #ccc;
                border-right-color: #888;
                border-radius: 22px;
                -webkit-animation: rotate 1s infinite linear;
                /* left, top and position just for the demo! */
                position: absolute;
                left: 50%;
                top: 50%;
            }

            @-webkit-keyframes rotate {

                /* 100% keyframe for  clockwise. 
                   use 0% instead for anticlockwise */
                100% {
                    -webkit-transform: rotate(360deg);
                }
            }
        </style>
        <table class="wp-list-table widefat fixed striped comments">
            <thead>
                <tr>
                    <th scope="col" id="author" class="manage-column column-author sortable desc">
                        Author
                    </th>
                    <th scope="col" id="comment" class="manage-column column-comment column-primary">Description</th>
                    <th scope="col" id="date" class="manage-column column-date sortable desc">
                        Submitted On
                    </th>
                </tr>
            </thead>

            <tbody id="zendesk_replies_list" data-wp-lists="list:comment">
                <?php
                /*
                  <tr id="comment-1" class="comment even thread-even depth-1 approved">

                  <td class="author column-author" data-colname="Author">

                  <?php echo $user_name; ?>

                  </td>
                  <td class="author column-author" data-colname="Author">

                  <p><?php echo $results->ticket->description; ?></p>

                  </td>

                  <td class="author column-author" data-colname="Author">

                  <?php
                  $created = $results->ticket->created_at;
                  $created = explode("T", $created);
                  $created = $created[0];
                  echo $created = date("Y-m-d h:i:sa", strtotime($created));
                  ?>

                  </td>
                  </tr>
                  <tr>
                  <td colspan="2">Replies</td>
                  </tr>
                 * 
                 */
                echo $comment_results = ticket_comments_zendesk($ticket_id);
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><button id="reload_msg">Reload Messages</button></td>
                </tr>
            </tfoot>



        </table>
        <br /><br />
        <form action="#" id="reply_zendesk">

            <textarea id="zendesk_reply" name="reply" style="width: 100%;" rows="6" placeholder="Reply to Customer"></textarea>
            <input type="hidden" id="ticket_id" value="<?php echo $ticket_id; ?>" />
            <button id="zendesk_send_btn" type="button">Send</button>
        </form>
        <div id="request_response"></div>
        <br /><br />
        <script>
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

            jQuery('body').on('click', '#reload_msg', function() {
                jQuery('.loading').show();
                jQuery('#reload_msg').prop('disabled', true);
                jQuery('#zendesk_replies_list').html('<tr><td colspan="3" style="text-align: center;">Please Wait.....</td></tr>');
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'zendesk_ticket_replies',
                        ticket_id: jQuery('#ticket_id').val()
                    },
                    method: 'POST',
                    success: function(response) {
                        jQuery('#reload_msg').prop('disabled', false);
                        jQuery('#zendesk_replies_list').html(response);
                        jQuery('.loading').hide();
                    },
                    cache: false,
                    //    contentType: false,
                    //     processData: false
                });
            });

            jQuery('body').on('click', '#zendesk_send_btn', function() {

                if (jQuery('#zendesk_reply').val() == '') {
                    jQuery('#request_response').html('Please Type Message to send Customer.');
                } else {
                    jQuery('#zendesk_send_btn').html('Sending......');
                    jQuery('#zendesk_send_btn').prop('disabled', true);
                    jQuery('.loading').show();
                    //jQuery('#zendesk_replies_list').html('');
                    jQuery.ajax({
                        url: ajaxurl,
                        data: {
                            action: 'send_reply_to_csutomer',
                            reply: jQuery('#zendesk_reply').val(),
                            ticket_id: jQuery('#ticket_id').val()
                        },
                        method: 'POST',
                        success: function(response) {
                            jQuery('#request_response').html(response);
                            jQuery('#zendesk_reply').val('');
                            jQuery('#zendesk_send_btn').html('Send');
                            jQuery('#zendesk_send_btn').prop('disabled', false);
                            jQuery('#reload_msg').trigger('click');
                        },
                        cache: false,
                        //    contentType: false,
                        //     processData: false
                    });
                }
            });
            /*
             * beforeSend : function ( xhr ) {
             button.text('Loading...'); // change the button text, you can also add a preloader image
             },
             */
        </script>
        <style>
            #TB_ajaxContent {
                max-height: auto !important;
            }
        </style>
<?php
    }
    die;
}
/**
 * Get information about a Zendesk ticket by its ID.
 *
 * @param string $ticket_id The ID of the Zendesk ticket.
 *
 * @return object|null Returns the decoded JSON response containing ticket information, or null if the ticket_id is empty.
 */
function zendesk_get_ticket_by_id($ticket_id = '')
{
    if ($ticket_id != '') {

        $ch = curl_init('https://mindblazetech.zendesk.com/api/v2/tickets/' . $ticket_id . '.json');
        curl_setopt($ch, CURLOPT_USERPWD, "abidoon@mindblazetech.com:xlma2190");
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                //'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        $results = json_decode($result);
        $content_array = array();
        $content_array['content'] = $results->ticket->description;
        $created = $results->ticket->created_at;
        $created = explode("T", $created);
        $created = $created[0];
        $created = date("m-d-Y", strtotime($created));
        $content_array['created'] = $created;
        $content_array['status'] = $results->ticket->status;
        $content_array['id'] = $results->ticket->id;
        $content_array['subject'] = $results->ticket->subject;
        return $results;
    }
}
/**
 * Create a Zendesk ticket for a product order.
 *
 * @param object $item         The WooCommerce order item.
 * @param object $order        The WooCommerce order.
 * @param int    $requester_id The Zendesk requester ID.
 * @param int    $order_id     The WooCommerce order ID.
 *
 * @return string|bool Returns the Zendesk ticket ID if successful, false if an error occurs.
 */
function create_ticket_zendesk($item, $order, $requester_id, $order_id)
{

    $product_id = $item->get_product_id();
    $product = $item->get_product();
    $name = $item->get_name();
    $quantity = $item->get_quantity();

    $subject = 'Kit ' . $name;
    $attachment = "";
    $message = $name . ' Product Order By Customer. 9090 Test With Custom Data';
    $address = '';
    if ($order->get_formatted_shipping_address()) {
        $address = $order->get_formatted_shipping_address();
    } else {
        $address = $order->get_formatted_billing_address();
    }
    $arr = array();
    $arr['ticket'] = array(
        "subject" => $subject,
        "requester_id" => $requester_id,
        "comment" => array(
            "body" => $message,
            "uploads" => [$attachment],
        ),
        "assignee_id" => 413830874013,
        //        "custom_fields" => array(
        //            "id" => 360044205794,
        //            "value" => $address
        //        )
    );
    $data_string = json_encode($arr);


    $ch = curl_init('https://mindblazetech.zendesk.com/api/v2/tickets.json');
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

    $ticket_created = json_decode($result);
    if ($ticket_created->ticket->id != '') {

        update_post_meta($order_id, 'zendesk_ticket', 'yes');
        return $ticket_created->ticket->id;
    } else if ($ticket_created->error != '') {
        return FALSE;
    }
}
/**
 * Create a user in Zendesk.
 *
 * @param array $data An array containing user data including name, email, phone, etc.
 *
 * @return int|bool Returns the Zendesk user ID if successful, false if an error occurs.
 */
function create_user_zendesk($data)
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
    $ch = curl_init('https://mindblazetech.zendesk.com/api/v2/users.json');
    curl_setopt($ch, CURLOPT_USERPWD, "abidoon@mindblazetech.com:xlma2190");
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
