<?php

// if(isset($_POST['shipping_first_name'])) {
//     echo '<pre>';
//     print_r($_POST);
//     die();
// }

function modify_wc_hooks()
{
    // remove all wc my account's notices wrapper
    remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 5);
}
add_action('init', 'modify_wc_hooks', 99);

add_action('admin_head', function () {
    if (in_array(get_current_user_id(), array(114825, 97000, 123975, 123714, 124081, 124142, 124143))) {
        remove_all_actions('admin_notices');
        remove_all_actions('network_admin_notices');
        remove_all_actions('user_admin_notices');
        remove_all_actions('all_admin_notices');
    }
});


require get_stylesheet_directory() . '/inc/helper-functions.php';
require get_stylesheet_directory() . '/inc/woo-functions.php';
require get_stylesheet_directory() . '/inc/geha.php';
require get_stylesheet_directory() . '/inc/add-order-callback.php';
require get_stylesheet_directory() . '/inc/inc-orders.php';
require get_stylesheet_directory() . '/inc/my-account.php';
require get_stylesheet_directory() . '/inc/my-account-tabs.php';
require get_stylesheet_directory() . '/inc/my-account-nest.php';
require get_stylesheet_directory() . '/inc/customization-mbt.php';



add_action('wp_enqueue_scripts', 'myaccount_remove_style', PHP_INT_MAX);

function myaccount_remove_style()
{
    if (is_account_page() && is_user_logged_in()) {
        // wp_dequeue_style('thb-app');
        wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css');
        wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js');
        wp_enqueue_style('dashboardStyles', get_stylesheet_directory_uri() . '/assets/css/dashboardStyles.css', '', time());
    }
    // if(is_page('affiliate-area')){
    //     wp_enqueue_style('dashboardStyles', get_stylesheet_directory_uri() . '/assets/css/dashboardStyles.css');
    // }

    if (is_checkout()) {
        wp_deregister_script('flexslider');
    }
}




function modify_jquery()
{
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://code.jquery.com/jquery-1.11.3.min.js');
        wp_enqueue_script('jquery');
    }
}

function affiliate_area_body_class($classes)
{
    if (is_page('affiliate-area')) {
        $classes[] = 'affiliate-area-body';
    }
    return $classes;
}

add_filter('body_class', 'affiliate_area_body_class');

function mbt_enqueue_custom_admin_script()
{
    //  wp_register_style( 'custom_wp_admin_js', get_template_directory_uri() . '/assets/js/admin-customjs.js', array('jquery'), false,'all');
    wp_enqueue_script('custom_wp_admin_js', get_stylesheet_directory_uri() . '/assets/js/admin-customjs.js', array('jquery'), false, true);
    //wp_enqueue_style( 'custom_wp_admin_js' );
}

add_action('admin_enqueue_scripts', 'mbt_enqueue_custom_admin_script', 100);
add_action('init', 'modify_jquery');

add_action('wp_ajax_save_customer_info_checkout', 'save_customer_info_checkout');
add_action('wp_ajax_nopriv_save_customer_info_checkout', 'save_customer_info_checkout');

function save_customer_info_checkout()
{
    $customer_info = $_POST;
    array_map('utf8_encode', $customer_info);
    if (!session_id()) {
        session_start();
    }
    $_SESSION['customer_info_new1'] = $customer_info;
    die();
}

function shipmentOnListingView()
{
    if ((isset($_REQUEST['action']) && $_REQUEST['action'] == 'woocommerce_mark_order_status') && (isset($_REQUEST['action']) && $_REQUEST['action'] == 'woocommerce_mark_order_status') && isset($_REQUEST['action'])) {
        $orderId = $_REQUEST['order_id'];
        $order = wc_get_order($orderId);
        $shipmentAction = true;
        foreach ($order->get_items() as $item_id => $item) {

            if (wc_cp_get_composited_order_item_container($item, $order)) {
                /* Composite Prdoucts Child Items */
            } else if (wc_cp_is_composite_container_order_item($item)) {
                /* Composite Prdoucts Parent Item */
                $product_id = $item->get_product_id();
                if (get_post_meta($product_id, 'three_way_ship_product', true) == 'yes') {
                    $shipmentAction = false;
                }
            }
        }
        if ($shipmentAction) {
            batch_printing_send_request(array($orderId));
        } else {
            // https://dev.smilebrilliant.com/wp-admin/post.php?post=428340&action=edit
            $redUrl = admin_url('post.php?post=' . $orderId . '&action=edit'); // get_edit_post_link($orderId);
            wp_redirect($redUrl);
            die;
        }
    }
}

