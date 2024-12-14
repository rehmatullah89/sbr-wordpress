<?php
/*
 * 
 */

function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
            __('Import/Flush Data', 'sbr'), 'Import/Flush Data', 'manage_options', 'import-flush', 'sbr_add_flush_buttons', 'https://www.smilebrilliant.com/wp-content/uploads/2020/08/favicon-96x96-1.png', 6
    );
}

function sbr_add_flush_buttons() {

    if ('stable.smilebrilliant.com' != $_SERVER[HTTP_HOST]) {
        echo '<h2> Only for Stable</h2>';
        die();
    }
    ?>
    <h2> Import/Flush Data</h2>
    <div class="ajax-ress" style="display:none"><h3>Importing.....</h3></div>
    <div class="loading-sbr"><div class="inner-sbr"></div></div>
    <a href="javascript:void(0)" class="importordersdemo" style="display:block"> Import Orders</a>
    <a href="javascript:void(0)" class="flushordersdemo" style="display:block"> Flush Orders</a>

    <script>
        jQuery(document).on('click', '.importordersdemo', function () {
            jQuery('.ajax-ress').show();
            jQuery('.loading-sbr').show();

            jQuery('.ajax-ress').html('<h3>Importing.....</h3>');
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=create_order_new_structure',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Import Done</h3>');
                    jQuery('.loading-sbr').hide();
                }
            })
        });
        jQuery(document).on('click', '.flushordersdemo', function () {
            jQuery('.ajax-ress').show();
            jQuery('.ajax-ress').html('<h3>Flushing.....</h3>');
            jQuery('.loading-sbr').show();
            jQuery.ajax({
                type: "post",
                async: true,
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                data: 'action=fluash_orders_data_sbr',
                success: function (response) {
                    jQuery('.ajax-ress').html('<h3>Flush Done</h3>');
                    jQuery('.loading-sbr').hide();
                }
            })
        });
    </script>
    <?php
}

//add_action('admin_menu', 'wpdocs_register_my_custom_menu_page');

function fluash_orders_data_sbr() {
    if ('stable.smilebrilliant.com' != $_SERVER[HTTP_HOST]) {
        echo '<h2> Only for Stable</h2>';
        die();
    }
    global $wpdb;

    $wpdb->query("DELETE FROM {$wpdb->prefix}woocommerce_order_itemmeta");
    $wpdb->query("DELETE FROM {$wpdb->prefix}woocommerce_order_items");
    $wpdb->query("DELETE FROM {$wpdb->prefix}comments WHERE comment_type = 'order_note'");
    $wpdb->query("DELETE FROM {$wpdb->prefix}postmeta WHERE post_id IN ( SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'shop_order' )");
    $wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE post_type = 'shop_order'");
    $wpdb->query("DELETE FROM {$wpdb->prefix}woocommerce_order_itemmeta");
    $get_subscribers = get_users('role=subscriber');
    foreach ($get_subscribers as $user) {
        wp_delete_user($user->ID);
    }
}

function get_random_customers_list_mbt() {
    $address_array = array('city' => 'Spearville', 'state' => 'KS', 'phone' => '16203850649', 'country' => 'US', 'zip' => '67876', 'address' => '200 N Main St');
    return $customers_arr = array(
        array(
            'first_name' => 'Abidoon',
            'last_name' => 'Nadeem',
            'email' => 'abidoon@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Asif',
            'last_name' => 'Javaid',
            'email' => 'asifjavaid@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Asif',
            'last_name' => 'Islam',
            'email' => 'asif@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Faisal',
            'last_name' => 'Gondal',
            'email' => 'faisal@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Ishtiaq',
            'last_name' => 'Hussain',
            'email' => 'ishtiaq@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Kamran',
            'last_name' => 'Ashraf',
            'email' => 'kamran@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Muhammad',
            'last_name' => 'Ejaz',
            'email' => 'ejaz@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Muhammad',
            'last_name' => 'Abdullah',
            'email' => 'abdullah@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Noman',
            'last_name' => 'Mustafa',
            'email' => 'noman@mindblazetech.com',
            'address' => $address_array,
        ),
        array(
            'first_name' => 'Sajidoon',
            'last_name' => 'Nadeem',
            'email' => 'sajidoon@mindblazetech.com',
            'address' => $address_array,
        ),
//        array(
//            'first_name' => 'Aprill',
//            'last_name' => 'Coleman',
//            'email' => 'mike@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Carmen',
//            'last_name' => 'Salazar',
//            'email' => 'carmen@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Danyell',
//            'last_name' => 'Apt',
//            'email' => 'danyell@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Marty ',
//            'last_name' => 'Gwozdz',
//            'email' => 'marty@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'michael',
//            'last_name' => 'bush',
//            'email' => 'michael.bush@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Mary Jane',
//            'last_name' => 'Hundley',
//            'email' => 'joel.rahn@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'MICHELLE',
//            'last_name' => 'TUBBY',
//            'email' => 'mackenzie@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Nick',
//            'last_name' => 'Momsen',
//            'email' => 'erica@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Erin',
//            'last_name' => 'Fawl',
//            'email' => 'erin.fawl@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Sarah',
//            'last_name' => 'Czirr',
//            'email' => 'sarah.czirr@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Sandy',
//            'last_name' => 'Carter',
//            'email' => 'abby.carter@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Emma',
//            'last_name' => 'Turnbull',
//            'email' => 'emma.turnbull@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Kenzie',
//            'last_name' => 'Schwartz',
//            'email' => 'kenzie.schwartz@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Delaney',
//            'last_name' => 'ODonnell',
//            'email' => 'delaney.odonnell@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Mitchell',
//            'last_name' => 'Moreno',
//            'email' => 'mitch.moreno@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Pia',
//            'last_name' => 'Roman',
//            'email' => 'amir.shah@smilebrilliant.com ',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Krystalynn',
//            'last_name' => 'Starkloff',
//            'email' => 'krystalynn.starkloff@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Sophia',
//            'last_name' => 'Marre',
//            'email' => 'sophia.marren@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'sally',
//            'last_name' => 'smilebrilliant',
//            'email' => 'sally.compere@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Michael',
//            'last_name' => 'Bluestone',
//            'email' => 'mike@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Paul',
//            'last_name' => 'Saitta',
//            'email' => 'paul@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Tenille ',
//            'last_name' => 'Williams',
//            'email' => 'tenille@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'sara',
//            'last_name' => 'smilebrilliant',
//            'email' => 'sara.diefenbach@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Bryan',
//            'last_name' => 'West',
//            'email' => 'bryan@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Ebony',
//            'last_name' => 'Bass',
//            'email' => 'erin@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Jesssica',
//            'last_name' => 'Twitter',
//            'email' => 'jesssica.dorney@smilebrilliant.com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Ashley',
//            'last_name' => 'Lahue',
//            'email' => 'ashley-lahuesmilebrilliant-com',
//            'address' => $address_array,
//        ),
//        array(
//            'first_name' => 'Marlee',
//            'last_name' => 'smilebrilliant',
//            'email' => 'jessica.dorney@smilebrilliant.com',
//            'address' => $address_array,
//        )
    );
}

