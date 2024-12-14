<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * A custom Expedited Order WooCommerce Email class
 *
 * @since 0.1
 * @extends \WC_Email
 */

class WC_Shipment_Order_Email extends WC_Email
{

    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct()
    {

        $this->id = 'easypost_shipment_order';
        $this->customer_email = true;
        $this->title = __('Order Items Shipped', 'woocommerce');
        $this->description = __('Send an update email to customers with items that were just shipped.', 'woocommerce');

        $this->template_html = 'emails/easypost-order-shipped.php';

        parent::__construct();
        $this->placeholders = array(
            '{site_title}' => $this->get_blogname(),
            '{order_date}' => '',
            '{order_number}' => '',
        );
        $this->manual = true;
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $order_id
     */
    public function trigger($order_id)
    {

        $this->setup_locale();


        $order = wc_get_order($order_id);
        $this->object = $order;
        $this->recipient = $this->object->get_billing_email();
        $this->placeholders['{order_date}'] = \wc_format_datetime($this->object->get_date_created());
        $this->placeholders['{order_number}'] = $this->object->get_order_number();

        if ($this->get_recipient()) {
            $response = $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());

            if ($response) {
                // Clear the email queue and add an order note
                $note = 'Email Sent to customer. Tracking ID: ' . $_POST['easypost_tracking_number'];
                $order->add_order_note($note);
            }
        }

        $this->restore_locale();
    }

    /**
     * Get email subject.
     *
     * @access public
     * @return string
     */
    public function get_subject()
    {
        $default_subject = __('Your order from Smile brilliant has been shipped!', 'woocommerce');
        $subject = $this->get_option('subject', $default_subject);

        return __($this->format_string($subject), 'woocommerce');
    }

    /**
     * Get email heading.
     *
     * @access public
     * @return string
     */
    public function get_heading()
    {
        $default_heading = __('Your parcel has been shipped!', 'woocommerce');
        $heading = $this->get_option('heading', $default_heading);

        return __($this->format_string($heading), 'woocommerce');
    }

    /**
     * get_content_html function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_html()
    {
        ob_start();
        woocommerce_get_template($this->template_html, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => false,
            'email' => $this,
        ));
        return ob_get_clean();
    }

    /**
     * get_content_plain function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_plain()
    {
        ob_start();
        woocommerce_get_template($this->template_plain, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => true,
            'email' => $this,
        ));
        return ob_get_clean();
    }

    /**
     * Initialize Settings Form Fields
     *
     * @since 2.0
     */
    public function init_form_fields()
    {

        $this->form_fields = array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable this email notification',
                'default' => 'yes'
            ),
            'recipient' => array(
                'title' => 'Recipient(s)',
                'type' => 'text',
                'description' => sprintf('Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', esc_attr(get_option('admin_email'))),
                'placeholder' => '',
                'default' => ''
            ),
            'subject' => array(
                'title' => 'Subject',
                'type' => 'text',
                'description' => sprintf('This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject),
                'placeholder' => '',
                'default' => ''
            ),
            'heading' => array(
                'title' => 'Email Heading',
                'type' => 'text',
                'description' => sprintf(__('This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.'), $this->heading),
                'placeholder' => '',
                'default' => ''
            ),
            'email_type' => array(
                'title' => __('Email type', 'woocommerce'),
                'type' => 'select',
                'description' => __('Choose which format of email to send.', 'woocommerce'),
                'default' => 'html',
                'class' => 'email_type wc-enhanced-select',
                'options' => $this->get_email_type_options(),
                'desc_tip' => true,
            ),
        );
    }
}

class WC_Dental_Impressions_Received_Email extends WC_Email
{

    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct()
    {

        $this->id = 'dental_impressions_received';
        $this->customer_email = true;
        $this->title = __('Dental Impressions Received', 'woocommerce');
        $this->description = __('Send an update email to customers dental impressions received.', 'woocommerce');

        $this->template_html = 'emails/dental-impressions-received.php';

        parent::__construct();
        $this->placeholders = array(
            '{site_title}' => $this->get_blogname(),
            '{order_date}' => '',
            '{order_number}' => '',
        );
        $this->manual = true;
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $order_id
     */
    public function trigger($order_id)
    {

        $this->setup_locale();


        $order = wc_get_order($order_id);
        $this->object = $order;
        $this->recipient = $this->object->get_billing_email();
        $this->placeholders['{order_date}'] = \wc_format_datetime($this->object->get_date_created());
        $this->placeholders['{order_number}'] = $this->object->get_order_number();
        $this->placeholders['{fname}'] = ucfirst($this->object->get_shipping_first_name());
        if ($this->get_recipient()) {
            $response = $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());

            if ($response) {
                // Clear the email queue and add an order note
                $note = 'Dental Impressions Received Email Sent to Customer.';
                $order->add_order_note($note);
            }
        }

        $this->restore_locale();
    }