//add_action('init', 'shipmentOnListingView');

function create_order_style_mbt()
{
?>
    <style>
        .flex-row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-flow: wrap;
            flex-flow: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-sm-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-sm-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-sm-4 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }


        .col-sm-6,
        .col-sm-4,
        .col-sm-3 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        select#wc-authorize-net-cim-credit-card-expiry-month {
            width: 100%;
            max-width: 100% !important;
        }

        .ustom-shipping-address .form-group {
            margin-top: 1rem;
        }

        #smile_brillaint_addNewOrder input[type="text"],
        #smile_brillaint_addNewOrder input[type="tel"],
        #smile_brillaint_addNewOrder input[type="number"],
        #smile_brillaint_addNewOrder input[type="email"],
        #smile_brillaint_addNewOrder input[type="password"],
        #smile_brillaint_addNewOrder select,
        #smile_brillaint_addNewOrder textarea {
            border: 1px solid rgba(0, 0, 0, 0.07);
            padding: 15px 20px;
            margin-bottom: 27px;
            color: #343434;
            font-size: 14px;
            font-weight: 400;
            max-width: 100%;
            outline: 0;
            font-family: inherit;
            border-radius: 3px;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            border: 1px solid #d7d7d7;
            height: 36px;
            padding: 6px 16px;
            line-height: 16px;
            border-radius: 0;
            margin-bottom: 0px;
            width: 100%;
            border-radius: 4px;
        }

        #smile_brillaint_addNewOrder textarea {
            height: 72px;
        }

        #smile_brillaint_addNewOrder label {
            margin-top: 6px;
            display: block;
            margin-bottom: 5px;
        }

        #smile_brillaint_addNewOrder #addOn-modal-footer_cc {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            margin-top: 25px;
        }

        #smile_brillaint_addNewOrder #addOn-modal-footer_cc .addOn-modal-footer_create {
            margin-left: 10px;
        }

        #smile_brillaint_addNewOrder #addOn-modal-footer_cc .ready-toship label {
            font-weight: 600;
        }


        div#smile_brillaint_addNewOrder {
            padding-right: 15px;
            padding-left: 0px;
        }


        div#smile_brillaint_addNewOrder form#addOn_addPaymentProfile_form {
            max-width: 1065px;
        }

        div#smile_brillaint_addNewOrder p {
            margin: 0em 0;
        }

        div#smile_brillaint_addNewOrder .select2-container .select2-selection--single {
            height: 36px;
            padding-top: 3px;
            border: 1px solid #d7d7d7;
        }

        div#smile_brillaint_addNewOrder table#addon-table {
            border: 1px solid #d7d7d7;
            margin-top: 15px;
            border-bottom: 0;
        }

        div#smile_brillaint_addNewOrder td {
            border-bottom: 1px solid #d7d7d7;
            vertical-align: baseline;
        }

        div#smile_brillaint_addNewOrder #addon_summery tr:last-child td {
            border-bottom: 0px solid #d7d7d7;
        }

        div#smile_brillaint_addNewOrder .order-notes-section {
            margin-top: 15px;
        }

        div#smile_brillaint_addNewOrder table#addon-table td:last-child,
        div#smile_brillaint_addNewOrder table#addon-table thead th:last-child {
            text-align: center;
        }

        div#smile_brillaint_addNewOrder input#addOnShippingCostAmount,
        div#smile_brillaint_addNewOrder input#addOnTotalAmount {
            max-width: 175px !important;
        }

        div#smile_brillaint_addNewOrder th {
            font-weight: bold;
        }

        div#smile_brillaint_addNewOrder a.remove_field {
            color: #7b7b7b;
            height: 22px;
            display: inline-block;
            width: 22px;
            border: 1px solid #d7d7d7;
            border-radius: 30px;
            background: #fff;
            line-height: 1.5;
        }

        #addon_summery table.widefat {
            border: 1px solid #d7d7d7;
        }

        div#smile_brillaint_addNewOrder table#addon-table tr td:first-child {
            width: 525px;
        }

        h2,
        #customerOrderInformation h3,
        #customerOrderInformation h4 {
            font-size: 2.3em;
        }

        * {
            box-sizing: border-box;
        }

        div#smile_brillaint_addNewOrder table#addon-table tbody tr td {
            background: #e4e2e2;
            border-bottom: 1px solid #ffffff;
        }

        div#smile_brillaint_addNewOrder table#addon-table tbody tr:last-child td {
            border-bottom: 0px solid #ffffff;
        }

        div#smile_brillaint_addNewOrder table#addon-table input[type="text"],
        div#smile_brillaint_addNewOrder table#addon-table input[type="number"] {
            margin-bottom: 0;
        }

        div#smile_brillaint_addNewOrder .ready-toship {
            margin-bottom: 20px;
        }

        #customerOrderInformation table tbody tr:nth-child(odd) td {
            background: #e4e2e2;
        }

        #customerOrderInformation table tbody tr:nth-child(even) td {}

        #customerOrderInformation div#is_billing_address_changed_tbody {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #d7d7d7;
        }

        div#smile_brillaint_addNewOrder div#addon_summery tr td:first-child {
            width: 525px;
        }

        div#smile_brillaint_addNewOrder fieldset#wc-authorize-net-cim-credit-card-credit-card-form {
            max-width: 700px;
            border: 1px solid #d7d7d7;
            padding: 15px;
            background: #e4e2e29e;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        div#smile_brillaint_addNewOrder button#add_addon_product_btn {
            margin-left: 15px;
            margin-top: 15px;
        }

        #addOn_order_form button#apply_a_coupon_create_order {
            margin-top: 10px;
        }

        div#smile_brillaint_addNewOrder button#add_addon_product_btn {
            margin-top: 10px;
        }

        #newOrder_ajax_response {
            margin-top: 15px;
        }

        .wrapper.open {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            background: #fff;
            z-index: 999;
        }

        .popup a.close {
            position: absolute;
            top: 17%;
            right: 25%;
            z-index: 999;
            font-size: 18px;
            background: #fff;
            width: 30px;
            height: 30px;
            text-align: center;
            border-radius: 30px;
            border: 1px solid #ccc;
            color: #333;
            text-decoration: none;
            line-height: 1.5;
        }

        div#smile_brillaint_addNewOrder .select2-container {
            width: 100% !important;
        }

        .loading-element {
            width: 100%;
            height: 100%;
            z-index: 9999;
            position: absolute;
            background-color: #eaeaeaea;
            padding: 10%;
            text-align: center;
        }

        .loading-element .spinner.is-active {
            text-align: center;
            float: none;
        }

        .hass-error {
            border: 1px solid red !important;
        }
    </style>
    <script>
        var shipping_first_name = '';
        var shipping_last_name = '';
        var shipping_first_name = '';
        var shipping_phone = '';
        var shipping_city = '';
        var shipping_state = '';
        var shipping_postcode = '';
        var shipping_country = '';
        var shipping_address_1 = '';
        jQuery(document).find("#copyBillingAddress").on("click", function() {


            if (this.checked) {

                shipping_first_name = jQuery('input[name=shipping_first_name]').val();
                shipping_last_name = jQuery('input[name=shipping_last_name]').val();
                shipping_phone = jQuery('input[name=shipping_phone]').val();
                shipping_city = jQuery('input[name=shipping_city]').val();
                shipping_state = jQuery('input[name=shipping_state]').val();
                shipping_zipcode = jQuery('input[name=shipping_zipcode]').val();
                shipping_country = jQuery('input[select=shipping_country]').val();
                shipping_address_1 = jQuery('textarea[select=shipping_address_1]').val();
                jQuery('input[name=shipping_first_name]').val(jQuery('input[name=billing_first_name]').val());
                jQuery('input[name=shipping_last_name]').val(jQuery('input[name=billing_last_name]').val());
                jQuery('input[name=shipping_phone]').val(jQuery('input[name=billing_phone]').val());
                jQuery('input[name=shipping_city]').val(jQuery('input[name=billing_city]').val());
                jQuery('input[name=shipping_state]').val(jQuery('input[name=billing_state]').val());
                jQuery('input[name=shipping_postcode]').val(jQuery('input[name=billing_postcode]').val());
                jQuery('select[name=shipping_country]').val(jQuery('select[name=billing_country]').val());
                jQuery('select[name=shipping_address_1]').val(jQuery('select[name=billing_address_1]').val());

            } else {
                // alert(shipping_first_name);
                jQuery('input[name=shipping_first_name]').val(shipping_first_name);
                jQuery('input[name=shipping_last_name]').val(shipping_last_name);
                jQuery('input[name=shipping_phone]').val(shipping_phone);
                jQuery('input[name=shipping_city]').val(shipping_city);
                jQuery('input[name=shipping_state]').val(shipping_state);
                jQuery('input[name=shipping_postcode]').val(shipping_postcode);
                jQuery('select[name=shipping_country]').val(shipping_country);
                jQuery('select[name=shipping_address_1]').val(shipping_address_1);
            }
        });
    </script>
    <?php

}