function get_random_products_list_mbt() {
    return $products_array = array(427602, 130255, 130256, 427704, 130258, 130259, 130251, 130252, 130253, 130248, 130247, 130246, 130264, 130265, 130263, 130260, 130261, 130267, 428548, 711228, 711227, 711902, 130269, 130270);
}

function create_customer_mbt_sbt($customer) {
    $email = $customer['email'];

    $address = array(
        'first_name' => $customer['first_name'],
        'last_name' => $customer['last_name'],
        'company' => 'Testing, LLC',
        'email' => $customer['email'],
        'phone' => $customer['address']['phone'],
        'address_1' => $customer['address']['address'],
        'address_2' => '',
        'city' => $customer['address']['city'],
        'state' => $customer['address']['state'],
        'postcode' => $customer['address']['zip'],
        'country' => $customer['address']['country']
    );

    $default_password = wp_generate_password();
    $user = get_user_by('login', $email);

    if (!$user = $user->ID)
        $user = wp_create_user($email, $default_password, $email);

    update_user_meta($user, "billing_first_name", $address['first_name']);
    update_user_meta($user, "billing_last_name", $address['last_name']);
    update_user_meta($user, "billing_company", $address['company']);
    update_user_meta($user, "billing_email", $address['email']);
    update_user_meta($user, "billing_address_1", $address['address_1']);
    update_user_meta($user, "billing_address_2", $address['address_2']);
    update_user_meta($user, "billing_city", $address['city']);
    update_user_meta($user, "billing_postcode", $address['postcode']);
    update_user_meta($user, "billing_country", $address['country']);
    update_user_meta($user, "billing_state", $address['state']);
    update_user_meta($user, "billing_phone", $address['phone']);
    update_user_meta($user, "shipping_first_name", $address['first_name']);
    update_user_meta($user, "shipping_last_name", $address['last_name']);
    update_user_meta($user, "shipping_company", $address['company']);
    update_user_meta($user, "shipping_address_1", $address['address_1']);
    update_user_meta($user, "shipping_address_2", $address['address_2']);
    update_user_meta($user, "shipping_city", $address['city']);
    update_user_meta($user, "shipping_postcode", $address['postcode']);
    update_user_meta($user, "shipping_country", $address['country']);
    update_user_meta($user, "shipping_state", $address['state']);
    $geha = rand(0, 1);
    if ($geha) {
        update_user_meta($user, 'geha_user', 'yes');
    }
    return $user;
}

function create_order_new_structure() {
    if ('stable.smilebrilliant.com' != $_SERVER[HTTP_HOST]) {
        echo '<h2> Only for Stable</h2>';
        die();
    }
    for ($i = 0; $i <= 20; $i++) {
        $customer = get_random_customers_list_mbt()[rand(0, 9)];
        $customer_id = create_customer_mbt_sbt($customer);
        $product_id = get_random_products_list_mbt()[rand(0, 23)];
        $product_qty = 1;
        add_demo_data_sbr($customer, $customer_id, $product_id, $product_qty);
    }
    die();
}

add_action('wp_ajax_create_order_new_structure', 'create_order_new_structure');
add_action('wp_ajax_fluash_orders_data_sbr', 'fluash_orders_data_sbr');
if (isset($_POST['create_order_new_structure'])) {
    //add_action('wp_loaded', 'create_order_new_structure');
}
?>