    /**
     * Get email subject.
     *
     * @access public
     * @return string
     */
    public function get_subject()
    {
        $default_subject = __('Notice: Dental Impressions Received', 'woocommerce');
        $subject = $this->get_option('subject', $default_subject);

        return __($this->format_string($subject), 'woocommerce');
    }

    /**
     * Get email heading.
     *
     * @access public
     * @return string
     */
    public function get_heading()
    {
        $default_heading = __('Great news!', 'woocommerce');
        $heading = $this->get_option('heading', $default_heading);

        return __($this->format_string($heading), 'woocommerce');
    }

    /**
     * get_content_html function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_html()
    {
        ob_start();
        woocommerce_get_template($this->template_html, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => false,
            'email' => $this,
        ));
        return ob_get_clean();
    }

    /**
     * get_content_plain function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_plain()
    {
        ob_start();
        woocommerce_get_template($this->template_plain, array(
            'order' => $this->object,
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => true,
            'email' => $this,
        ));
        return ob_get_clean();
    }

    /**
     * Initialize Settings Form Fields
     *
     * @since 2.0
     */
    public function init_form_fields()
    {

        $this->form_fields = array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable this email notification',
                'default' => 'yes'
            ),
            'recipient' => array(
                'title' => 'Recipient(s)',
                'type' => 'text',
                'description' => sprintf('Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', esc_attr(get_option('admin_email'))),
                'placeholder' => '',
                'default' => ''
            ),
            'subject' => array(
                'title' => 'Subject',
                'type' => 'text',
                'description' => sprintf('This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject),
                'placeholder' => '',
                'default' => ''
            ),
            'heading' => array(
                'title' => 'Email Heading',
                'type' => 'text',
                'description' => sprintf(__('This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.'), $this->heading),
                'placeholder' => '',
                'default' => ''
            ),
            'email_type' => array(
                'title' => __('Email type', 'woocommerce'),
                'type' => 'select',
                'description' => __('Choose which format of email to send.', 'woocommerce'),
                'default' => 'html',
                'class' => 'email_type wc-enhanced-select',
                'options' => $this->get_email_type_options(),
                'desc_tip' => true,
            ),
        );
    }
}

function wc_RDH_Register_email_sender($original_email_address)
{
    return 'rdhconnect@smilebrilliant.com';
}
class WC_RDH_Register_Email extends WC_Email
{

    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct()
    {

        $this->id = 'rdh_register';
        $this->customer_email = true;
        $this->title = __('RDH Register', 'woocommerce');
        $this->description = __('Send an email to RDH user on sign-up', 'woocommerce');

        $this->template_html = 'emails/rdh-register.php';

        parent::__construct();
        $this->placeholders = array(
            '{site_title}' => $this->get_blogname(),
        );
        $this->manual = true;
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $user_id
     */
    public function trigger($user_id)
    {

        $this->setup_locale();
        $user_info = get_userdata($user_id);
        $user_email = $user_info->user_email;
        $html = '';
        $this->placeholders['{display_name}'] = $user_info->first_name;
        $_POST['RDH_display_name'] = $user_info->first_name;
        $_POST['RDH_login'] = $user_info->user_login;
        $subject = $this->get_subject();
        $headers = array('Content-Type: text/html; charset=UTF-8');
        add_filter('wp_mail_from', 'wc_RDH_Register_email_sender');
        $headers[] = 'From: Smile Brilliant <rdhconnect@smilebrilliant.com>';
        $headers[] = 'Reply-To: Smile Brilliant <rdhconnect@smilebrilliant.com>';
        $headers = implode(PHP_EOL, $headers);
        $response = wp_mail($user_email, $subject, $this->get_content_html(), $headers);

        if ($response) {
            update_user_meta($user_id, 'rdh_register_email', 'sent');
        }
        remove_filter('wp_mail_from', 'wc_RDH_Register_email_sender');

        $this->restore_locale();
    }

    /**
     * Get email subject.
     *
     * @access public
     * @return string
     */
    public function get_subject()
    {
        $default_subject = __('You’re in! Welcome to RDH Connect {display_name}', 'woocommerce');
        $subject = $this->get_option('subject', $default_subject);

        return __($this->format_string($subject), 'woocommerce');
    }

    /**
     * Get email heading.
     *
     * @access public
     * @return string
     */
    public function get_heading()
    {
        $default_heading = __('You’re in! Welcome to RDH Connect {display_name}', 'woocommerce');
        $heading = $this->get_option('heading', $default_heading);

        return __($this->format_string($heading), 'woocommerce');
    }

    /**
     * get_content_html function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_html()
    {
        ob_start();
        woocommerce_get_template($this->template_html);
        return ob_get_clean();
    }

    /**
     * get_content_plain function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_plain()
    {
        ob_start();
        woocommerce_get_template($this->template_plain, array(
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => true,
            'email' => $this,
        ));
        return ob_get_clean();
    }

    /**
     * Initialize Settings Form Fields
     *
     * @since 2.0
     */
    public function init_form_fields()
    {

        $this->form_fields = array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable this email notification',
                'default' => 'yes'
            ),
            'subject' => array(
                'title' => 'Subject',
                'type' => 'text',
                'description' => sprintf('This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject),
                'placeholder' => '',
                'default' => ''
            ),
            'heading' => array(
                'title' => 'Email Heading',
                'type' => 'text',
                'description' => sprintf(__('This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.'), $this->heading),
                'placeholder' => '',
                'default' => ''
            ),
        );
    }
}