add_action('wp_ajax_sbr_articles', 'sbr_articles_callback');
add_action('wp_ajax_nopriv_sbr_articles', 'sbr_articles_callback');

function sbr_articles_callback($type = 'listing', $cat = 0, $user_id = '')
{
    $fragments  = array();
    if (isset($_REQUEST['type'])) {
        $type = $_REQUEST['type'];
    }
    if (isset($_REQUEST['cat'])) {
        $cat = $_REQUEST['cat'];
    }

    $paged = isset($_REQUEST['page']) ? $_REQUEST['page']  : 1;
    $tag = isset($_REQUEST['tag']) ? $_REQUEST['tag']  : 0;


    $args = array(
        'post_type' => 'post',
        'ignore_sticky_posts' => 1,
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'paged'               => $paged,
    );
    if ($user_id != '') {
        $args['author'] = $user_id;
    }
    if ($type == 'feature') {
        $args['meta_query']   = array(
            'relation' => 'OR',
            array(
                'key'       => 'feature_article',
                'value'     => 1,
                'compare'   => '=',
            )
        );
    } else if ($type == 'listing') {

        $args['tax_query']   = array();
        if ($cat) {
            $args['tax_query'][]   = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $cat,

            );
        } else {
            $args['meta_query']   = array(
                'relation' => 'OR',
                array(
                    'key'       => 'feature_article',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key'       => 'feature_article',
                    'value'     => 1,
                    'compare'   => '!=',
                )
            );
        }
        if ($tag) {
            $args['tax_query'][]   = array(
                'taxonomy' => 'post_tag',
                'field'    => 'slug',
                'terms'    => $tag,

            );
        }
    }
    $article222 = 0;
    if ($user_id != '') {
        $args2 = array(
            'post_type' => 'post',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => 6,
            'post_status' => 'publish',
            'paged'               => $paged,
        );

        if ($type == 'feature') {
            $args2['meta_query']   = array(
                'relation' => 'OR',
                array(
                    'key'       => 'feature_article',
                    'value'     => 1,
                    'compare'   => '=',
                )
            );
        } else if ($type == 'listing') {

            $args2['tax_query']   = array();
            if ($cat) {
                $args2['tax_query'][]   = array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $cat,

                );
            } else {
                $args2['meta_query']   = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'co_author', // replace with your repeater field name
                        'value' => $user_id, // replace with the user ID you want to search for
                        'compare' => 'LIKE',

                    )
                );
            }
            if ($tag) {
                $args2['tax_query'][]   = array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'slug',
                    'terms'    => $tag,

                );
            }
        }
        $article222 = new WP_Query($args2);
    }

    $article = new WP_Query($args);

    /// $merged_posts_array = array_merge($article, $article222);
    ob_start();
    if (($paged + 1) <= $article->max_num_pages) {
    ?>
        <div class="button-wrapper">
            <div class="loadmore">
                <a href="javascript:;" onclick="sbr_articles('<?php echo $type; ?>' , <?php echo ($paged + 1); ?> )">Load More</a>
            </div>
        </div>
        <?php
    }

    $fragments['load_more'] = ob_get_clean();
    ob_start();
    if ($article->have_posts()) :

        while ($article->have_posts()) : $article->the_post(); ?>
            <div class="card">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) {
                        $feat_image = wp_get_attachment_url(get_post_thumbnail_id());
                        echo '<div class="card-img">';
                        echo '<img src="' . $feat_image . '">';
                        echo '</div>';
                    } else {
                        echo '<div class="card-img">';
                        echo '<img src="https://www.smilebrilliant.com/wp-content/uploads/2021/09/smilebrilliant-teeth-whitening-share.jpg">';
                        echo '</div>';
                    }
                    $postCategories = array();
                    if ($cat) {
                        $postCategories[] = get_term($cat)->name;
                    }
                    foreach ((get_the_category(get_the_ID())) as $cate) {
                        if ($cat == $cate->term_id) {
                            continue;
                        }
                        $postCategories[] = $cate->name;
                    }
                    ?>
                    <div class="card-details">
                        <div class="">
                            <small><?php echo implode(", ", $postCategories); ?></small>
                        </div>
                        <div class="card-title">
                            <h2><?php the_title(); ?></h2>
                        </div>

                        <div class="description">
                            <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                            <?php $rdhTitle = get_field('rdh_titleline', 'user_' . get_the_author_meta('ID')); ?>
                            <?php
                            $rdhTitle = get_field('rdh_titleline', 'user_' . get_the_author_meta('ID'));
                            if ($rdhTitle) {
                                $rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
                            }
                            ?>
                            <p class="author">By: <?php echo get_the_author_meta('display_name') . $rdhTitle; ?>
                                <?php

                                if (get_field('co_author')) :
                                    foreach (get_field('co_author') as $co_author) {
                                        echo '<span class="co-author">';
                                        $rdhTitleCo = get_field('rdh_titleline', 'user_' . $co_author);
                                        if ($rdhTitleCo) {
                                            $rdhTitleCo = ',<span>&nbsp;' . $rdhTitleCo . '</span>';
                                        }
                                        echo get_the_author_meta('display_name', $co_author) . $rdhTitleCo;
                                        echo '</span>';
                                    }
                                endif;
                                ?>
                            </p>
                            <button class="readmore">READ MORE</button>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile;
    else :
        echo '<div class="no-article"><h6>No Article found</h6></div>';
    endif;
    wp_reset_query();
    $fragments_articles = ob_get_clean();
    if ($user_id != '') {
        ob_start();
        if ($article222->have_posts()) :

            while ($article222->have_posts()) : $article222->the_post(); ?>
                <div class="card">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) {
                            $feat_image = wp_get_attachment_url(get_post_thumbnail_id());
                            echo '<div class="card-img">';
                            echo '<img src="' . $feat_image . '">';
                            echo '</div>';
                        } else {
                            echo '<div class="card-img">';
                            echo '<img src="https://www.smilebrilliant.com/wp-content/uploads/2021/09/smilebrilliant-teeth-whitening-share.jpg">';
                            echo '</div>';
                        }
                        $postCategories = array();
                        if ($cat) {
                            $postCategories[] = get_term($cat)->name;
                        }
                        foreach ((get_the_category(get_the_ID())) as $cate) {
                            if ($cat == $cate->term_id) {
                                continue;
                            }
                            $postCategories[] = $cate->name;
                        }
                        ?>
                        <div class="card-details">
                            <div class="">
                                <small><?php echo implode(", ", $postCategories); ?></small>
                            </div>
                            <div class="card-title">
                                <h2><?php the_title(); ?></h2>
                            </div>

                            <div class="description">
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <?php $rdhTitle = get_field('rdh_titleline', 'user_' . get_the_author_meta('ID')); ?>
                                <?php
                                $rdhTitle = get_field('rdh_titleline', 'user_' . get_the_author_meta('ID'));
                                if ($rdhTitle) {
                                    $rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
                                }
                                ?>
                                <p class="author">By: <?php echo get_the_author_meta('display_name') . $rdhTitle; ?>
                                    <?php

                                    if (get_field('co_author')) :
                                        foreach (get_field('co_author') as $co_author) {
                                            echo '<span class="co-author">';
                                            $rdhTitleCo = get_field('rdh_titleline', 'user_' . $co_author);
                                            if ($rdhTitleCo) {
                                                $rdhTitleCo = ',<span>&nbsp;' . $rdhTitleCo . '</span>';
                                            }
                                            echo get_the_author_meta('display_name', $co_author) . $rdhTitleCo;
                                            echo '</span>';
                                        }
                                    endif;
                                    ?>
                                </p>
                                <button class="readmore">READ MORE</button>
                            </div>
                        </div>
                    </a>
                </div>
<?php endwhile;
        else :
            echo '<div class="no-article"><h6>No Article found</h6></div>';
        endif;
        wp_reset_query();
        $fragments_articless = ob_get_clean();
        $fragments_articles .= $fragments_articless;
    }
    $fragments['articles'] = $fragments_articles;

    if (isset($_REQUEST['action'])) {
        echo  json_encode($fragments);
        die;
    } else {
        return $fragments;
    }
}

add_action('wp_ajax_nopriv_validateUniqueAccount', 'validateUniqueAccount_callback');
add_action('wp_ajax_validateUniqueAccount', 'validateUniqueAccount_callback');
function validateUniqueAccount_callback()
{

    $result = true;
    $value = $_POST['value'];
    $type = $_POST['type'];
    if ($type == 'email') {
        if (is_email($value)) {
            if (email_exists($value)) {
                $result = false;
            }
        }
    } else {
        $validatee = true;
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $userename = $current_user->user_nicename;
            if ($value == $userename) {
                $validatee = false;
            }
        }
        if ($validatee) {
            if (validate_username($value)) {
                if (username_exists($value)) {
                    $result = false;
                }
            }
        }
    }
    echo json_encode($result);
    die;
}

add_action('wp_head', 'flush_if_page_is_geha');
function flush_if_page_is_geha()
{

    $post_idd =  get_the_ID();
    //    echo get_the_permalink(403946);
    //    die();
    if ($post_idd == 403946 || $post_idd == '403946') {
        if (function_exists('w3tc_flush_url')) {
            //die('ddd');
            w3tc_flush_url(get_the_permalink($post_idd));
        }
    }
}