class RDH_Contact_Email extends WC_Email
{

    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct()
    {

        $this->id = 'rdh_contact';
        $this->customer_email = true;
        $this->title = __('RDH Contact', 'woocommerce');
        $this->description = __('Send an email to RDH user on contact query', 'woocommerce');

        $this->template_html = 'emails/rdh-contact.php';

        parent::__construct();
        $this->placeholders = array(
            '{site_title}' => $this->get_blogname(),
        );
        $this->manual = true;
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $user_id
     */
    public function trigger($user_id)
    {

        $this->setup_locale();
        $rdh_info = get_userdata($user_id);
        $rdh_email = $rdh_info->user_email;

        $username = $_REQUEST['user-name'];
        $user_email = $_REQUEST['user-email'];
        $_REQUEST['rdh-name']  = $rdh_info->first_name . ' ' . $rdh_info->last_name;

        //$rdh_email = 'abdullah@mindblazetech.com';
        $subject = $this->get_subject();
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $headers[] = 'From: Smile Brilliant <rdhconnect@smilebrilliant.com>';
        $headers[] = 'Reply-To: ' . $username . ' <' . $user_email . '>';
        $headers[] = 'Bcc: amirshah@smilebrilliant.com';
        $headers = implode(PHP_EOL, $headers);
        $response = wp_mail($rdh_email, $subject, $this->get_content_html(), $headers);
        $this->restore_locale();
    }

    /**
     * Get email subject.
     *
     * @access public
     * @return string
     */
    public function get_subject()
    {
        $default_subject = __('New Contact Query', 'woocommerce');
        $subject = $this->get_option('subject', $default_subject);

        return __($this->format_string($subject), 'woocommerce');
    }

    /**
     * Get email heading.
     *
     * @access public
     * @return string
     */
    public function get_heading()
    {
        $default_heading = __('New Contact Query', 'woocommerce');
        $heading = $this->get_option('heading', $default_heading);

        return __($this->format_string($heading), 'woocommerce');
    }

    /**
     * get_content_html function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_html()
    {
        ob_start();
        woocommerce_get_template($this->template_html);
        return ob_get_clean();
    }

    /**
     * get_content_plain function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_plain()
    {
        ob_start();
        woocommerce_get_template($this->template_plain, array(
            'email_heading' => $this->get_heading(),
            'sent_to_admin' => false,
            'plain_text' => true,
            'email' => $this,
        ));
        return ob_get_clean();
    }

    /**
     * Initialize Settings Form Fields
     *
     * @since 2.0
     */
    public function init_form_fields()
    {

        $this->form_fields = array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable this email notification',
                'default' => 'yes'
            ),
            'subject' => array(
                'title' => 'Subject',
                'type' => 'text',
                'description' => sprintf('This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject),
                'placeholder' => '',
                'default' => ''
            ),
            'heading' => array(
                'title' => 'Email Heading',
                'type' => 'text',
                'description' => sprintf(__('This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.'), $this->heading),
                'placeholder' => '',
                'default' => ''
            ),
        );
    }
}