function calculate_return_rate()
{
    global $wpdb;
    $sql_electric_brushes = "SELECT DISTINCT(wp_postmeta.meta_value) FROM wp_posts 
    INNER JOIN wp_postmeta ON wp_posts.ID=wp_postmeta.post_id 
    INNER JOIN wp_woocommerce_order_items ON wp_posts.ID=wp_woocommerce_order_items.order_id 
    WHERE post_type='shop_order'
    AND post_date BETWEEN '2022-03-29' AND '2023-03-29'
    AND wp_woocommerce_order_items.order_item_type='line_item' 
    AND wp_woocommerce_order_items.order_item_name 
    IN('GEHA Member Exclusive: cariPRO Electric toothbrush with 2 replacement brush heads. (regularly $119)','Deluxe Package: cariPRO Ultrasonic Electric toothbrush with 4 replacement brush heads','Individual Package: cariPRO Electric toothbrush with 2 replacement brush heads','Couples Package: 2 cariPRO Ultrasonic Electric toothbrushes with 4 replacement brush heads') 
    AND wp_postmeta.meta_key ='_billing_email'";
    $results1 = $wpdb->get_col($sql_electric_brushes);
    $emails_arr = array();
    foreach ($results1 as $res) {
        $emails_arr[] = '"' . $res . '"';
    }
    echo 'total emials are' . count($emails_arr) . '=>' . count($results1);

    $sql_brush_heads = "SELECT DISTINCT(wp_posts.ID) FROM wp_posts 
    INNER JOIN wp_postmeta ON wp_posts.ID=wp_postmeta.post_id 
    INNER JOIN wp_woocommerce_order_items ON wp_posts.ID=wp_woocommerce_order_items.order_id 
    WHERE post_type='shop_order'
    AND post_date BETWEEN '2022-03-29' AND '2023-03-29'
    AND wp_woocommerce_order_items.order_item_type='line_item' 
    AND wp_woocommerce_order_items.order_item_name 
    IN('8 cariPRO replacement brush heads','4 cariPRO replacement brush heads','2 cariPRO replacement brush heads') 
    AND wp_postmeta.meta_key ='_billing_email' AND wp_postmeta.meta_value  IN (" . implode(',', $emails_arr) . ")";
    $results2 = $wpdb->get_results($sql_brush_heads);
    echo 'total results in range are 2 ';
    echo count($results2);
    echo '<br />';
}

add_action('template_redirect', 'calculate_reates_func');
function calculate_reates_func()
{
    if (isset($_GET['creport'])) {
        // Call the function to calculate the return rate and output the result
        $return_rate = calculate_return_rate();
        die();
    }
}


function disable_yoast_title_for_rdh($title_parts)
{
    if (
        strpos($_SERVER['REQUEST_URI'], '/rdh/products') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/rdh/profile') !== false ||
        strpos($_SERVER['REQUEST_URI'], '/rdh/contact') !== false
    ) {
        $title_parts['site'] = "";
    }
    return $title_parts;
}
add_filter('document_title_parts', 'disable_yoast_title_for_rdh');

if (!function_exists('wfocu_offer_product_types_allow_composite')) {

    add_filter('wfocu_offer_product_types', 'wfocu_offer_product_types_allow_composite', 10, 1);

    function wfocu_offer_product_types_allow_composite()
    {

        return array(
            'simple',
            'variable',
            'variation',
            'composite',
        );
    }
}

/*********************************DarkStar Add To Cart**************************************************** */
// Add To cart
add_action('wp_ajax_custom_add_to_cart', 'custom_ajax_add_to_cart');
add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_ajax_add_to_cart');

function custom_ajax_add_to_cart() {

    // Check if the product ID and quantity are set in the POST request
    if (isset($_POST['product_id']) && $_POST['product_id']!='') {
       
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
        $cart = WC()->cart->get_cart();
        $product_id = intval($_POST['product_id']);
        // Check if the product is already in the cart
        $in_cart = false;
        foreach (WC()->cart->get_cart() as $cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                $in_cart = true;
                $cart_item_key = $cart_item['key'];
                break;
            }
        }
        if ($in_cart) {
            $existing_quantity = WC()->cart->get_cart()[$cart_item_key]['quantity'];
         
            $new_quantity = $existing_quantity + $quantity;
    
            // Update the quantity of the existing cart item
            WC()->cart->set_quantity($cart_item_key, $new_quantity);
        }
        else {
            // echo 'not found';
            // die();
            $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        // Add the product to the cart
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
        }
        
        if ($cart_item_key) {
            // Get updated cart totals and items
            $cart_totals = WC()->cart->get_totals();
            $cart_items = WC()->cart->get_cart();
            $cart_items = WC()->cart->get_cart();

foreach ($cart_items as $cart_item_key => $cart_item) {
    // Get the product ID
    $product_id = $cart_item['product_id'];

    // Get the product feature image URL
    $product_feature_image_url = get_the_post_thumbnail_url($product_id, 'medium');

    // Add the product feature image URL to the cart item
    $cart_items[$cart_item_key]['product_feature_image_url'] = $product_feature_image_url;
}

// Now $cart_items includes the product feature image URL for each item in the cart


            // Prepare cart object to return in the response
            $cart_object = array(
                'cart_totals' => $cart_totals,
                'cart_items' => $cart_items,
                'cart_totals' => $cart_totals,
            );
            $cart_object['cart_totals']['coupons'] = WC()->cart->get_applied_coupons();
            // Return the cart object in the AJAX response
            wp_send_json_success($cart_object);
        } else {
            // If adding to cart failed
            wp_send_json_error('Failed to add product to cart.');
        }
    } else {
        // If product ID or quantity is not set in the request
        wp_send_json_error('Invalid request.');
    }
}