class GEHA_SignUp_Email extends WC_Email
{

    /**
     * Is the password generated?
     *
     * @var bool
     */
    public $password_generated;
    public $first_name;
    public $last_name;
    public $user_email;
    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct()
    {

        $this->id = 'geha_sign_up';
        $this->customer_email = true;
        $this->title = __('GEHA Member Benefits Confirmation', 'woocommerce');
        $this->description = __('Send an email to GEHA customer on Sign Up', 'woocommerce');

        $this->template_html = 'emails/geha-sign-up.php';

        parent::__construct();
        $this->placeholders = array(
            '{site_title}' => $this->get_blogname(),
        );
        $this->manual = true;
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $user_id
     */
    public function trigger($user_id, $user_pass)
    {

        $this->setup_locale();
        $user_info = get_userdata($user_id);
        $user_email = $user_info->user_email;
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;

        $this->password_generated = $user_pass;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->user_email = $user_email;
        $subject = 'GEHA Member Benefits Confirmation (' . ucfirst($last_name) . ' ' . $first_name . ')';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        //$headers[] = 'From: Smile Brilliant <rdhconnect@smilebrilliant.com>';
        $headers[] = 'Reply-To: ' . ucfirst($first_name) . ' ' . $last_name . ' <' . $user_email . '>';
        //$headers[] = 'Bcc: ejaz@mindblazetech.com';
        $headers = implode(PHP_EOL, $headers);
        $response = wp_mail($user_email, $subject, $this->get_content_html(), $headers);
        $this->restore_locale();
    }



    /**
     * get_content_html function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_html()
    {

        return wc_get_template_html(
            $this->template_html,
            array(
                'password' => $this->password_generated,
                'user_email' => $this->user_email,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'gehaUrl' => $url = home_url("/checkout-geha/$this->user_email/1/?utm_campaign=userExists")
            )
        );
    }


    /**
     * Initialize Settings Form Fields
     *
     * @since 2.0
     */
    public function init_form_fields()
    {

        $this->form_fields = array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable this email notification',
                'default' => 'yes'
            )
        );
    }
}



class Insurance_SignUp_Email extends WC_Email
{

    /**
     * Is the password generated?
     *
     * @var bool
     */
    public $password_generated;
    public $first_name;
    public $last_name;
    public $user_email;
    /**
     * Set email defaults
     *
     * @since 0.1
     */
    public function __construct()
    {

        $this->id = 'insurance_sign_up';
        $this->customer_email = true;
        $this->title = __('Insurance Member Benefits Confirmation', 'woocommerce');
        $this->description = __('Send an email to Insurance customer on Sign Up', 'woocommerce');

        $this->template_html = 'emails/insurance-sign-up.php';

        parent::__construct();
        $this->placeholders = array(
            '{site_title}' => $this->get_blogname(),
        );
        $this->manual = true;
    }

    /**
     * Determine if the email should actually be sent and setup email merge variables
     *
     * @since 0.1
     * @param int $user_id
     */
    public function trigger($user_id, $user_pass)
    {

        $this->setup_locale();
        $user_info = get_userdata($user_id);
      //  $user_email = 'abdullah@mindblazetech.com'; // $user_info->user_email;
        $user_email =  $user_info->user_email;
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;

        $this->password_generated = $user_pass;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->user_email = $user_email;
        $subject = 'Insurance Member Benefits Confirmation (' . ucfirst($last_name) . ' ' . $first_name . ')';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        //$headers[] = 'From: Smile Brilliant <rdhconnect@smilebrilliant.com>';
        $headers[] = 'Reply-To: ' . ucfirst($first_name) . ' ' . $last_name . ' <' . $user_email . '>';
        //$headers[] = 'Bcc: ejaz@mindblazetech.com';
        $headers = implode(PHP_EOL, $headers);
        $response = wp_mail($user_email, $subject, $this->get_content_html(), $headers);
        $this->restore_locale();
    }



    /**
     * get_content_html function.
     *
     * @since 0.1
     * @return string
     */
    public function get_content_html()
    {

        return wc_get_template_html(
            $this->template_html,
            array(
                'password' => $this->password_generated,
                'user_email' => $this->user_email,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
            )
        );
    }


    /**
     * Initialize Settings Form Fields
     *
     * @since 2.0
     */
    public function init_form_fields()
    {

        $this->form_fields = array(
            'enabled' => array(
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable this email notification',
                'default' => 'yes'
            )
        );
    }
}