// Get Cart
add_action('wp_ajax_custom_get_cart_mbt', 'custom_get_cart_mbt');
add_action('wp_ajax_nopriv_custom_get_cart_mbt', 'custom_get_cart_mbt');
function custom_get_cart_mbt() {
    $cart_totals = WC()->cart->get_totals();
               $cart_items = WC()->cart->get_cart();
               foreach ($cart_items as $cart_item_key => $cart_item) {
                // Get the product ID
                $product_id = $cart_item['product_id'];
            
                // Get the product feature image URL
                $product_feature_image_url = get_the_post_thumbnail_url($product_id, 'medium');
            
                // Add the product feature image URL to the cart item
                $cart_items[$cart_item_key]['product_feature_image_url'] = $product_feature_image_url;
            }

               // Prepare cart object to return in the response
               $cart_object = array(
                       'cart_totals' => $cart_totals,
                       'cart_items' => $cart_items,
               );
               $cart_object['cart_totals']['coupons'] = WC()->cart->get_applied_coupons();
               // Return the cart object in the AJAX response
               wp_send_json_success($cart_object);
}
// Remove Cart
add_action('wp_ajax_custom_remove_from_cart', 'custom_ajax_remove_from_cart');
add_action('wp_ajax_nopriv_custom_remove_from_cart', 'custom_ajax_remove_from_cart');
function custom_ajax_remove_from_cart() {
    if (isset($_POST['product_key']) && $_POST['product_key'] != '') {
        // $product_key = apply_filters('woocommerce_remove_cart_product_key', absint($_POST['product_key']));
      
        $product_key = $_POST['product_key'];
       

            
            $cart_item_key = WC()->cart->find_product_in_cart($product_key);
  
            if ($cart_item_key) {
                
                WC()->cart->remove_cart_item($cart_item_key);
                
                
                $cart_totals = WC()->cart->get_totals();
                $cart_items = WC()->cart->get_cart();
                foreach ($cart_items as $cart_item_key => $cart_item) {
                    // Get the product ID
                    $product_id = $cart_item['product_id'];
                
                    // Get the product feature image URL
                    $product_feature_image_url = get_the_post_thumbnail_url($product_id, 'medium');
                
                    // Add the product feature image URL to the cart item
                    $cart_items[$cart_item_key]['product_feature_image_url'] = $product_feature_image_url;
                }
    
               
                $cart_object = array(
                    'cart_totals' => $cart_totals,
                    'cart_items'  => $cart_items,
                );
    
                $cart_object['cart_totals']['coupons'] = WC()->cart->get_applied_coupons();
                wp_send_json_success($cart_object);
        }
        else{
            wp_send_json_error('Product not found in the cart.');
        }
    
    } else {
        // If the product ID is not set in the request
        wp_send_json_error('Invalid request.');
    }
}

// Add custom endpoint for retrieving image URL
function custom_get_image_url_endpoint() {
    register_rest_route( 'custom/v1', '/image-url/(?P<id>\d+)/(?P<size>\w+)', array(
        'methods' => 'GET',
        'callback' => 'custom_get_image_url_callback',
        'permission_callback' => '__return_true', // Public access

    ));
}
add_action( 'rest_api_init', 'custom_get_image_url_endpoint' );

// Callback function to retrieve image URL
function custom_get_image_url_callback( $data ) {
    $attachment_id = $data['id'];
    $size = $data['size'];

    // Get image URL based on attachment ID and size
    $image_url = wp_get_attachment_image_src( $attachment_id, $size );

    if ( $image_url ) {
        return $image_url[0]; // Return the URL
    } else {
        return new WP_Error( 'no_image_found', 'No image found with the given parameters', array( 'status' => 404 ) );
    }
}
if(isset($_GET['wfocu-key']) && isset($_GET['wfocu-si'])){
	//die();
	remove_action( 'thb_quick_cart', 'thb_quick_cart',3);
}