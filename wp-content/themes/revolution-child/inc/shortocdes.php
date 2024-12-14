<?php

function teeth_whitening_trays_func($atts)
{

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

    $variant = 0;
    $variantAttr = '';

    $enable_google_optimize = get_field('enable_service', 'option');
    if ($enable_google_optimize) {
        if ($productType == 'tray-system') {
            $infoData = getOptimizeAttr($productType);
            $variant = $infoData['variant'];
            $variantAttr = $infoData['attr'];
        }
    }
    if (!isset($atts['ajax_query'])) {
        if ($is_non_sensitive) {
            $html .= '<div  id="teeth-whitening_non-sensitive">';
        } else {
            $html .= '<div  id="teeth-whitening_sensitive">';
        }
    }
    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {

            $queryshortcode->the_post();

            $falg_sensitive = true;

            $pid = get_the_id();

            $_product = wc_get_product((int) $pid);

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

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
                $html .= '<div class="heavy-stains-cont"><div class="row">

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

               <div class="col-md-4 product-selection-table-wrap">

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

                if (get_field("pic_4", $pid) != '') {

                    $html .= '<td class="product-selection-table-cell-plus" style="">

                              <div><i class="fa fa-plus"></i></div>

                           </td>';
                }

                if (get_field("pic_4", $pid) != '') {

                    $html .= ' <td class="product-selection-table-cell-2-image">

                              <img src="' . get_field("pic_4", $pid) . '" alt="">

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

                if (get_field("info_4", $pid) != '') {

                    $html .= ' <td colspan="2" class="product-selection-table-cell-2-text" style="border-right:none;">

                              ' . get_field("info_4", $pid) . '

                           </td>';
                }

                $html .= '</tr>

                     </tbody>

                  </table>

               </div>

               <div class="col-md-4 product-selection-price-wrap pos-rel">';

                if ($enable_google_optimize) {
                    $html .= '<div class="price_loading loading"></div>';
                }

                $regularPrice = $_product->get_regular_price();
                $salePrice = $_product->get_sale_price();
                switch ($variant) {
                    case 2:
                        $optimizeVal = '-' . (int) get_post_meta($pid, 'minus_value', true);
                        $regularPrice = $regularPrice + ($optimizeVal);
                        if ($_product->is_on_sale()) {
                            $salePrice = $_product->get_sale_price() + ($optimizeVal);
                        }
                        break;
                    case 1:

                        $optimizeVal = (int) get_post_meta($pid, 'plus_value', true);
                        $regularPrice = $regularPrice + ($optimizeVal);
                        if ($_product->is_on_sale()) {
                            $salePrice = $_product->get_sale_price() + ($optimizeVal);
                        }
                        break;

                    default:
                        # code...
                        break;
                }

                if (get_field("monthly_price", $pid) == '') {

                    $html .= '<div class="product-selection-price-text-wrap">';

                    if ($_product->is_on_sale()) {

                        $html .= '<span class="product-selection-price-text">';
                        $html .= '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>';
                        $html .= $regularPrice;
                        $html .= '</bdi></span></del>';

                        $html .= '<ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>';
                        $html .= $salePrice;
                        $html .= '</bdi></span></ins>';
                        $html .= '</span>';
                    } else {

                        $html .= '<i role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>';
                        $html .= '<span class="product-selection-price-text">' . $regularPrice . '</span>';
                    }
                    /*
                    if ($_product->is_on_sale()) {

                    $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
                    } else {

                    $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                    $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
                    }
                     */
                    $html .= '</div>';
                } else {

                    $html .= '<div class="row row-divided">

                <div class="col-md-6 column-one">';

                    if ($_product->is_on_sale()) {

                        $html .= '<span class="product-selection-price-text">';
                        $html .= '<del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>';
                        $html .= $regularPrice;
                        $html .= '</bdi></span></del>';

                        $html .= '<ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>';
                        $html .= $salePrice;
                        $html .= '</bdi></span></ins>';
                        $html .= '</span>';
                    } else {
                        $html .= '<i role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>';
                        $html .= '<span class="product-selection-price-text">' . $regularPrice . '</span>';
                    }

                    /*
                    if ($_product->is_on_sale()) {

                    $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
                    } else {

                    $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                    $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
                    }
                     */
                    $html .= '<div class="product-price-meta">one-time payment</div>

                </div>

                <div class="vertical-divider hidden-xs hidden-sm" style="font-size: 0.9em;">or</div>

                <hr class="hr-text visible-xs visible-sm" data-content="OR">

                <div class="col-md-6 column-two">

                   <i class="fa fa-dollar product-selection-installment-price-dollar-symbol"></i>';

                    if ($_product->is_on_sale()) {
                        $html .= '<span class="product-selection-installment-price-text">' . ceil($salePrice / AFFIRM_MONTHS) . '</span>';
                    } else {
                        $html .= '<span class="product-selection-installment-price-text">' . ceil($regularPrice / AFFIRM_MONTHS) . '</span>';
                    }
                    /*
                    <span class="product-selection-installment-price-text">' . ceil($_product->get_price() / AFFIRM_MONTHS) . '</span>
                     */
                    $html .= '<span>/mo</span>

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

                /*BOGO Sale Code */
                $bogoProduct = get_post_meta($pid, 'bogo_product_id', true);
                $addedClass = '';
                /*
                if (in_array($bogoProduct, array_column(WC()->cart->get_cart(), 'product_id'))) {
                foreach (WC()->cart->get_cart() as $cartkey => $cart_item) {
                // compatibility with WC +3
                if ($cart_item['data']->get_id() == $bogoProduct && isset($cart_item['bogo_added'])) {
                $addedClass = 'added-to-cart';
                }
                if ($cart_item['data']->get_id() == $bogoProduct && isset($cart_item['bogo_discount'])) {
                $addedClass = 'added-to-cart';
                }
                }
                }
                 */
                $string_bogo = '';
                if (get_post_meta($pid, 'bogo_product_id', true) != '') {
                    // $string_bogo = 'data-bogo_discount=' . get_post_meta($pid, 'bogo_product_id', true) . ' onClick="addClassByClickmbt(this)" ';
                    $string_bogo = 'data-bogo_discount="' . get_post_meta($pid, 'bogo_product_id', true) . '"';
                }

                /**End Bogo */

                if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {

                    $html .= '<a  ' . $variantAttr . '  ' . $string_bogo . ' style="font-size:19px;" href="?add-to-cart=' . $pid . '" data-quantity="1" class=" ' . $addedClass . ' button btn-primary-orange product-selection-price-button product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" data-product_id="' . $pid . '"  ' . $action_string . '>ADD TO CART</a>';
                } else {

                    $html .= '<a style="font-size:19px;" href="javascript:void(0);" data-quantity="1" class="button btn-primary-orange product-selection-price-button product_type_' . $_product->get_type() . ' add_to_cart_button out-of-stock" data-product_id="' . $pid . '"  ' . $action_string . '>OUT OF STOCK</a>';
                }

                $html .= ' </div>

               </div>

            </div> </div>';
            }
        }

        wp_reset_postdata();
    }
    if (!isset($atts['ajax_query'])) {
        $html .= '</div>';
    }

    return $html;
}

add_shortcode('teeth-whitening-trays', 'teeth_whitening_trays_func');

function desensitizing_gel_func($atts)
{

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

                $titlee = get_field("styled_title", $pid);

                if ($titlee == '') {

                    $titlee = get_the_title($pid);
                }

                $html .= '<div class="product-selection-description">

               <b> ' . $titlee . '</b>';

                $html .= get_field("info_2", $pid);

                $html .= '</div>';
            }

            $html .= '<div class="product-selection-price-wrap pro-teeth-whitening-gel"><div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>

               <div class="product-selection-dentist-price-note getone">Avg Dentist Price:  $' . get_field("average_price_value", $pid) . '+</div>';

            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }

            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {
                /*BOGO Sale Code */
                $string_bogo = '';
                if (get_post_meta($pid, 'bogo_product_id', true) != '') {
                    $string_bogo = 'data-bogo_discount="' . get_post_meta($pid, 'bogo_product_id', true) . '"';
                }
                /**End Bogo */
                $html .= ' <button ' . $string_bogo . ' class="btn btn-primary-blue product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= ' <button class="btn btn-primary-blue product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

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

function display_posts_toothbrush($atts)
{

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

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $_product = wc_get_product((int) $pid);

            $html .= '<div class="col-md-4">

         <div class="product-selection-box electric-tooth-brush-prime-day-sale-ribbon-strip">
		  <div class="product-selection-title">

               ' . $titlee . '</div>

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

            $html .= '<div class="product-selection-price-wrap pro-electrci-tooth-brush"><div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>

               <div class="product-selection-dentist-price-note gettwwo">' . get_field("info_2", $pid) . '</div>';

            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>';
        }

        wp_reset_postdata();
    }

    $html .= '</div>';

    return $html;
}

add_shortcode('toothbrush-products', 'display_posts_toothbrush');

function display_posts_toothbrush_heads($atts)
{

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

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $_product = wc_get_product((int) $pid);

            $html .= '<div class="col-md-4">

         <div class="product-selection-box">

		  <div class="product-selection-title">

               ' . $titlee . '</div>

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

            $html .= '<div class="product-selection-price-wrap pro-price-opt-three">

               <div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>

               <div class="product-selection-dentist-price-note getthhre">' . get_field("info_2", $pid) . '</div>';

            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>';
        }

        wp_reset_postdata();
    }

    $html .= '</div>';

    return $html;
}

add_shortcode('toothbrush-heads', 'display_posts_toothbrush_heads');

function display_posts_night_guards_old($atts)
{

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

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

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

            $html .= '<b>' . $titlee . '</b><br><br>

	      <div class="line-divider"></div>';

            if (get_field("info_3", $pid) != '') {

                $html .= '<div class="description-info3">';

                $html .= get_field("info_3", $pid);

                $html .= '</div>';
            }

            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }

            $html .= '<div class="product-selection-price-wrap pro-price-opt-four">

               <div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>

               <div class="product-selection-dentist-price-note getinfo-four">' . get_field("info_4", $pid) . '</div>';

            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>';
        }

        wp_reset_postdata();
    }

    $html .= '</div>';

    return $html;
}
function display_posts_night_guards($atts)
{

    $productType = isset($atts['type']) ? $atts['type'] : '';
    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $productType,
        ),
    ));

    $queryshortcode = new WP_Query($args);

    $html = '';
    $variant = 0;
    $variantAttr = '';

    $enable_google_optimize = get_field('enable_service', 'option');
    if ($enable_google_optimize) {

        if ($productType == 'nightguard-system') {
            $infoData = getOptimizeAttr($productType);
            $variant = $infoData['variant'];
            $variantAttr = $infoData['attr'];
        }
    }
    if (!isset($atts['ajax_query'])) {
        $html .= '<div  id="product-selection-night-guards">';
    }

    //echo 'Data: <pre>' .print_r($product_4ultra_3mm,true). '</pre>'; die;
    $html .= '<div class="row-boots  sep-top-sm justify-content-center" id="">';

    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {

            $queryshortcode->the_post();

            $pid = get_the_id();
            $slug = basename(get_permalink($pid));
            $_product = wc_get_product((int) $pid);
            if ($_product->is_type('composite')) {
                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }
            $second_button_html = '';
            if ($slug == 'deluxe-night-guard-system-4-custom-night-guards') {
                $related_product_id = 794933;
                $product = wc_get_product($related_product_id);
                $ultra4price = $product->get_price();
                $Saleultra4price = $product->get_sale_price();
                $Regularultra4price = $product->get_regular_price();
                $ultraPriceClass3mm = 'ultra43mmprice';
                $ultraPriceClass2mm = 'price_ultra4Night2mm';
                $SaleultraPriceClass3mm = 'Saleultra43mmprice';
                $SaleultraPriceClass2mm = 'Saleprice_ultra4Night2mm';
                $RegularultraPriceClass3mm = 'regularultra43mmprice';
                $RegularultraPriceClass2mm = 'regularprice_ultra4Night2mm';
                $Selected = 'checked';
                $name = 'ultra4night';
                $inputid2mm = 'ultra4_night_guard2mm';
                $inputid3mm = 'ultra4_night_guard3mm';
                $composite_product_class3mm = 'composit_4ultraproduct3mm';
                $previous_composite_product_class2mm = 'composit_4ultraproduct2mm';
            }
            if ($slug == 'moderate-night-guard-system-2-custom-night-guards') {
                $related_product_id = 794935;
                $product = wc_get_product($related_product_id);
                $ultra4price = $product->get_price();
                $Saleultra4price = $product->get_sale_price();
                $Regularultra4price = $product->get_regular_price();
                $ultraPriceClass3mm = 'ultra23mmprice';
                $ultraPriceClass2mm = 'price_ultra2Night2mm';
                $SaleultraPriceClass3mm = 'Saleultra23mmprice';
                $SaleultraPriceClass2mm = 'Saleprice_ultra2Night2mm';
                $RegularultraPriceClass3mm = 'regularultra23mmprice';
                $RegularultraPriceClass2mm = 'regularprice_ultra2Night2mm';
                $Selected = 'checked';
                $name = 'ultra2night';
                $inputid2mm = 'ultra2_night_guard2mm';
                $inputid3mm = 'ultra2_night_guard3mm';
                $composite_product_class3mm = 'composit_2ultraproduct3mm';
                $previous_composite_product_class2mm = 'composit_2ultraproduct2mm';
            }
            if ($slug == 'intro-night-guard-system-1-custom-night-guard') {
                $related_product_id = 794937;
                $product = wc_get_product($related_product_id);

                $ultra4price = $product->get_price();
                $Saleultra4price = $product->get_sale_price();
                $Regularultra4price = $product->get_regular_price();
                $ultraPriceClass3mm = 'ultra13mmprice';
                $ultraPriceClass2mm = 'price_ultra1Night2mm';
                $SaleultraPriceClass3mm = 'Saleultra13mmprice';
                $SaleultraPriceClass2mm = 'Saleprice_ultra1Night2mm';
                $RegularultraPriceClass3mm = 'regularultra13mmprice';
                $RegularultraPriceClass2mm = 'regularprice_ultra1Night2mm';
                $Selected = 'checked';
                $name = 'ultra1night';
                $inputid2mm = 'ultra1_night_guard2mm';
                $inputid3mm = 'ultra1_night_guard3mm';
                $composite_product_class3mm = 'composit_1ultraproduct3mm';
                $previous_composite_product_class2mm = 'composit_1ultraproduct2mm';
            }

            /*BOGO Sale Code */
            $string_bogo = '';
            if (get_post_meta($related_product_id, 'bogo_product_id', true) != '') {
                $string_bogo = 'data-bogo_discount="' . get_post_meta($related_product_id, 'bogo_product_id', true) . '"';
            }
            /**End Bogo */

            $second_button_html = '<button  ' . $string_bogo . ' class=" btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart ' . $composite_product_class3mm . '" href="?add-to-cart=' . $related_product_id . '" ' . $variantAttr . '  data-quantity="1" data-product_id="' . $related_product_id . '" ' . $action_string . '>ADD TO CART</button>';
            $html_radio_button = '<div class="wrapper flex-wrapper">

            <div class="form-group-radio-custom">
                <input type="radio" name="' . $name . '" id="' . $inputid2mm . '" ' . $Selected . '>
                <label for="' . $inputid2mm . '" class="option ">
                    <div class="dot"></div>
                    <span class="mmAmount">2mm</span>
                    <span class="mmpopular">(most popular)</span>
                </label>
            </div>
            <div class="form-group-radio-custom">
                <input type="radio" name="' . $name . '" id="' . $inputid3mm . '">
                <label for="' . $inputid3mm . '" class="option">
                    <div class="dot"></div>
                    <span class="mmAmount">3mm</span>
                    <span class="mmpopular" style="visibility:hidden">add $10.00</span>
                </label>
            </div>
             </div>';

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $html .= '<div class="col-md-4">

         <div class="product-selection-box night-guards-prime-day-sale-ribbon-strip">';

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

            $html .= '<b>' . $titlee . '</b><br><br>

	      <div class="line-divider"></div>';

            if (get_field("info_3", $pid) != '') {

                $html .= '<div class="description-info3">';

                $html .= get_field("info_3", $pid);

                $html .= '</div>';
            }

            $html .= '<div class="product-selection-price-wrap pos-rel">';
            if ($enable_google_optimize) {
                $html .= '<div class="price_loading loading"></div>';
            }
            $html .= '<div>';
            if ($_product->is_on_sale()) {

                $ultraRprice2mm = $_product->get_regular_price();
                $ultraSprice2mm = $_product->get_price();

                switch ($variant) {
                    case 2:
                        $optimizeVal = '-' . (int) get_post_meta($pid, 'minus_value', true);

                        $ultraRprice2mm = $ultraRprice2mm + ($optimizeVal);
                        $ultraSprice2mm = $ultraSprice2mm + ($optimizeVal);

                        $Regularultra4price = $Regularultra4price + ($optimizeVal);
                        $Saleultra4price = $Saleultra4price + ($optimizeVal);

                        break;
                    case 1:

                        $optimizeVal = (int) get_post_meta($pid, 'plus_value', true);

                        $ultraRprice2mm = $ultraRprice2mm + ($optimizeVal);
                        $ultraSprice2mm = $ultraSprice2mm + ($optimizeVal);

                        $Regularultra4price = $Regularultra4price + ($optimizeVal);
                        $Saleultra4price = $Saleultra4price + ($optimizeVal);

                        break;

                    default:
                        # code...
                        break;
                }

                $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass2mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $ultraRprice2mm . '</del></span>';
                $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass2mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm" >$</span>' . $ultraSprice2mm . '</span>';

                $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass3mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $Regularultra4price . '</del></span>';
                $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass3mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm">$</span>' . $Saleultra4price . '</span>';
            } else {

                $html .= '<i  role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $ultra4price2mm = $_product->get_price();
                switch ($variant) {
                    case 2:
                        $optimizeVal = '-' . (int) get_post_meta($pid, 'minus_value', true);
                        $ultra4price2mm = $ultra4price2mm + ($optimizeVal);
                        $ultra4price = $ultra4price + ($optimizeVal);

                        break;
                    case 1:
                        $optimizeVal = (int) get_post_meta($pid, 'plus_value', true);
                        $ultra4price2mm = $ultra4price2mm + ($optimizeVal);
                        $ultra4price = $ultra4price + ($optimizeVal);
                        break;

                    default:
                        # code...
                        break;
                }
                $html .= '<span class="product-selection-price-text ' . $ultraPriceClass2mm . '">' . $ultra4price2mm . '</span>';
                $html .= '<span class="product-selection-price-text ' . $ultraPriceClass3mm . '">' . $ultra4price . '</span>';
            }
            /*
            if ($_product->is_on_sale()) {

            $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass2mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $_product->get_regular_price() . '</del></span>';
            $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass2mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm" >$</span>' . $_product->get_price() . '</span>';

            $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass3mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $Regularultra4price . '</del></span>';
            $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass3mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm">$</span>' . $Saleultra4price . '</span>';
            } else {

            $html .= '<i  role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

            $html .= '<span class="product-selection-price-text ' . $ultraPriceClass2mm . '">' . $_product->get_price() . '</span>';
            $html .= '<span class="product-selection-price-text ' . $ultraPriceClass3mm . '">' . $ultra4price . '</span>';
            }
             */
            $i = 1;
            if ($i == '1') {
                $select = "checked='checked'";
            }
            $i++;

            $html .= '</div>

               <div class=" product-selection-dentist-price-note getinfo-four">' . get_field("info_4", $pid) . '</div>';

            $html .= $html_radio_button;

            if ( /*$_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {
                /*BOGO Sale Code */
                $string_bogo = '';
                if (get_post_meta($pid, 'bogo_product_id', true) != '') {
                    $string_bogo = 'data-bogo_discount="' . get_post_meta($pid, 'bogo_product_id', true) . '"';
                }
                /**End Bogo */
                $html .= '<button  ' . $string_bogo . ' class=" btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart ' . $previous_composite_product_class2mm . '" href="?add-to-cart=' . $pid . '"  ' . $variantAttr . '  data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
                $html .= $second_button_html;
            } else {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button compo" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>
      ';
        }

        wp_reset_postdata();
    }
    $html .= '</div>';
    if (!isset($atts['ajax_query'])) {
        $html .= '</div>';

        $html .= '<style>
    .composit_4ultraproduct3mm{
       display:none;
    }
    .composit_2ultraproduct3mm{
       display:none;
    }
    .composit_1ultraproduct3mm{
       display:none;
    }
     .ultra43mmprice{
       display:none;
     }
     .ultra23mmprice{
       display:none;
     }
     .ultra13mmprice{
       display:none;
     }
     .Saleultra43mmprice{
       display:none;
     }
     .Saleultra23mmprice{
       display:none;
     }
     .Saleultra13mmprice{
       display:none;
     }
     .regularultra13mmprice{
       display:none;
     }
     .regularultra23mmprice{
       display:none;
     }
     .regularultra43mmprice{
       display:none;
     }

     </style>
     <script>
     jQuery(document).ready(function($){




       });


   jQuery(document).on("click","#ultra4_night_guard3mm",function($){
       jQuery(".ultra43mmprice").show();
       jQuery(".Saleultra43mmprice").show();
       jQuery(".regularultra43mmprice").show();
       jQuery(".composit_4ultraproduct3mm").show();
       jQuery(".price_ultra4Night2mm").hide();
       jQuery(".regularprice_ultra4Night2mm").hide();
       jQuery(".Saleprice_ultra4Night2mm").hide();
       jQuery(".composit_4ultraproduct2mm").hide();
       jQuery(".2mmdd4").hide();
       jQuery(".3mmdd4").show();

   });

   jQuery(document).on("click","#ultra2_night_guard3mm",function($){
       jQuery(".ultra23mmprice").show();
       jQuery(".Saleultra23mmprice").show();
       jQuery(".regularultra23mmprice").show();
       jQuery(".composit_2ultraproduct3mm").show();
       jQuery(".composit_2ultraproduct2mm").hide();
       jQuery(".regularprice_ultra2Night2mm").hide();
       jQuery(".Saleprice_ultra2Night2mm").hide();
       jQuery(".price_ultra2Night2mm").hide();
       jQuery(".2mmdd2").hide();
       jQuery(".3mmdd2").show();
   });

   jQuery(document).on("click","#ultra1_night_guard3mm",function($){
       jQuery(".ultra13mmprice").show();
       jQuery(".Saleultra13mmprice").show();
       jQuery(".regularultra13mmprice").show();
       jQuery(".composit_1ultraproduct3mm").show();
       jQuery(".composit_1ultraproduct2mm").hide();
       jQuery(".regularprice_ultra1Night2mm").hide();
       jQuery(".Saleprice_ultra1Night2mm").hide();
       jQuery(".price_ultra1Night2mm").hide();
       jQuery(".2mmdd1").hide();
       jQuery(".3mmdd1").show();
   });

   jQuery(document).on("click","#ultra4_night_guard2mm",function($){
       jQuery(".ultra43mmprice").hide();
       jQuery(".Saleultra43mmprice").hide();
       jQuery(".regularultra43mmprice").hide();
       jQuery(".composit_4ultraproduct3mm").hide();
       jQuery(".composit_4ultraproduct2mm").show();
       jQuery(".price_ultra4Night2mm").show();
       jQuery(".regularprice_ultra4Night2mm").show();
       jQuery(".Saleprice_ultra4Night2mm").show();
       jQuery(".2mmdd4").show();
       jQuery(".3mmdd4").hide();

   });
   jQuery(document).on("click","#ultra2_night_guard2mm",function($){
       jQuery(".ultra23mmprice").hide();
       jQuery(".Saleultra23mmprice").hide();
       jQuery(".regularultra23mmprice").hide();
       jQuery(".composit_2ultraproduct3mm").hide();
       jQuery(".composit_2ultraproduct2mm").show();
       jQuery(".price_ultra2Night2mm").show();
       jQuery(".regularprice_ultra2Night2mm").show();
       jQuery(".Saleprice_ultra2Night2mm").show();
       jQuery(".2mmdd2").show();
       jQuery(".3mmdd2").hide();
   });
   jQuery(document).on("click","#ultra1_night_guard2mm",function($){
       jQuery(".ultra13mmprice").hide();
       jQuery(".Saleultra13mmprice").hide();
       jQuery(".regularultra13mmprice").hide();
       jQuery(".composit_1ultraproduct3mm").hide();
       jQuery(".composit_1ultraproduct2mm").show();
       jQuery(".regularprice_ultra1Night2mm").show();
       jQuery(".Saleprice_ultra1Night2mm").show();
       jQuery(".price_ultra1Night2mm").show();
       jQuery(".2mmdd1").show();
       jQuery(".3mmdd1").hide();
   });


     </script>
    ';
    }
    return $html;
}

add_shortcode('night-guards', 'display_posts_night_guards');

function display_posts_water_flossers($atts)
{

    $productType = isset($atts['type']) ? $atts['type'] : '';

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(

        array(

            'taxonomy' => 'type',

            'field' => 'slug',

            'terms' => $productType,

        ),

    ));

    $queryshortcode = new WP_Query($args);

    $html = '<div class="row sep-top-sm" id="product-selection-standard">';

    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {

            $queryshortcode->the_post();

            $pid = get_the_id();

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $_product = wc_get_product((int) $pid);

            $html .= '<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">

                <div class="col-mbt">

         <div data-wow-delay=".6s" class="product-selection-box">

		  <div class="product-selection-title">

               ' . $titlee . '</div>

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

            $html .= '<div class="product-selection-price-wrap pro-price-opt-five">

               <div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>

               <div class="product-selection-dentist-price-note getsixx">' . get_field("info_2", $pid) . '</div>';

            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div> </div>

         </div>

      </div>';
        }

        wp_reset_postdata();
    }

    $html .= '</div>';

    return $html;
}

add_shortcode('water-flossers', 'display_posts_water_flossers');

function plaque_highlighters_func($atts)
{

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

                $html .= '<img src="' . get_field("pic_1", $pid) . '">';
            }

            $html .= '</div>';

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $html .= '<div class="product-selection-description">

               <b> ' . $titlee . '</b>';

            $html .= '</div>';

            $html .= '<div class="backOrderList alert alert-danger font-mont">This product is backordered with an estimated shipping date in mid January 2024.</div>';
            $html .= '<div class="product-selection-price-wrap pro-highlighters-adults-and-highlighters-kids">

               <div>

               <div class="product-selection-dentist-price-note getsevenn">original Price:  $' . get_field("average_price_value", $pid) . '</div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>';

            $html .= '<div class="value-text text-center">' . get_field("info_1", $pid) . '</div>';

            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }

            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {

                $html .= ' <button class="btn btn btn-primary-purple product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= ' <button class="btn btn btn-primary-purple product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>';
        }

        wp_reset_postdata();
    }

    $html .= '</div>';

    return $html;
}

/*

 * Retainer cleaner

 */

add_shortcode('retainer-cleaner', 'retainer_cleaner_func');

function retainer_cleaner_func($atts)
{

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

                $html .= '<img src="' . get_field("pic_1", $pid) . '">';
            }

            $html .= '</div>';

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $html .= '<div class="product-selection-description">

               <b> ' . $titlee . '</b>';

            $html .= '</div>';

            $html .= '<div class="product-selection-price-wrap pro-retainer-cleaner">

               <div>

               <div class="product-selection-dentist-price-note geteightt">original Price:  $' . get_field("average_price_value", $pid) . '</div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>';

            $html .= '<div class="value-text text-center">' . get_field("info_1", $pid) . '</div>';

            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }

            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {

                $html .= ' <button class="btn btn btn-primary-purple product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= ' <button class="btn btn btn-primary-purple product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>';
        }

        wp_reset_postdata();
    }

    $html .= '</div>';

    return $html;
}

// geha lander pop
add_shortcode('dental-probiotics-geha-pop', 'dental_probiotics_products_geha_pop');
function dental_probiotics_products_geha_pop($atts)
{
    global $post;
    $pslug = $post->post_name;
    $productType = isset($atts['type']) ? $atts['type'] : '';
    $product_custom_discounts = get_option('probiotics_discounts');

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $productType,
        ),
    ));

    $post_data = [];
    $all_pids = PROBIOTIC_SUBSCRIPTION_PRODUCTS;
    //$queryshortcode = new WP_Query($args);
    $queryshortcode = get_posts($args);

    if ($queryshortcode) {
        foreach ($queryshortcode as $post) {
            $pid = $post->ID;

            if (!in_array($pid, $all_pids)) {
                continue;
            }

            $_product = wc_get_product($pid);
            $sale_price_discounted = isset($product_custom_discounts[$pid]) ? $product_custom_discounts[$pid] : $_product->get_price();
            $post_data[$pid]['id'] = $pid;
            $post_data[$pid]['post'] = $post->post_name;

            if (get_field("pic_1", $pid) != '') {
                $post_data[$pid]['picture'] = get_field("pic_1", $pid);
            }

            $post_data[$pid]['title'] = get_the_title($pid);
            $post_data[$pid]['is_on_sale'] = $_product->is_on_sale();
            $post_data[$pid]['orignal_price'] = $_product->get_regular_price(); //get_field("average_price_value", $pid);
            $post_data[$pid]['sale_price'] = $_product->get_price();
            $post_data[$pid]['info_1'] = get_field("info_1", $pid);
            $post_data[$pid]['sale_price_discounted'] = $sale_price_discounted;

            if (is_page('sale') || is_page('geha') || is_page('ucc-members')) {
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item" data-page="'.$pslug.'" data-'.$pslug.'_user="yes" data-'.$pslug.'_probiotics_price="' . $sale_price_discounted . '"';
                } else {
                    $action_string = 'data-'.$pslug.'_user="yes" data-page="'.$pslug.'" data-'.$pslug.'_probiotics_price="' . $sale_price_discounted . '"';
                }
                $custom_page = true;
            }else{
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item"';
                } else {
                    $action_string = '';
                }
            }

            // if ($_product->is_type('composite')) {
            //     $action_string = 'data-action="woocommerce_add_order_item" data-geha_user="yes" data-geha_probiotics_price="' . $sale_price_discounted . '"';
            // } else {
            //     $action_string = 'data-geha_user="yes" data-geha_probiotics_price="' . $sale_price_discounted . '"';
            // }

            if (add_to_cart_validation_composite_product($pid)) {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
            $post_data[$pid]['button_html'] = $button;
        }

        foreach ($all_pids as $pid) {
            if ($pid == PROBIOTIC_3BOTTLE_PRODUCT_ID) {
                ?>
            <div class="caripro-subscription-product-box ninety-day-subscription geha-landarr red">
                    <div class="subscription-product-header white-background oneT">
                    <input type="radio" id="test1pop" name="radio-group" checked>
                     <label for="test1pop">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">90 Day Restoration System<?php //echo $post_data[$pid]['title']; ?></p>
                            <p class="main-price">
                            <!-- <span class="pricingDiscountMbt" >
                                <?php
// if ( $post_data[$pid]['is_on_sale'] ){
                ?>
                                    <span class="originalPriceut">
                                        <del>$<?php //echo $post_data[$pid]['orignal_price']; ?></del>
                                    </span>
                            <?php //}?>
                            </span> -->
                                <span>$</span><?php echo sprintf('%0.2f', $post_data[$pid]['sale_price_discounted']); ?>
                            </p>
                        </div>
                        <?php
if ($post_data[$pid]['is_on_sale']) {
                    ?>
                        <div class="subscription-product-header-bottom">
                            <div class="sale"> <p>SALE!</p> </div>
                           <div class="sale-text">
                           <p>$<?php echo $post_data[$pid]['orignal_price']; ?> without sale</p>
                           </div>
                        </div>
                    <?php
}?>
                     </label>

                     <div class="subscription-product-content-body">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• 3 Bottles (90 total tablets)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>


                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php echo $post_data[$pid]['button_html']; ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php
} else if ($pid == PROBIOTIC_2BOTTLE_PRODUCT_ID) {?>
            <div class="caripro-subscription-product-box subscribe-save">
                    <div class="subscription-product-header ">
                    <input type="radio" id="test2pop" name="radio-group" >
                     <label for="test2pop">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">Subscribe & Save!</p>
                            <p class="main-price"> <span>$</span>
                                <price id="P2_price"><img width="30" src="/assets/loader-price.gif" alt="Shine" /></price>
                            </p>
                        </div>
                        <div class="subscription-product-header-bottom" id="sale_div2">
                            <div class="sale"> <p>SAVE <price id="save_percent">0</price> %</p> </div>
                           <div class="sale-text">
                           <p>$<price id="P2_old_price">169.00</price> without sale</p>
                           </div>
                        </div>
                     </label>

                     <div class="subscription-product-content-body default-display">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• $<price id="price_today">59.95</price> Today. $<price id="after_price">59.95/mo</price> thereafter.</li>
                            <li>• Save $<price id="save_price">30</price> today.</li> <!-- PLUS 15% thereafter -->
                            <li>• Pause or cancel subscription at anytime.</li>
                        </ul>

                        <div class="select-probiotic-content-subscription">
                        <label for="subc_quantity">Quantity:</label>
                            <select name="subc_quantity" id="subc_quantity" onchange="updateOrderSubscriptionItem(this);">
                                <option value="<?php echo PROBIOTIC_1BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_1BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 bottles (30 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_2BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_2BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 bottles (60 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_3BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_3BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 bottles (90 chewable tablets)</option>
                            </select>

                            <label for="subc_frequency">Delivery Every:</label>
                            <select name="subc_frequency" id="subc_frequency" onchange="updateOrderSubscriptionItem(this);">
                            <option value="30" arbid="0" data-price="29.95">30 days (most common)</option><option value="60" arbid="1" data-price="29.95">60 days (most common)</option><option value="90" arbid="2" data-price="29.95">90 days (most common)</option>
                            </select>
                        </div>
                       <!-- <input type="hidden" id="subscription_item_data" name="subscription_item_data" value=""/> -->
                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php
if (add_to_cart_validation_composite_product($pid)) {
    echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P2_pop" data-arbid="0" href="?add-to-cart='.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" data-quantity="1" data-product_id="'.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" onclick="updateOrderSubscriptionItem();">Add To Cart</button>';
} else {
    echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P2_pop" href="?add-to-cart='.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" data-quantity="1" data-product_id="'.PROBIOTIC_1BOTTLE_PRODUCT_ID.'">Out Of Stock</button>';
}
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php } else if ($pid == PROBIOTIC_1BOTTLE_PRODUCT_ID) {?>
            <div class="caripro-subscription-product-box one-time-offer">
                    <div class="subscription-product-header">
                    <input type="radio" id="test3pop" name="radio-group">
                     <label for="test3pop">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">One-Time Purchase<?php // echo $post_data[$pid]['title']; ?></p>
                            <p class="main-price"> <span>$</span><price id="P1_price"><?php echo sprintf('%0.2f', $post_data[$pid]['sale_price_discounted']); ?></price></p>
                        </div>
                        <?php
if ($post_data[$pid]['is_on_sale']) {
                ?>
                        <div class="subscription-product-header-bottom" id="sale_div">
                            <div class="sale"> <p>SALE!</p> </div>
                           <div class="sale-text">
                            <p>$<price id="P1_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></price> without sale</p>
                           </div>
                        </div>
                        <?
            }?>
                     </label>

                     <div class="subscription-product-content-body">
                     <div class="subscription-product-content">
                        <ul>
                            <li id="item_detail_li">• 1 bottles (30 chewable tablets)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>

                        <div class="select-content">
                        <label for="Quantity">Quantity:</label>
                        <select name="Quantity" id="Quantity" onchange="togglePrice('P1', this.value,this);">
                                <option value="<?php echo PROBIOTIC_1BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_1BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 bottles (30 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_2BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_2BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 bottles (60 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_3BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_3BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 bottles (90 chewable tablets)</option>
                            </select>
                        </div>


                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                     <?php
if (add_to_cart_validation_composite_product($pid)) {
                echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
<?php
}
            ?>
            <input type="hidden" name="product_name<?php echo $pid; ?>" id="<?php echo $pid; ?>" value="<?php echo $post_data[$pid]['sale_price']; ?>" data-old_price="<?php echo $post_data[$pid]['orignal_price']; ?>">
<?php
}
        wp_reset_postdata();
    }
//echo "<pre>";    print_r($post_data);exit;
    return; //$post_data;
}

// geha lander
add_shortcode('dental-probiotics-geha', 'dental_probiotics_products_geha');
function dental_probiotics_products_geha($atts)
{

    global $post;
    $pslug = $post->post_name;
    $productType = isset($atts['type']) ? $atts['type'] : '';
    $product_custom_discounts = get_option('probiotics_discounts');

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $productType,
        ),
    ));

    $post_data = [];
    //$queryshortcode = new WP_Query($args);
    $all_pids = isset($atts['pids']) ? explode(",", $atts['pids']) : [];
    $discount = isset($atts['discount']) ? explode(",", $atts['discount']) : [];
    $disc_type = @$discount[0];
    $disc_amount = (float) @$discount[1];
    $queryshortcode = get_posts($args);

    if ($queryshortcode) {
        foreach ($queryshortcode as $post) {
            $pid = $post->ID;

            if (!in_array($pid, $all_pids)) {
                continue;
            }

            $_product = wc_get_product($pid);
            $sale_price_discounted = isset($product_custom_discounts[$pid]) ? $product_custom_discounts[$pid] : $_product->get_price();
            $post_data[$pid]['id'] = $pid;
            $post_data[$pid]['post'] = $post->post_name;

            if (get_field("pic_1", $pid) != '') {
                $post_data[$pid]['picture'] = get_field("pic_1", $pid);
            }

            $post_data[$pid]['title'] = get_the_title($pid);
            $post_data[$pid]['is_on_sale'] = $_product->is_on_sale();
            $post_data[$pid]['orignal_price'] = $_product->get_regular_price(); //get_field("average_price_value", $pid);
            $post_data[$pid]['sale_price'] = $_product->get_price();
            $post_data[$pid]['info_1'] = get_field("info_1", $pid);
            $post_data[$pid]['sale_price_discounted'] = $sale_price_discounted;

            // if ($_product->is_type('composite')) {
            //     $action_string = 'data-action="woocommerce_add_order_item" data-page="'.$pslug.'" data-geha_user="yes" data-geha_probiotics_price="' . $sale_price_discounted . '"';
            // } else {
            //     $action_string = 'data-geha_user="yes" data-geha_probiotics_price="' . $sale_price_discounted . '"';
            // }

            $custom_page = false;
            if (is_page('sale') || is_page('geha') || is_page('ucc-members')) {
                // if ($_product->is_type('composite')) {
                //     $action_string = 'data-action="woocommerce_add_order_item" data-vip_sale_price="' . $sale_price_discounted . '"';
                // } else {
                //     $action_string = 'data-vip_sale_price="' . $sale_price_discounted . '"';
                // }
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item" data-page="'.$pslug.'" data-'.$pslug.'_user="yes" data-'.$pslug.'_probiotics_price="' . $sale_price_discounted . '"';
                } else {
                    $action_string = 'data-'.$pslug.'_user="yes" data-page="'.$pslug.'" data-'.$pslug.'_probiotics_price="' . $sale_price_discounted . '"';
                }
                $custom_page = true;
            }else{
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item"';
                } else {
                    $action_string = '';
                }
            }

            if (add_to_cart_validation_composite_product($pid)) {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
            $post_data[$pid]['button_html'] = $button;
        }

        foreach ($all_pids as $pid) {
            if ($pid == PROBIOTIC_3BOTTLE_PRODUCT_ID) {
                ?>
            <div class="caripro-subscription-product-box ninety-day-subscription geha-landarr">
                    <div class="subscription-product-header white-background twoT">
                    <input type="radio" id="test1" name="radio-group" checked>
                     <label for="test1">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">90 Day Restoration System<?php //echo $post_data[$pid]['title']; ?></p>
                            <p class="main-price">
                                 <span class="pricingDiscountMbt">
                                <?php
//if ($post_data[$pid]['is_on_sale']) {
                    ?>
                                    <span class="originalPriceut">
                                        <del>$<?php echo $post_data[$pid]['orignal_price']; ?> </del>
                                    </span>
                                <?php
//}?>
                                </span>
                                <span class="dollerSymbal">$</span><?php echo sprintf('%0.2f', $post_data[$pid]['sale_price_discounted']); ?>
                            </p>
                        </div>
                        <?php
//if ( $post_data[$pid]['is_on_sale'] ){
                ?>
<!--                        <div class="subscription-product-header-bottom">
                            <div class="sale"> <p>SALE!</p> </div>
                           <div class="sale-text">
                           <p>$<?php // echo $post_data[$pid]['orignal_price']; ?> without sale</p>
                           </div>
                        </div> -->
                    <?php //}?>
                     </label>

                     <div class="subscription-product-content-body">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• 3 Bottles (90 total tablets)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>


                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php echo $post_data[$pid]['button_html']; ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php
} else if ($pid == PROBIOTIC_2BOTTLE_PRODUCT_ID) {?>
            <div class="caripro-subscription-product-box subscribe-save rowTwoo">
                    <div class="subscription-product-header ">
                    <input type="radio" id="test2" name="radio-group" >
                     <label for="test2">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">Subscribe & Save!</p>
                            <p class="main-price">
                            <span class="pricingDiscountMbt">
                                    <span class="originalPriceut">
                                        <del>$<span id="P2_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></span> </del>
                                    </span>
                                </span>
                                <span class="dollerSymbal">$</span><price id="P2_price"><img width="30" src="/assets/loader-price.gif" alt="Shine" /></price>
                            </p>
                        </div>
                        <div class="subscription-product-header-bottom" id="sale_div2">
                            <div class="sale"> <p>SAVE <price id="save_percent">0</price> %</p> </div>
                           <!--<div class="sale-text">
                            <p>$<price id="P2_old_price">169.00</price> without sale</p>
                           </div>-->
                        </div>
                     </label>

                     <div class="subscription-product-content-body default-display">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• $<price id="price_today">59.95</price> Today. $<price id="after_price">59.95/mo</price> thereafter.</li>
                            <li>• Save $<price id="save_price">30</price> today.</li> <!-- PLUS 15% thereafter -->
                            <li>• Pause or cancel subscription at anytime.</li>
                        </ul>

                        <div class="select-probiotic-content-subscription">
                        <label for="subc_quantity">Quantity:</label>
                            <select name="subc_quantity" id="subc_quantity" onchange="updateOrderSubscriptionItem(this);">
                                <option value="<?php echo PROBIOTIC_1BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_1BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 bottles (30 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_2BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_2BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 bottles (60 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_3BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_3BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 bottles (90 chewable tablets)</option>
                            </select>

                            <label for="subc_frequency">Delivery Every:</label>
                            <select name="subc_frequency" id="subc_frequency" onchange="updateOrderSubscriptionItem(this);">
                            <option value="30" arbid="0" data-price="29.95">30 days (most common)</option><option value="60" arbid="1" data-price="29.95">60 days (most common)</option><option value="90" arbid="2" data-price="29.95">90 days (most common)</option>
                        </select>
                        </div>
                       <input type="hidden" id="subscription_item_data" name="subscription_item_data" value=""/>
                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php
if (add_to_cart_validation_composite_product($pid)) {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P2" data-arbid="0" href="?add-to-cart='.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" data-quantity="1" data-product_id="'.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" onclick="updateOrderSubscriptionItem(this);">Add To Cart</button>';
            } else {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P2" href="?add-to-cart='.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" data-quantity="1" data-product_id="'.PROBIOTIC_1BOTTLE_PRODUCT_ID.'">Out Of Stock</button>';
            }
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php } else if ($pid == PROBIOTIC_1BOTTLE_PRODUCT_ID) {?>
            <div class="caripro-subscription-product-box one-time-offer">
                    <div class="subscription-product-header">
                    <input type="radio" id="test3" name="radio-group">
                     <label for="test3">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">One-Time Purchase<?php // echo $post_data[$pid]['title']; ?></p>
                            <p class="main-price">
                            <span class="pricingDiscountMbt">
                                <span class="originalPriceut">
                                    <del>$<span id="P1_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></span> </del>
                                </span>
                            </span>
                                <span class="dollerSymbal">$</span><price id="P1_price"><?php echo sprintf('%0.2f', $post_data[$pid]['sale_price_discounted']); ?></price>
                            </p>
                        </div>
                        <?php
// if ( $post_data[$pid]['is_on_sale'] ){
                ?>
<!--                        <div class="subscription-product-header-bottom" id="sale_div">
                            <div class="sale"> <p>SALE!</p> </div>
                           <div class="sale-text">
                            <p>$<price id="P1_old_price"><?php //echo $post_data[$pid]['orignal_price']; ?></price> without sale</p>
                           </div>
                        </div> -->
                        <?// } ?>
                     </label>

                     <div class="subscription-product-content-body">
                     <div class="subscription-product-content">
                        <ul>
                            <li id="item_detail_li">• 1 bottles (30 chewable tablets)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>

                        <div class="select-probiotic-content-subscription">
                        <label for="Quantity">Quantity:</label>
                        <select name="Quantity" id="Quantity" onchange="togglePrice('P1', this.value,this);">
                                <option value="<?php echo PROBIOTIC_1BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_1BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 bottles (30 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_2BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_2BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 bottles (60 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_3BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_3BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 bottles (90 chewable tablets)</option>
                            </select>
                        </div>


                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                     <?php
if (add_to_cart_validation_composite_product($pid)) {
                    echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
                } else {
                    echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-geha_user="yes" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
                }
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
<?php
}
            ?>
            <input type="hidden" name="discount_type" id="discount_type" value="<?php echo $disc_type; ?>">
            <input type="hidden" name="discount_amt" id="discount_amt" value="<?php echo $disc_amount; ?>">
            <input type="hidden" name="product_name<?php echo $pid; ?>" id="<?php echo $pid; ?>" value="<?php echo $post_data[$pid]['sale_price']; ?>" data-old_price="<?php echo $post_data[$pid]['orignal_price']; ?>">
<?php
}
        wp_reset_postdata();
    }
//echo "<pre>";    print_r($post_data);exit;
    return; //$post_data;
}
//subscription#RB
add_shortcode('dental-probiotics2', 'dental_probiotics_products');
function dental_probiotics_products($atts)
{
    $productType = isset($atts['type']) ? $atts['type'] : '';
    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $productType,
        ),
    ));

    $post_data = [];
    $all_pids = PROBIOTIC_SUBSCRIPTION_PRODUCTS;
    //$queryshortcode = new WP_Query($args);
    $queryshortcode = get_posts($args);

    if ($queryshortcode) {
        foreach ($queryshortcode as $post) {
            $pid = $post->ID;

            if (!in_array($pid, $all_pids)) {
                continue;
            }

            $_product = wc_get_product($pid);

            $post_data[$pid]['id'] = $pid;
            $post_data[$pid]['post'] = $post->post_name;

            if (get_field("pic_1", $pid) != '') {
                $post_data[$pid]['picture'] = get_field("pic_1", $pid);
            }

            $post_data[$pid]['title'] = get_the_title($pid);
            $post_data[$pid]['is_on_sale'] = $_product->is_on_sale();
            $post_data[$pid]['orignal_price'] = $_product->get_regular_price(); //get_field("average_price_value", $pid);
            $post_data[$pid]['sale_price'] = $_product->get_price();
            $post_data[$pid]['info_1'] = get_field("info_1", $pid);

            if ($_product->is_type('composite')) {
                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {
                $action_string = '';
            }

            if (add_to_cart_validation_composite_product($pid)) {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
            $post_data[$pid]['button_html'] = $button;
        }

        foreach ($all_pids as $pid) {
            if ($pid == PROBIOTIC_3BOTTLE_PRODUCT_ID) {
                ?>
            <div class="subscription-product-box ninety-day-subscription">
                    <div class="subscription-product-header white-background threeT">
                    <input type="radio" id="test1" name="radio-group" checked>
                     <label for="test1">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">90 Day Restoration System</p>
                            <p class="main-price">
                                <span class="dollerSymbal">$</span><?php echo sprintf('%0.2f', $post_data[$pid]['sale_price']); ?>
                            </p>
                        </div>
                        <?php
if ($post_data[$pid]['is_on_sale']) {
                    ?>
                        <div class="subscription-product-header-bottom">
                            <div class="sale"> <p>SALE!</p> </div>
                           <div class="sale-text">
                           <p>$<?php echo $post_data[$pid]['orignal_price']; ?> without sale</p>
                           </div>
                        </div>
                        <?php
}?>
                     </label>

                     <div class="subscription-product-content-body">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• 3 Bottles (90 total tablets)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>


                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php echo $post_data[$pid]['button_html']; ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php
} else if ($pid == PROBIOTIC_2BOTTLE_PRODUCT_ID) {?>
            <div class="subscription-product-box subscribe-save">
                    <div class="subscription-product-header ">
                    <input type="radio" id="test2" name="radio-group" >
                     <label for="test2">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">Subscribe & Save!</p>
                            <p class="main-price"> <span>$</span><price id="P2_price"><img width="30" src="/assets/loader-price.gif" alt="Shine" /></price></p>
                        </div>
                        <div class="subscription-product-header-bottom" id="sale_div2">
                            <div class="sale"> <p>SAVE <price id="save_percent">0</price> %</p> </div>
                           <div class="sale-text">
                           <p>$<price id="P2_old_price">169.00</price> without sale</p>
                           </div>
                        </div>
                     </label>

                     <div class="subscription-product-content-body default-display">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• $<price id="price_today">59.95</price> Today. $<price id="after_price">59.95/mo</price> thereafter.</li>
                            <li>• Save $<price id="save_price">30</price> today.</li> <!-- PLUS 15% thereafter -->
                            <li>• Pause or cancel subscription at anytime.</li>
                        </ul>

                        <div class="select-probiotic-content-subscription">
                        <label for="subc_quantity">Quantity:</label>
                            <select name="subc_quantity" id="subc_quantity" onchange="updateOrderSubscriptionItem();">
                                <option value="<?php echo PROBIOTIC_1BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_1BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 bottles (30 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_2BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_2BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 bottles (60 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_3BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_3BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 bottles (90 chewable tablets)</option>
                            </select>

                            <label for="subc_frequency">Delivery Every:</label>
                            <select name="subc_frequency" id="subc_frequency" onchange="updateOrderSubscriptionItem();">
                            </select>
                        </div>
                       <input type="hidden" id="subscription_item_data" name="subscription_item_data" value=""/>
                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php
if (add_to_cart_validation_composite_product($pid)) {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P2" data-arbid="0" href="?add-to-cart='.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" data-quantity="1" data-product_id="'.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" onclick="updateOrderSubscriptionItem();">Add To Cart</button>';
            } else {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P2" href="?add-to-cart='.PROBIOTIC_1BOTTLE_PRODUCT_ID.'" data-quantity="1" data-product_id="'.PROBIOTIC_1BOTTLE_PRODUCT_ID.'">Out Of Stock</button>';
            }
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php } else if ($pid == PROBIOTIC_1BOTTLE_PRODUCT_ID) {?>
            <div class="subscription-product-box one-time-offer">
                    <div class="subscription-product-header">
                    <input type="radio" id="test3" name="radio-group">
                     <label for="test3">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">One-Time Purchase<?php // echo $post_data[$pid]['title']; ?></p>
                            <p class="main-price"> <span>$</span><price id="P1_price"><?php echo sprintf('%0.2f', $post_data[$pid]['sale_price']); ?></price></p>
                        </div>

                        <div class="subscription-product-header-bottom" id="sale_div">
                            <div class="sale"> <p>SALE!</p> </div>
                           <div class="sale-text">
                            <p>$<price id="P1_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></price> without sale</p>
                           </div>
                        </div>
                     </label>

                     <div class="subscription-product-content-body">
                     <div class="subscription-product-content">
                        <ul>
                            <li id="item_detail_li">• 1 bottles (30 chewable tablets)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>

                        <div class="select-content">
                        <label for="Quantity">Quantity:</label>
                        <select name="Quantity" id="Quantity" onchange="togglePrice('P1', this.value);">
                                <option value="<?php echo PROBIOTIC_1BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_1BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 bottles (30 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_2BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_2BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 bottles (60 chewable tablets)</option>
                                <option value="<?php echo PROBIOTIC_3BOTTLE_PRODUCT_ID;?>" on-sale="<?php echo ($post_data[PROBIOTIC_3BOTTLE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 bottles (90 chewable tablets)</option>
                            </select>
                        </div>


                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                     <?php
if (add_to_cart_validation_composite_product($pid)) {
                echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
<?php
}
            ?>
            <input type="hidden" name="product_name<?php echo $pid; ?>" id="<?php echo $pid; ?>" value="<?php echo $post_data[$pid]['sale_price']; ?>" data-old_price="<?php echo $post_data[$pid]['orignal_price']; ?>">
<?php
}
        wp_reset_postdata();
    }
//echo "<pre>";    print_r($post_data);exit;
    return; //$post_data;
}

add_shortcode('enamel-armour-subscriptions', 'enamel_armour_subscriptions');
function enamel_armour_subscriptions($atts)
{
    global $post;
    $pslug = $post->post_name;
    $pop = isset($atts['pop']) ? $atts['pop'] : '';
    $productType = isset($atts['type']) ? $atts['type'] : '';
    $product_custom_discounts = get_option('enamelarmour_discounts');
    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $productType,
        ),
    ));

    $post_data = [];
    $all_pids = ENAMELARMOUR_SUBSCRIPTION_PRODUCTS;
    $discount = isset($atts['discount']) ? explode(",", $atts['discount']) : [];
    $disc_type = @$discount[0];
    $disc_amount = (float) @$discount[1];

    //$queryshortcode = new WP_Query($args);
    $queryshortcode = get_posts($args);
    if ($queryshortcode) {
        foreach ($queryshortcode as $post) {
            $pid = $post->ID;

            if (!in_array($pid, $all_pids)) {
                continue;
            }

            $_product = wc_get_product($pid);
            $sale_price_discounted = isset($product_custom_discounts[$pid]) ? $product_custom_discounts[$pid] : $_product->get_price();
            $post_data[$pid]['id'] = $pid;
            $post_data[$pid]['post'] = $post->post_name;

            if (get_field("pic_1", $pid) != '') {
                $post_data[$pid]['picture'] = get_field("pic_1", $pid);
            }

            $post_data[$pid]['title'] = get_the_title($pid);
            $post_data[$pid]['is_on_sale'] = $_product->is_on_sale();
            $post_data[$pid]['orignal_price'] = $_product->get_regular_price(); //get_field("average_price_value", $pid);
            $post_data[$pid]['sale_price'] = $_product->get_price();
            $post_data[$pid]['info_1'] = get_field("info_1", $pid);
            $post_data[$pid]['sale_price_discounted'] = $sale_price_discounted;

            $custom_page = false;
            if (is_page('sale') || is_page('geha') || is_page('ucc-members')) {                
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item" data-page="'.$pslug.'" data-'.$pslug.'_user="yes" data-'.$pslug.'_enamel_price="' . $sale_price_discounted . '"';
                } else {
                    $action_string = 'data-'.$pslug.'_user="yes" data-page="'.$pslug.'" data-'.$pslug.'_enamel_price="' . $sale_price_discounted . '"';
                }
                $custom_page = true;
            }else{
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item"';
                } else {
                    $action_string = '';
                }
            }

            
            if (add_to_cart_validation_composite_product($pid)) {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
            $post_data[$pid]['button_html'] = $button;
        }

        foreach ($all_pids as $pid) {
            if ($pid == ENAMELARMOUR_2TUBE_PRODUCT_ID) {?>
            <div class="enamel-subscription-product-box subscribe-save">
                    <div class="subscription-product-header white-background">
                    <input type="radio" id="test22<?php echo $pop; ?>" name="radio-group-enamal" checked>
                     <label for="test22<?php echo $pop; ?>">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">Subscribe & Save!</p>
                            <!-- <p class="main-price"> <span>$</span><price id="P2_price"><img width="30" src="/assets/loader-price.gif" alt="Shine" /></price></p> -->
                            <p class="main-price">
                                 <span class="pricingDiscountMbt">
                                <?php

                if ($post_data[$pid]['is_on_sale'] || $custom_page) {
?>
                                    <span class="originalPriceut">
                                        <del>$<span id="P2_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></span> </del>                                        
                                    </span>
                                <?php
}?>
                                </span>
                                <span class="dollerSymbal">$</span><price id="P2_price"><img width="30" src="/assets/loader-price.gif" alt="Shine" /></price>
                            </p>
                        </div>
                        <!-- <div class="subscription-product-header-bottom" id="sale_div2">
                            <div class="sale"> <p>SAVE <price id="save_percent">0</price> %</p> </div>
                           <div class="sale-text">
                           <p>$<price id="P2_old_price">169.00</price> without sale</p>
                           </div>
                        </div> -->
                     </label>

                     <div class="subscription-product-content-body default-display">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• $<price id="price_today">59.95</price> Today. $<price id="after_price">59.95/mo</price> thereafter.</li>
                            <li>• Save $<price id="save_price">30</price> today.</li> <!-- PLUS 15% thereafter -->
                            <li>• Pause or cancel subscription at anytime.</li>
                        </ul>

                        <div class="select-enamel-content">
                        <label for="subc_quantity">Quantity:</label>
                            <select name="subc_quantity" id="subc_quantity" onchange="updateEnamelOrderSubscriptionItem();">
                                <option value="<?php echo ENAMELARMOUR_1TUBE_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[ENAMELARMOUR_1TUBE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 Tube</option>
                                <option value="<?php echo ENAMELARMOUR_2TUBE_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[ENAMELARMOUR_2TUBE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 Tubes</option>
                                <option value="<?php echo ENAMELARMOUR_3TUBE_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[ENAMELARMOUR_3TUBE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 Tubes</option>
                            </select>

                            <label for="subc_frequency">Delivery Every:</label>
                            <select name="subc_frequency" id="subc_frequency" onchange="updateEnamelOrderSubscriptionItem();">
                            </select>
                        </div>
                       <input type="hidden" id="enamel_subscription_item_data" name="enamel_subscription_item_data" value=""/>
                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php
            if (add_to_cart_validation_composite_product($pid)) {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P2" data-arbid="0" href="?add-to-cart=' . ENAMELARMOUR_2TUBE_PRODUCT_ID . '" data-quantity="1" data-product_id="' . ENAMELARMOUR_2TUBE_PRODUCT_ID . '" onclick="updateEnamelOrderSubscriptionItem();">Add To Cart</button>';
            } else {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P2" href="?add-to-cart=' . ENAMELARMOUR_2TUBE_PRODUCT_ID . '" data-quantity="1" data-product_id="' . ENAMELARMOUR_2TUBE_PRODUCT_ID . '">Out Of Stock</button>';
            }
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php } else if ($pid == ENAMELARMOUR_1TUBE_PRODUCT_ID) {?>
            <div class="enamel-subscription-product-box one-time-offer enemalArmourSaleLanderpage">
                    <div class="subscription-product-header">
                        <input type="radio" id="test33<?php echo $pop; ?>" name="radio-group-enamal">
                        <label for="test33<?php echo $pop; ?>">
                            <div class="subscription-product-header-top">
                                <p class="subscription-title">One-Time Purchase
                                <p class="main-price">
                                 <span class="pricingDiscountMbt">
                                <?php
if ($post_data[$pid]['is_on_sale'] || $custom_page) {
                    ?>
                                    <span class="originalPriceut">
                                        <del>$<span id="P1_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></span> </del>
                                    </span>
                                <?php
}?>
                                </span>
                                <span class="dollerSymbal">$</span><price id="P1_price"><?php echo sprintf('%0.2f', $custom_page?$post_data[$pid]['sale_price_discounted']:$post_data[$pid]['sale_price']); ?></price>
                            </p>

                            </div>
                        </label>

                     <div class="subscription-product-content-body" >
                     <div class="subscription-product-content">
                        <ul>
                            <li id="item_detail_li">• 1 tube (30 day supply)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>

                        <div class="select-enamel-content">
                        <label for="Quantity">Quantity:</label>
                        <select name="Quantity" id="Quantity" onchange="togglePriceEnamel('P1', this.value, this);">
                                <option value="<?php echo ENAMELARMOUR_1TUBE_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[ENAMELARMOUR_1TUBE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 Tube (30 Day Supply)</option>
                                <option value="<?php echo ENAMELARMOUR_2TUBE_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[ENAMELARMOUR_2TUBE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 Tubes (60 Day Supply)</option>
                                <option value="<?php echo ENAMELARMOUR_3TUBE_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[ENAMELARMOUR_3TUBE_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 Tubes (90 Day Supply)</option>
                            </select>
                        </div>

                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                     <?php
                        if (add_to_cart_validation_composite_product($pid)) {
                                        echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
                                    } else {
                                        echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
                                    }
                                        ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
<?php
}
            ?>
            <input type="hidden" name="discount_type_enamel" id="discount_type_enamel" value="<?php echo $disc_type; ?>">
            <input type="hidden" name="discount_amt_enamel" id="discount_amt_enamel" value="<?php echo $disc_amount; ?>">
            <input type="hidden" name="product_name<?php echo $pid; ?>" id="<?php echo $pid; ?>" value="<?php echo $post_data[$pid]['sale_price']; ?>" data-old_price="<?php echo $post_data[$pid]['orignal_price']; ?>">
<?php
}
        wp_reset_postdata();
    }
//echo "<pre>";    print_r($post_data);exit;
    return; //$post_data;
}

add_shortcode('plaque-highlighter-subscriptions', 'plaque_highlighter_subscriptions');
function plaque_highlighter_subscriptions($atts)
{
    global $post;
    $pslug = $post->post_name;
    $pop = isset($atts['pop']) ? $atts['pop'] : '';
    $productType = isset($atts['type']) ? $atts['type'] : '';
    $product_custom_discounts = get_option('plaquehighlighter_discounts');
    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $productType,
        ),
    ));

    $post_data = [];
    $all_pids = PLAQUE_HIGHLIGHTER_SUBSCRIPTION_PRODUCTS;
    $discount = isset($atts['discount']) ? explode(",", $atts['discount']) : [];
    $disc_type = @$discount[0];
    $disc_amount = (float) @$discount[1];
    
    $queryshortcode = get_posts($args);
    if ($queryshortcode) {
        foreach ($queryshortcode as $post) {
            $pid = $post->ID;

            if (!in_array($pid, $all_pids)) {
                continue;
            }

            $_product = wc_get_product($pid);
            $sale_price_discounted = isset($product_custom_discounts[$pid]) ? $product_custom_discounts[$pid] : $_product->get_price();
            $post_data[$pid]['id'] = $pid;
            $post_data[$pid]['post'] = $post->post_name;

            if (get_field("pic_1", $pid) != '') {
                $post_data[$pid]['picture'] = get_field("pic_1", $pid);
            }

            $post_data[$pid]['title'] = get_the_title($pid);
            $post_data[$pid]['is_on_sale'] = $_product->is_on_sale();
            $post_data[$pid]['orignal_price'] = $_product->get_regular_price();
            $post_data[$pid]['sale_price'] = $_product->get_price();
            $post_data[$pid]['info_1'] = get_field("info_1", $pid);
            $post_data[$pid]['sale_price_discounted'] = $sale_price_discounted;

            $custom_page = false;
            if (is_page('sale') || is_page('geha') || is_page('ucc-members')) {                
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item" data-page="'.$pslug.'" data-'.$pslug.'_user="yes" data-'.$pslug.'_plaque_price="' . $sale_price_discounted . '"';
                } else {
                    $action_string = 'data-'.$pslug.'_user="yes" data-page="'.$pslug.'" data-'.$pslug.'_plaque_price="' . $sale_price_discounted . '"';
                }
                $custom_page = true;
            }else{
                if ($_product->is_type('composite')) {
                    $action_string = 'data-action="woocommerce_add_order_item"';
                } else {
                    $action_string = '';
                }
            }

            if (add_to_cart_validation_composite_product($pid)) {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
            $post_data[$pid]['button_html'] = $button;
        }

        foreach ($all_pids as $pid) {
            if ($pid == PLAQUE_HIGHLIGHTER2_PRODUCT_ID) {?>
            <div class="plaquehighlighter-subscription-product-box subscribe-save">
                    <div class="subscription-product-header white-background">
                    <input type="radio" id="test4<?php echo $pop; ?>" name="radio-group-plaque" checked>
                     <label for="test4<?php echo $pop; ?>">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">Subscribe & Save!</p>
                            <!-- <p class="main-price"> <span>$</span><price id="P2_price"><img width="30" src="/assets/loader-price.gif" alt="Shine" /></price></p> -->
                            <p class="main-price">
                                 <span class="pricingDiscountMbt">
                                <?php

                if ($post_data[$pid]['is_on_sale'] || $custom_page) {
?>
                                    <span class="originalPriceut">
                                        <del>$<span id="P2_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></span> </del>                                        
                                    </span>
                                <?php
}?>
                                </span>
                                <span class="dollerSymbal">$</span><price id="P2_price"><img width="30" src="/assets/loader-price.gif" alt="Shine" /></price>
                            </p>
                        </div>
                        <!-- <div class="subscription-product-header-bottom" id="sale_div2">
                            <div class="sale"> <p>SAVE <price id="save_percent">0</price> %</p> </div>
                           <div class="sale-text">
                           <p>$<price id="P2_old_price">169.00</price> without sale</p>
                           </div>
                        </div> -->
                     </label>

                     <div class="subscription-product-content-body default-display">
                     <div class="subscription-product-content">
                        <ul>
                            <li>• $<price id="price_today">59.95</price> Today. $<price id="after_price">59.95/mo</price> thereafter.</li>
                            <li>• Save $<price id="save_price">30</price> today PLUS 15% thereafter.</li> 
                            <li>• Pause or cancel subscription at anytime.</li>
                        </ul>

                        <div class="select-plaquehighlighter-content">
                        <label for="subc_quantity">Quantity:</label>
                            <select name="subc_quantity" id="subc_quantity" onchange="updatePlaqueOrderSubscriptionItem();">
                                <option value="<?php echo PLAQUE_HIGHLIGHTER1_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[PLAQUE_HIGHLIGHTER1_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 box (30 tablets)</option>
                                <option value="<?php echo PLAQUE_HIGHLIGHTER2_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[PLAQUE_HIGHLIGHTER2_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 boxes (60 tablets)</option>
                                <option value="<?php echo PLAQUE_HIGHLIGHTER3_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[PLAQUE_HIGHLIGHTER3_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 boxes (90 tablets)</option>
                            </select>

                            <label for="subc_frequency">Delivery Every:</label>
                            <select name="subc_frequency" id="subc_frequency" onchange="updatePlaqueOrderSubscriptionItem();">
                            </select>
                        </div>
                       <input type="hidden" id="plaquehighlighter_subscription_item_data" name="plaquehighlighter_subscription_item_data" value=""/>
                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                        <?php
if (add_to_cart_validation_composite_product($pid)) {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P2" data-arbid="0" href="?add-to-cart=' . PLAQUE_HIGHLIGHTER2_PRODUCT_ID . '" data-quantity="1" data-product_id="' . PLAQUE_HIGHLIGHTER2_PRODUCT_ID . '" onclick="updatePlaqueOrderSubscriptionItem();">Add To Cart</button>';
            } else {
                echo ' <button class="btn btn-primary-teal btn-lg  product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P2" href="?add-to-cart=' . PLAQUE_HIGHLIGHTER2_PRODUCT_ID . '" data-quantity="1" data-product_id="' . PLAQUE_HIGHLIGHTER2_PRODUCT_ID . '">Out Of Stock</button>';
            }
            
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
            <?php } else if ($pid == PLAQUE_HIGHLIGHTER1_PRODUCT_ID) {?>
            <div class="plaquehighlighter-subscription-product-box one-time-offer">
                    <div class="subscription-product-header ">
                    <input type="radio" id="test5<?php echo $pop; ?>" name="radio-group-plaque">
                     <label for="test5<?php echo $pop; ?>">
                        <div class="subscription-product-header-top">
                            <p class="subscription-title">One-Time Purchase<?php // echo $post_data[$pid]['title']; ?></p>
                            <!-- <p class="main-price"> <span>$</span><price id="P1_price"><?php //echo sprintf('%0.2f', $post_data[$pid]['sale_price']); ?></price></p> -->
                            <p class="main-price">
                                 <span class="pricingDiscountMbt">
                                <?php
if ($post_data[$pid]['is_on_sale'] || $custom_page) {
                    ?>
                                    <span class="originalPriceut">
                                        <del>$<span id="P1_old_price"><?php echo $post_data[$pid]['orignal_price']; ?></span> </del>
                                    </span>
                                <?php
}?>
                                </span>
                                <span class="dollerSymbal">$</span><price id="P1_price"><?php echo sprintf('%0.2f', $custom_page?$post_data[$pid]['sale_price_discounted']:$post_data[$pid]['sale_price']); ?></price>
                            </p>
                        </div>

                        <!-- <div class="subscription-product-header-bottom" id="sale_div">
                            <div class="sale"> <p>SALE!</p> </div>
                           <div class="sale-text">
                            <p>$<price id="P1_old_price"><?php //echo $post_data[$pid]['orignal_price']; ?></price> without sale</p>
                           </div>
                        </div> -->
                     </label>

                     <div class="subscription-product-content-body">
                     <div class="subscription-product-content">
                        <ul>
                            <li id="item_detail_li">• 1 Pack (30 day supply)</li>
                            <li>• Money back guarantee</li>
                            <li>• Free Shipping</li>
                        </ul>

                        <div class="select-plaquehighlighter-content">
                        <label for="Quantity">Quantity:</label>
                        <select name="Quantity" id="Quantity" onchange="togglePricePlaque('P1', this.value,this);">
                                <option value="<?php echo PLAQUE_HIGHLIGHTER1_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[PLAQUE_HIGHLIGHTER1_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">1 Box (30 Day Supply)</option>
                                <option value="<?php echo PLAQUE_HIGHLIGHTER2_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[PLAQUE_HIGHLIGHTER2_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">2 Boxes (60 Day Supply)</option>
                                <option value="<?php echo PLAQUE_HIGHLIGHTER3_PRODUCT_ID; ?>" on-sale="<?php echo ($post_data[PLAQUE_HIGHLIGHTER3_PRODUCT_ID]['is_on_sale'] ? 1 : 0) ?>">3 Boxes (90 Day Supply)</option>
                            </select>
                        </div>

                     </div>
                     <div class="subscription-product-footer">
                     <div class="add-to-cart-btn">
                     <?php
if (add_to_cart_validation_composite_product($pid)) {
                echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                echo ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button"  id="P1" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
                ?>
                        </div>
                     </div>
                    </div>
                    </div>

            </div>
<?php
}
            ?>
            <input type="hidden" name="discount_type_plaquehighlighter" id="discount_type_plaquehighlighter" value="<?php echo $disc_type; ?>">
            <input type="hidden" name="discount_amt_plaquehighlighter" id="discount_amt_plaquehighlighter" value="<?php echo $disc_amount; ?>">
            <input type="hidden" name="product_name<?php echo $pid; ?>" id="<?php echo $pid; ?>" value="<?php echo $post_data[$pid]['sale_price']; ?>" data-old_price="<?php echo $post_data[$pid]['orignal_price']; ?>">
<?php
}
        wp_reset_postdata();
    }
//echo "<pre>";    print_r($post_data);exit;
    return; //$post_data;
}

add_shortcode('dental-probiotics', 'dental_probiotics_func');

function dental_probiotics_func($atts)
{

    $productType = isset($atts['type']) ? $atts['type'] : '';

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(

        array(

            'taxonomy' => 'type',

            'field' => 'slug',

            'terms' => $productType,

        ),

    ));

    $queryshortcode = new WP_Query($args);

    $html = '<div class="row-boots  sep-top-sm justify-content-center dentailProBioticAdusltsKids">';

    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {

            $queryshortcode->the_post();

            $pid = get_the_id();

            $_product = wc_get_product((int) $pid);

            $html .= '<div class="col-md-4">

         <div class="product-selection-box wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated">

            <div class="product-selection-image-wrap">';

            if (get_field("pic_1", $pid) != '') {

                $html .= '<img src="' . get_field("pic_1", $pid) . '">';
            }

            $html .= '</div>';

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $html .= '<div class="product-selection-description">

               <b> ' . $titlee . '</b>';

            $html .= '</div>';

            $html .= '<div class="backOrderList alert alert-danger font-mont">This product is backordered with an estimated shipping date in mid January 2024.</div>';

            $html .= '<div class="product-selection-price-wrap pro-stain-concealer-and-dental-probiotic-adults-and-enemal-armour-and-dental-flosser-picks">

               <div>

               <div class="product-selection-dentist-price-note getninee">original Price:  $' . get_field("average_price_value", $pid) . '</div>';

            if ($_product->is_on_sale()) {

                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {

                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }

            $html .= '</div>';

            $html .= '<div class="value-text text-center">' . get_field("info_1", $pid) . '</div>';

            if ($_product->is_type('composite')) {

                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }

            if ($_product->is_in_stock() && add_to_cart_validation_composite_product($pid)) {

                $html .= ' <button class="btn btn btn-primary-purple product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {

                $html .= ' <button class="btn btn btn-primary-purple product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>';
        }

        wp_reset_postdata();
    }

    $html .= '</div>';

    return $html;
}

add_shortcode('plaque-highlighters', 'plaque_highlighters_func');
function display_posts_ultrasonic_cleaner($atts)
{

    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => 'ultrasonic-cleaner',
        ),
    ));

    $queryshortcode = new WP_Query($args);
    $html = '<div class="row-boots  sep-top-sm justify-content-center" id="product-selection-night-guards">';
    if ($queryshortcode->have_posts()) {

        while ($queryshortcode->have_posts()) {

            $queryshortcode->the_post();
            $pid = get_the_id();
            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {
                $titlee = get_the_title($pid);
            }

            $_product = wc_get_product((int) $pid);

            $html .= '<div class="col-md-7">';
            $html .= '<div class="product-selection-box">';
            $html .= '<div class="product-selection-box-inner">';
            $html .= '<div class="product-selection-title">' . $titlee . '</div>';
            $html .= '<div class="product-selection-image-wrap">';

            if (get_field("pic_1", $pid) != '') {
                $html .= '<img src="' . get_field("pic_1", $pid) . '"><span></span>';
            }
            $html .= '</div>';

            if (get_field("info_1", $pid) != '') {
                $html .= '<div class="product-selection-box-description">' . get_field("info_1", $pid) . '</div>';
            }

            if ($_product->is_type('composite')) {
                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }
            /* Start Div */
            $html .= '<div class="product-selection-price-wrap pro-ultrasonic-cleaner">';
            $html .= '<div>';
            if ($_product->is_on_sale()) {
                $html .= '<span class="product-selection-price-text">' . $_product->get_price_html() . '</span>';
            } else {
                $html .= '<i class="fa fa-dollar product-selection-price-dollar-symbol"></i>';
                $html .= '<span class="product-selection-price-text">' . $_product->get_price() . '</span>';
            }
            $html .= '</div>';

            $html .= '<div class="product-selection-dentist-price-note gettenn">' . get_field("info_2", $pid) . '</div>';
            $html .= '<div class="backOrderList alert alert-danger font-mont">This product is backordered with an estimated shipping date in mid January 2024.</div>';
            if ( /* $_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {
                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>ADD TO CART</button>';
            } else {
                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }
            $html .= '</div>';
            /* End Div */
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        wp_reset_postdata();
    }
    $html .= '</div>';
    return $html;
}

add_shortcode('ultrasonic-cleaner', 'display_posts_ultrasonic_cleaner');

/*

add_filter('the_content', function ($content) {
$content = preg_replace('/ style=("|\')(.*?)("|\')/', '', $content);
return $content;
}, 20);

 */

function getAuthorRDHC_blog($user_id)
{
    $user_firstname = get_user_meta($user_id, 'first_name', true);
    $user_lastname = get_user_meta($user_id, 'last_name', true);
    $rdhTitle = $user_firstname . ' ' . $user_lastname;
    global $wpdb;
    $brief = '';
    $sql_query2 = "select * from buddy_user_meta where  user_id =" . $user_id;
    $results_query2 = $wpdb->get_results($sql_query2, 'ARRAY_A');
    if (is_array($results_query2) && count($results_query2) > 0) {
        foreach ($results_query2 as $key => $ed) {
            if ($ed['key'] == 'biref') {
                $ed['value'] = str_replace("\'", "'", $ed['value']);
                $brief = $ed['value'];
            }
        }
    }
    $buddy_name = '';
    $rdhImage = '';
    if (function_exists('bp_is_active')) {
        $buddy_name = bp_core_get_username($user_id);
        $rdhImage = bp_core_fetch_avatar(
            array(
                'item_id' => $user_id,
                'type' => 'full',
                'html' => false,
            )
        );
    } else {
        $data = array('userid_rdh' => $user_id);
        $response = wp_remote_post('https://rdhconnect.com/wp-json/custom/v1/get-rdh-info-by-id', array(
            'body' => json_encode($data),
            'timeout' => 45,
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . get_option('rdh_api_key'), // Replace with your actual API key/token
            ),
        ));
        // echo '<pre>'.print_r( $response ).'</pre>';
        // die();
        if (is_wp_error($response)) {
            // Handle error, if any
            $error_message = $response->get_error_message();

        }

        // Get the response body
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);
        // echo '<pre>'.print_r($data).'</pre>';
        // echo $data->rdh_buddy_name;
        if (isset($data['rdh_buddy_name']) && $data['rdh_buddy_name'] != '') {

            $buddy_name = $data['rdh_buddy_name'];
            $rdhImage = $data['rdh_image'];
        }

    }
    ?>
    <div class="authorContainer">
        <div class="authorProfileImg"><img class="alignnone size-full" src="<?php echo $rdhImage; ?>" alt="" width="200"></div>
        <div class="authorDetails">
            <h3><strong> <?php echo $rdhTitle; ?></strong></h3>

            <p class="paragraph"><?php echo $brief; ?></p>
            <div class="profile-button">
                <a href="/rdh/profile/<?php echo $buddy_name; ?>" class="button view profile btn btn-primary-blue btn-lg">View My Profile</a>
                <a href="/rdh/contact/<?php echo $buddy_name; ?>" class="button contact btn btn-primary-blue btn-lg">Contact <?php echo $user_firstname; ?></a>
            </div>
        </div>
    </div>
<?php
}

add_shortcode('rdh_author', 'rdh_author_func');

function rdh_author_func($atts)
{
    ob_start();

    $user_id = get_the_author_meta('ID');
    getAuthorRDHC_blog($user_id);

    if (get_field('co_author')):
        foreach (get_field('co_author') as $co_author) {
            getAuthorRDHC_blog($co_author);
        }
    endif;
    return ob_get_clean();
}

add_shortcode('night-guards-new', 'display_posts_night_guards_new_layout');
function display_posts_night_guards_new_layout($atts)
{

    $productType = isset($atts['type']) ? $atts['type'] : '';
    $args = array('post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => '-1', 'tax_query' => array(
        array(
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $productType,
        ),
    ));

    $queryshortcode = new WP_Query($args);

    $html = '';
    $variant = 0;
    $variantAttr = '';

    $enable_google_optimize = get_field('enable_service', 'option');
    if ($enable_google_optimize) {

        if ($productType == 'nightguard-system') {
            $infoData = getOptimizeAttr($productType);
            $variant = $infoData['variant'];
            $variantAttr = $infoData['attr'];
        }
    }
    if (!isset($atts['ajax_query'])) {
        $html .= '<div  id="product-selection-night-guards">';
    }

    //echo 'Data: <pre>' .print_r($product_4ultra_3mm,true). '</pre>'; die;
    $html .= '<div class="row-boots  sep-top-sm justify-content-center" id="">';

    if ($queryshortcode->have_posts()) {

        $pop_product = array();
        while ($queryshortcode->have_posts()) {

            $queryshortcode->the_post();

            $pid = get_the_id();
            $slug = basename(get_permalink($pid));
            $_product = wc_get_product((int) $pid);
            if ($_product->is_type('composite')) {
                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {

                $action_string = '';
            }
            $qtysfjudyrf = 1;
            $second_button_html = '';
            if ($slug == 'deluxe-night-guard-system-4-custom-night-guards') {
                $related_product_id = 794933;
                $product = wc_get_product($related_product_id);
                $ultra4price = $product->get_price();
                $Saleultra4price = $product->get_sale_price();
                $Regularultra4price = $product->get_regular_price();
                $ultraPriceClass3mm = 'ultra43mmprice';
                $ultraPriceClass2mm = 'price_ultra4Night2mm';
                $SaleultraPriceClass3mm = 'Saleultra43mmprice';
                $SaleultraPriceClass2mm = 'Saleprice_ultra4Night2mm';
                $RegularultraPriceClass3mm = 'regularultra43mmprice';
                $RegularultraPriceClass2mm = 'regularprice_ultra4Night2mm';
                $Selected = 'checked';
                $name = 'ultra4night';
                $inputid2mm = 'ultra4_night_guard2mm';
                $inputid3mm = 'ultra4_night_guard3mm';
                $composite_product_class3mm = 'composit_4ultraproduct3mm';
                $previous_composite_product_class2mm = 'composit_4ultraproduct2mm';
                $qtysfjudyrf = 4;
            }
            if ($slug == 'moderate-night-guard-system-2-custom-night-guards') {
                $related_product_id = 794935;
                $product = wc_get_product($related_product_id);
                $ultra4price = $product->get_price();
                $Saleultra4price = $product->get_sale_price();
                $Regularultra4price = $product->get_regular_price();
                $ultraPriceClass3mm = 'ultra23mmprice';
                $ultraPriceClass2mm = 'price_ultra2Night2mm';
                $SaleultraPriceClass3mm = 'Saleultra23mmprice';
                $SaleultraPriceClass2mm = 'Saleprice_ultra2Night2mm';
                $RegularultraPriceClass3mm = 'regularultra23mmprice';
                $RegularultraPriceClass2mm = 'regularprice_ultra2Night2mm';
                $Selected = 'checked';
                $name = 'ultra2night';
                $inputid2mm = 'ultra2_night_guard2mm';
                $inputid3mm = 'ultra2_night_guard3mm';
                $composite_product_class3mm = 'composit_2ultraproduct3mm';
                $previous_composite_product_class2mm = 'composit_2ultraproduct2mm';
                $qtysfjudyrf = 2;
            }
            if ($slug == 'intro-night-guard-system-1-custom-night-guard') {
                $related_product_id = 794937;
                $product = wc_get_product($related_product_id);

                $ultra4price = $product->get_price();
                $Saleultra4price = $product->get_sale_price();
                $Regularultra4price = $product->get_regular_price();
                $ultraPriceClass3mm = 'ultra13mmprice';
                $ultraPriceClass2mm = 'price_ultra1Night2mm';
                $SaleultraPriceClass3mm = 'Saleultra13mmprice';
                $SaleultraPriceClass2mm = 'Saleprice_ultra1Night2mm';
                $RegularultraPriceClass3mm = 'regularultra13mmprice';
                $RegularultraPriceClass2mm = 'regularprice_ultra1Night2mm';
                $Selected = 'checked';
                $name = 'ultra1night';
                $inputid2mm = 'ultra1_night_guard2mm';
                $inputid3mm = 'ultra1_night_guard3mm';
                $composite_product_class3mm = 'composit_1ultraproduct3mm';
                $previous_composite_product_class2mm = 'composit_1ultraproduct2mm';
                $qtysfjudyrf = 1;
            }

            $pop_product[$pid] = get_post_meta($pid, 'related_delux_product', true);
            $pop_product[$related_product_id] = get_post_meta($related_product_id, 'related_delux_product', true);
            /*BOGO Sale Code */
            $string_bogo = '';
            if (get_post_meta($related_product_id, 'bogo_product_id', true) != '') {
                $string_bogo = 'data-bogo_discount="' . get_post_meta($related_product_id, 'bogo_product_id', true) . '"';
            }
            /**End Bogo */

            $second_button_html = '<button  ' . $string_bogo . ' class=" btn btn-primary-blue product_type_simple ' . $composite_product_class3mm . '" href="?add-to-cart=' . $related_product_id . '" ' . $variantAttr . '  data-quantity="1" data-product_id="' . $related_product_id . '" ' . $action_string . '>Select Package</button>';
            $html_radio_button = '<div class="wrapper flex-wrapper">

            <div class="form-group-radio-custom">
                <input type="radio" name="' . $name . '" id="' . $inputid2mm . '" ' . $Selected . '>
                <label for="' . $inputid2mm . '" class="option ">
                    <div class="dot"></div>
                    <span class="mmAmount">2mm</span>
                    <span class="mmpopular">(most popular)</span>
                </label>
            </div>
            <div class="form-group-radio-custom">
                <input type="radio" name="' . $name . '" id="' . $inputid3mm . '">
                <label for="' . $inputid3mm . '" class="option">
                    <div class="dot"></div>
                    <span class="mmAmount">3mm</span>
                    <span class="mmpopular" style="visibility:hidden">add $10.00</span>
                </label>
            </div>
             </div>';

            $titlee = get_field("styled_title", $pid);

            if ($titlee == '') {

                $titlee = get_the_title($pid);
            }

            $html .= '<div class="col-md-4">

         <div class="product-selection-box night-guards-prime-day-sale-ribbon-strip">';
            $html .= ' <div class="ribbon-sale"></div>';

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

            $html .= '<b>' . $titlee . '</b><br><br>

	      <div class="line-divider"></div>';

            if (get_field("info_3", $pid) != '') {

                $html .= '<div class="description-info3">';

                $html .= get_field("info_3", $pid);

                $html .= '</div>';
            }

            $html .= '<div class="product-selection-price-wrap pos-rel">';
            if ($enable_google_optimize) {
                $html .= '<div class="price_loading loading"></div>';
            }
            $html .= '<div>';
            if ($_product->is_on_sale()) {

                $ultraRprice2mm = $_product->get_regular_price();
                $ultraSprice2mm = $_product->get_price();

                switch ($variant) {
                    case 2:
                        $optimizeVal = '-' . (int) get_post_meta($pid, 'minus_value', true);

                        $ultraRprice2mm = $ultraRprice2mm + ($optimizeVal);
                        $ultraSprice2mm = $ultraSprice2mm + ($optimizeVal);

                        $Regularultra4price = $Regularultra4price + ($optimizeVal);
                        $Saleultra4price = $Saleultra4price + ($optimizeVal);

                        break;
                    case 1:

                        $optimizeVal = (int) get_post_meta($pid, 'plus_value', true);

                        $ultraRprice2mm = $ultraRprice2mm + ($optimizeVal);
                        $ultraSprice2mm = $ultraSprice2mm + ($optimizeVal);

                        $Regularultra4price = $Regularultra4price + ($optimizeVal);
                        $Saleultra4price = $Saleultra4price + ($optimizeVal);

                        break;

                    default:
                        # code...
                        break;
                }

                $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass2mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $ultraRprice2mm . '</del></span>';
                $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass2mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm" >$</span>' . $ultraSprice2mm . '</span>';

                $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass3mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $Regularultra4price . '</del></span>';
                $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass3mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm">$</span>' . $Saleultra4price . '</span>';
            } else {

                $html .= '<i  role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

                $ultra4price2mm = $_product->get_price();
                switch ($variant) {
                    case 2:
                        $optimizeVal = '-' . (int) get_post_meta($pid, 'minus_value', true);
                        $ultra4price2mm = $ultra4price2mm + ($optimizeVal);
                        $ultra4price = $ultra4price + ($optimizeVal);

                        break;
                    case 1:
                        $optimizeVal = (int) get_post_meta($pid, 'plus_value', true);
                        $ultra4price2mm = $ultra4price2mm + ($optimizeVal);
                        $ultra4price = $ultra4price + ($optimizeVal);
                        break;

                    default:
                        # code...
                        break;
                }
                $html .= '<span class="product-selection-price-text ' . $ultraPriceClass2mm . '">' . $ultra4price2mm . '</span>';
                $html .= '<span class="product-selection-price-text ' . $ultraPriceClass3mm . '">' . $ultra4price . '</span>';
            }
            /*
            if ($_product->is_on_sale()) {

            $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass2mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $_product->get_regular_price() . '</del></span>';
            $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass2mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm" >$</span>' . $_product->get_price() . '</span>';

            $html .= '<span class=" regular-price-sale-night-guard ' . $RegularultraPriceClass3mm . '"><del aria-hidden="true"><span class="woocommerce-Price-currencySymbol woocommerce-sale-symbol">$</span>' . $Regularultra4price . '</del></span>';
            $html .= '<span class="product-selection-price-text ' . $SaleultraPriceClass3mm . '"><span class="woocommerce-Price-currencySymbol sale-price-2mm">$</span>' . $Saleultra4price . '</span>';
            } else {

            $html .= '<i  role="presentation" class="fa fa-dollar product-selection-price-dollar-symbol"></i>';

            $html .= '<span class="product-selection-price-text ' . $ultraPriceClass2mm . '">' . $_product->get_price() . '</span>';
            $html .= '<span class="product-selection-price-text ' . $ultraPriceClass3mm . '">' . $ultra4price . '</span>';
            }
             */
            $i = 1;
            if ($i == '1') {
                $select = "checked='checked'";
            }
            $i++;

            $html .= '</div>

               <div class=" product-selection-dentist-price-note getinfo-four">' . get_field("info_4", $pid) . '</div>';

            $html .= $html_radio_button;

            if ( /*$_product->is_in_stock() && */add_to_cart_validation_composite_product($pid)) {
                /*BOGO Sale Code */
                $string_bogo = '';
                if (get_post_meta($pid, 'bogo_product_id', true) != '') {
                    $string_bogo = 'data-bogo_discount="' . get_post_meta($pid, 'bogo_product_id', true) . '"';
                }

                $html .= '<div class="selectPackageWrapper">';
                $html .= '<div class="selectPackageBox">
                <div class="selectPackageBoxWrapper">
                <div class="packageheader font-mont">
                <span class="textSelectPackage">CHOOSE IMPRESSION KIT</span>
                <a href="javascript:;" class="iconCloseBox">
                x
                </a>
                </div>
                <div class="packageBody">
                <div class="stepQuantityOption">
                <div class="packageRow">
                <div class="custom-radio form-group-radio-custom">
                <input type="radio" data-pid="" data-price="122.85" data-avr-price="Discounted price for GEHA members " id="" name="fav_language" data-geha_sale_price="122.85" data-geha_user="yes" class="pacakge_selected_data default-package" value="">
                <label for="">
                <div class="radioButtonInner">

                <div class="standard-text">Standard Impression Kit <i>(FREE)</i></div>
                <div class="header-top-text">
                • Impression Kit for upper teeth.</br>
                • <span style="color:#68c8c7;">One</span> extra set of extra impression material</br>
                • 3D digital dental models <span style="color:#68c8c7;" class="optiontt">stored for 1 year.</span>
                </div>
                <div class="header-top-below"><i>If you have no intention of ever whitening your teeth or purchasing another custom-fitted product from our lab, this is the best option.</i></div>';
                $html .= '</div>
                </label>
                </div>
                </div>
                <div class="packageRow">
                <div class="custom-radio form-group-radio-custom">
                <input type="radio" data-pid="" data-price="116.35" data-avr-price="Discounted price for GEHA members " id="" name="fav_language" data-geha_sale_price="116.35" data-geha_user="yes" class="pacakge_selected_data added-package" value="">
                <label for="">
                <div class="radioButtonInner">
                <div class="standard-text"><strong> Deluxe Impression Kit</strong> <span class="price-show-over">(+$14.95)</span>
                <div class="most-populr-text"> <strong style="color:#68c8c7;"><i>MOST POPULAR</i></strong> <span class="star-image-rating"><img src="https://www.smilebrilliant.com/wp-content/uploads/2020/09/4.9-stars.png" class="stars"></span>   </div>
                </div>
                <div class="header-top-text">

                <ul class="text-description-update-by-ai">
                    <li>
                        <span class="dottt-circle-indicate">• </span>
                        <span class="text-indicate">Final product includes <span class="inset-quantity-text">' . $qtysfjudyrf . '<insert qty> </span> UPPER night guards + Travel Case</span>
                    </li>
                    <li>
                        <span class="dottt-circle-indicate">• </span>
                        <span class="text-indicate">Impression kit for both upper <span style="color:#68c8c7;">AND</span> lower teeth (lower impression saved on file)</span>
                    </li>
                    <li>
                        <span class="dottt-circle-indicate">• </span>
                        <span class="text-indicate"> <span style="color:#68c8c7;">Unlimited</span> extra impression material</span>
                    </li>
                    <li>
                        <span class="dottt-circle-indicate">• </span>
                        <span class="text-indicate"> 3D digital dental models <span style="color:#68c8c7;">stored for life.</span> </span>
                    </li>

                </ul>
                </div>
                <div class="header-top-below"><i>If you would like the option to purchase whitening trays or other custom-fitted products in the future, this option makes it cheap and easy.</i></div>
                </div>
                </label>
                </div>
                </div>




                </div>
                </div>
                <div class="packageFooter">
                <div class="packageTotalPrice">
                <div class="priceparentBx"><span class="dollerSign">$</span><span class="packageAmount">96.85</span></div>
                <div class="normalyAmount italic"><span class="targeted_avr">normally $60.00 </span></div>
                </div>
                <div class="addToCartBottom openQuantityBox">
                <button class="btn btn-primary-blue product_type_composite add_to_cart_button ajax_add_to_cart" href="?add-to-cart='.T3_NON_SENSITIVE_SYSTEM_TRAYS_3_SYRINGES_ID.'" data-quantity="1" data-geha_sale_price="96.85" data-geha_user="yes" data-rdhc_user_id="" data-product_id="'.T3_NON_SENSITIVE_SYSTEM_TRAYS_3_SYRINGES_ID.'" data-action="woocommerce_add_order_item">Add to Cart</button>
                </div>
                <div class="close-button-text">
                <a href="javascript:;" class="iconCloseBox">close</a>
                </div>
                </div>
                </div>
                </div>';
                /**End Bogo */
                $html .= '<div class="product-selection-price-wrap selectpackageButton">';
                $html .= '<button  ' . $string_bogo . ' class=" btn btn-primary-blue product_type_simple ' . $previous_composite_product_class2mm . '" href="?add-to-cart=' . $pid . '"  ' . $variantAttr . '  data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Select Package</button>';
                $html .= $second_button_html;
                $html .= '</div>';
                $html .= '</div>';
            } else {
                $html .= '<button class="btn btn-primary-blue product_type_simple add_to_cart_button compo" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>OUT OF STOCK</button>';
            }

            $html .= '</div>

         </div>

      </div>
      ';
        }
        $json_data = array();
        foreach ($pop_product as $key => $val) {
            $product_obj = wc_get_product($val);
            if (!$product_obj) {
                continue;
            }

            $original_product = wc_get_product($key);
            $json_data[$key] = [
                'product_id' => $val,
                'product_price' => $product_obj->get_price(),
                'product_price_regular' => $product_obj->get_regular_price(),
                'product_price_sale' => $product_obj->get_sale_price(),
                'product_price_orig' => $original_product->get_price(),
                'product_price_regular_orig' => $original_product->get_regular_price(),
                'product_price_sale_orig' => $original_product->get_sale_price(),
                'info_4_text' => get_post_meta($val, "info_4", true),
            ];
        }
        wp_reset_postdata();
    }
    $html .= '</div>';
    if (!isset($atts['ajax_query'])) {
        $html .= '</div>';

        $html .= '<style>
    .composit_4ultraproduct3mm{
       display:none;
    }
    .composit_2ultraproduct3mm{
       display:none;
    }
    .composit_1ultraproduct3mm{
       display:none;
    }
     .ultra43mmprice{
       display:none;
     }
     .ultra23mmprice{
       display:none;
     }
     .ultra13mmprice{
       display:none;
     }
     .Saleultra43mmprice{
       display:none;
     }
     .Saleultra23mmprice{
       display:none;
     }
     .Saleultra13mmprice{
       display:none;
     }
     .regularultra13mmprice{
       display:none;
     }
     .regularultra23mmprice{
       display:none;
     }
     .regularultra43mmprice{
       display:none;
     }

     </style>
     <script>
     var related_json = ' . json_encode($json_data) . '
     console.log(related_json);
     jQuery(document).ready(function($){




       });


   jQuery(document).on("click","#ultra4_night_guard3mm",function($){
       jQuery(".ultra43mmprice").show();
       jQuery(".Saleultra43mmprice").show();
       jQuery(".regularultra43mmprice").show();
       jQuery(".composit_4ultraproduct3mm").show();
       jQuery(".price_ultra4Night2mm").hide();
       jQuery(".regularprice_ultra4Night2mm").hide();
       jQuery(".Saleprice_ultra4Night2mm").hide();
       jQuery(".composit_4ultraproduct2mm").hide();
       jQuery(".2mmdd4").hide();
       jQuery(".3mmdd4").show();

   });

   jQuery(document).on("click","#ultra2_night_guard3mm",function($){
       jQuery(".ultra23mmprice").show();
       jQuery(".Saleultra23mmprice").show();
       jQuery(".regularultra23mmprice").show();
       jQuery(".composit_2ultraproduct3mm").show();
       jQuery(".composit_2ultraproduct2mm").hide();
       jQuery(".regularprice_ultra2Night2mm").hide();
       jQuery(".Saleprice_ultra2Night2mm").hide();
       jQuery(".price_ultra2Night2mm").hide();
       jQuery(".2mmdd2").hide();
       jQuery(".3mmdd2").show();
   });

   jQuery(document).on("click","#ultra1_night_guard3mm",function($){
       jQuery(".ultra13mmprice").show();
       jQuery(".Saleultra13mmprice").show();
       jQuery(".regularultra13mmprice").show();
       jQuery(".composit_1ultraproduct3mm").show();
       jQuery(".composit_1ultraproduct2mm").hide();
       jQuery(".regularprice_ultra1Night2mm").hide();
       jQuery(".Saleprice_ultra1Night2mm").hide();
       jQuery(".price_ultra1Night2mm").hide();
       jQuery(".2mmdd1").hide();
       jQuery(".3mmdd1").show();
   });

   jQuery(document).on("click","#ultra4_night_guard2mm",function($){
       jQuery(".ultra43mmprice").hide();
       jQuery(".Saleultra43mmprice").hide();
       jQuery(".regularultra43mmprice").hide();
       jQuery(".composit_4ultraproduct3mm").hide();
       jQuery(".composit_4ultraproduct2mm").show();
       jQuery(".price_ultra4Night2mm").show();
       jQuery(".regularprice_ultra4Night2mm").show();
       jQuery(".Saleprice_ultra4Night2mm").show();
       jQuery(".2mmdd4").show();
       jQuery(".3mmdd4").hide();

   });
   jQuery(document).on("click","#ultra2_night_guard2mm",function($){
       jQuery(".ultra23mmprice").hide();
       jQuery(".Saleultra23mmprice").hide();
       jQuery(".regularultra23mmprice").hide();
       jQuery(".composit_2ultraproduct3mm").hide();
       jQuery(".composit_2ultraproduct2mm").show();
       jQuery(".price_ultra2Night2mm").show();
       jQuery(".regularprice_ultra2Night2mm").show();
       jQuery(".Saleprice_ultra2Night2mm").show();
       jQuery(".2mmdd2").show();
       jQuery(".3mmdd2").hide();
   });
   jQuery(document).on("click","#ultra1_night_guard2mm",function($){
       jQuery(".ultra13mmprice").hide();
       jQuery(".Saleultra13mmprice").hide();
       jQuery(".regularultra13mmprice").hide();
       jQuery(".composit_1ultraproduct3mm").hide();
       jQuery(".composit_1ultraproduct2mm").show();
       jQuery(".regularprice_ultra1Night2mm").show();
       jQuery(".Saleprice_ultra1Night2mm").show();
       jQuery(".price_ultra1Night2mm").show();
       jQuery(".2mmdd1").show();
       jQuery(".3mmdd1").hide();
   });


     </script>
    ';
    }
    return $html;
}

add_shortcode('shine-memberships', 'shine_memberships');
function shine_memberships($atts)
{
    $productType = isset($atts['type']) ? $atts['type'] : '';
    $affiliate_version = isset($atts['affiliate_version']) ? $atts['affiliate_version'] : '';
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'post__in' => [SHINE_PERK_PRODUCT_ID, SHINE_COMPLETE_PRODUCT_ID, SHINE_DENTAL_PRODUCT_ID],
        'orderby' => 'ID', // Sorting by title
        'order' => 'ASC', // In ascending order
        // 'tax_query' => array(
        //     array(
        //         'taxonomy' => 'type',
        //         'field' => 'slug',
        //         'terms' => $productType,
        //     ),
        // ),
    );
    $post_data = [];
    $queryshortcode = get_posts($args);
    if ($queryshortcode) {
        foreach ($queryshortcode as $post) {
            $pid = $post->ID;
            $_product = wc_get_product($pid);
            $post_data[$pid]['id'] = $pid;
            $post_data[$pid]['post'] = $post->post_name;

            if (get_field("pic_1", $pid) != '') {
                $post_data[$pid]['picture'] = get_field("pic_1", $pid);
            }

            $post_data[$pid]['title'] = get_the_title($pid);
            $post_data[$pid]['is_on_sale'] = $_product->is_on_sale();
            $post_data[$pid]['orignal_price'] = $_product->get_regular_price();
            $post_data[$pid]['sale_price'] = $_product->get_price();
            $post_data[$pid]['info_1'] = get_field("info_1", $pid);

            if ($_product->is_type('composite')) {
                $action_string = 'data-action="woocommerce_add_order_item"';
            } else {
                $action_string = '';
            }

            if (add_to_cart_validation_composite_product($pid)) {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button ajax_add_to_cart" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Add To Cart</button>';
            } else {
                $button = ' <button class="btn btn-primary-teal btn-lg product_type_' . $_product->get_type() . ' add_to_cart_button" href="?add-to-cart=' . $pid . '" data-quantity="1" data-product_id="' . $pid . '" ' . $action_string . '>Out Of Stock</button>';
            }
            $post_data[$pid]['button_html'] = $button;
        }
    }
    ?>




<script>
function getPrices(id) {
    try {
        var frequency = document.getElementById(id + '_frequency').value;
        var members = document.getElementById(id + '_members').value;
        var combinationsElement = document.getElementById(id + '_combinations');

        // Log the content of the combinations element to debug
        console.log('Combinations element content:', combinationsElement.value);
        // Log the content of the indexes element to debug
        //console.log('indexes element content:', indexes);

        var combinations = JSON.parse(combinationsElement.value);
        var indexes = JSON.parse(combinationsElement.getAttribute("indexs"));
        var priceKey = id + '_' + members + '_' + frequency;
        var price = combinations[priceKey];
        var index = indexes[priceKey];

        var freq_symbol = '';
        if(frequency > 28 && frequency < 365){
            freq_symbol = '/mo';
        }else{
            freq_symbol = '/yr';
        }

        if(price && price != "undefined"){
            document.getElementById('M' +id + '_indicator').style.display = '';
            document.getElementById('D' +id + '_indicator').style.display = '';
            document.getElementById('D' + id + '_price').innerHTML = parseFloat(price).toFixed(2);
            document.getElementById('M' + id + '_price').innerHTML = parseFloat(price).toFixed(2);
            document.getElementById('D' + id + '_perTenure').innerHTML = freq_symbol;
            document.getElementById('M' + id + '_perTenure').innerHTML = freq_symbol;
            var element = document.getElementById(id + '_btn');
            element.classList.remove('disableButton');
            element.disabled = false;
            document.getElementById(id + '_info').style.display = 'none';
            document.getElementById(id + '_btn').setAttribute("data-prod_price", parseFloat(price));
            document.getElementById(id + '_btn').setAttribute("data-frequency", frequency);
            document.getElementById(id + '_btn').setAttribute("data-members", members);
            document.getElementById(id + '_btn').setAttribute("data-arbid", index);
        }else{
            document.getElementById('M' +id + '_indicator').style.display = 'none';
            document.getElementById('D' +id + '_indicator').style.display = 'none';
            document.getElementById('D' + id + '_price').innerHTML = '';
            document.getElementById('M' + id + '_price').innerHTML = '';
            document.getElementById('D' + id + '_perTenure').innerHTML = '';
            document.getElementById('M' + id + '_perTenure').innerHTML = '';
            var element = document.getElementById(id + '_btn');
            element.classList.add('disableButton');
            element.disabled = true;
            document.getElementById(id + '_info').style.display = '';
        }
    } catch (e) {
        console.error('Error parsing JSON or accessing price:', e);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    AOS.init();
    getPrices(<?php echo SHINE_DENTAL_PRODUCT_ID; ?>);
    getPrices(<?php echo SHINE_COMPLETE_PRODUCT_ID; ?>);
    getPrices(<?php echo SHINE_PERK_PRODUCT_ID; ?>);
});
</script>

<div class="savings-plans-wrapper row-flex justify-content-between" id="shine_pricing">

<?php
global $wpdb;

    $current_user = wp_get_current_user();
    $user_id = @$current_user->ID;
    $result = $wpdb->get_row($wpdb->prepare("SELECT product_id FROM sbr_subscription_details WHERE user_id = " . $user_id . " AND subscription_id > 0 AND `status` = 1 AND (shine_group_code <> 0 OR product_id = " . SHINE_PERK_PRODUCT_ID . ")"), ARRAY_A);

    foreach ($post_data as $key => $data) {

        if ($key == SHINE_DENTAL_PRODUCT_ID) {
            $field = get_field('define_shine_membership_plans', $key);

            //if(in_array(, $result))
            ?>
<div class="savings-card-wrapper card-saving-one <?php echo ($result && in_array(SHINE_DENTAL_PRODUCT_ID, $result) ? 'disabled_card' : ''); ?>" data-aos="slide-up" data-aos-delay="0">
    <div class="saving-card-header" style="background:#eeeeee;" >
        <div class="shine-smile-logo rounded-shine-smile">
            <img class="img-fluid"
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-package-1.png"
                alt="Shine" />
            <!-- <span class="shine-tesectionRgtxt">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-text-white.png" alt="Shine" />
            </span>
            <div class="shine-smile-symbal">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/smile.png" />
            </div>  -->
        </div>
        <div class="shine-text-wrap">
            <span class="shine-text heading-clr">SH<span class="yellow-text"
                    style="color:#f0c23a">!</span>NE</span>
            <span class="text-wrap-two">Dental</span>
        </div>

        <div class="priceHeaderMobile">
            <div class="saving-price-wrapper"><span class="currency-indicator" id="M<?php echo $key; ?>_indicator">$</span><div id="D<?php echo $key; ?>_price"></div><span
                    class="charges-yearly" id="D<?php echo $key; ?>_perTenure"></span></div>
        </div>


    </div>

    <div class="saving-shine-content">
        <div class="saving-price-wrapper"  data-aos="fade-up" data-aos-delay="0" ><span class="currency-indicator" id="D<?php echo $key; ?>_indicator">$</span><div id="M<?php echo $key; ?>_price"></div><span
                class="charges-yearly" id="M<?php echo $key; ?>_perTenure"></span></div>

        <div class="sbr-logo-with-option row-flex align-items-center">
            <div class="sbr-round-logo"  data-aos="fade-up" data-aos-delay="0" >
                <img class="img-fluid"
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo.png"
                    alt="Smilebrillilant" />
            </div>
            <div class="plus-indicator"  data-aos="fade-up" data-aos-delay="50" >
                +
            </div>
            <div class="aetna-logo-wrap"  data-aos="fade-up" data-aos-delay="100" >
                <div class="enhanced-width open-sans italic">
                    featuring
                </div>
                <div class="aetna-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/aetna-logo.png"
                        alt="aetna" />
                </div>
                <div class="dental-access">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/dental-access-text-r.png"
                        alt="Dental Access" />
                </div>
                <div class="eligible-text">
                    ELIGIBLE
                </div>
            </div>
        </div>


        <div class="tags-options row-flex"  data-aos="fade-up" data-aos-delay="0" >
            <span class="sbr-tag-default sbr-tag-smile " style="background: #4597cb;">+ SMILE
                BRILLIANT</span>
            <span class="sbr-tag-default sbr-dental " style="background: #00bbb4;">+ DENTAL</span>
            <span class="sbr-tag-default sbr-no-vision disable-tag" style="background: #eeeeee;">no
                VISION</span>
            <span class="sbr-tag-default  sbr-no-rx disable-tag" style="background: #eeeeee;">no
                RX</span>
        </div>


        <div class="shine-product-description">
            <ul  data-aos="fade-up" data-aos-delay="0" >
                <li>Shine Member Perks package included</li>
                <li>Aetna Dental Access® In-office savings (262,000+ Providers)</li>
                <li><i> $15 One-time registration fee</i></li>
            </ul>
            <span id="<?php echo $key; ?>_info" class="combinationNotAvailable" style="display:none;">This combination of Package is not available.</span>
        </div>

        <div class="dropdown-selection"  data-aos="fade-up" data-aos-delay="0" >
            <div class="form-group">
                <label>Payment Frequency:</label>
                <div class="select-option">
                <select name="frequency" id="<?php echo $key; ?>_frequency" onchange="getPrices(<?php echo $key; ?>)">
                    <?php
$prices = [];
            $indexes = [];
            $pcombinations = [];
            foreach ($field as $index => $values) {

                if (!array_key_exists(@$values['billingshipping_frequency']['value'], $prices)) {
                    if ($affiliate_version != '' && $affiliate_version == 'yes') {
                        if (@$values['billingshipping_frequency']['value'] == 30 || @$values['billingshipping_frequency']['label'] == 'Monthly') {
                            continue;
                        }

                    }
                    echo "<option value='" . @$values['billingshipping_frequency']['value'] . "'>" . @$values['billingshipping_frequency']['label'] . "</option>";
                    $prices[@$values['billingshipping_frequency']['value']] = @$values['price'];
                }
                $indexes[$key . '_' . @$values['plan_type']['value'] . '_' . @$values['billingshipping_frequency']['value']] = $index;
                $pcombinations[$key . '_' . @$values['plan_type']['value'] . '_' . @$values['billingshipping_frequency']['value']] = @$values['price'];
            }
            ?>
                    <input type="hidden" name="combinations" id="<?php echo htmlspecialchars($key); ?>_combinations" indexs="<?php echo htmlspecialchars(json_encode($indexes), ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars(json_encode($pcombinations), ENT_QUOTES, 'UTF-8'); ?>">

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Quantity of Members:</label>
                <div class="select-option">
                    <select name="members" id="<?php echo $key; ?>_members" onchange="getPrices(<?php echo $key; ?>)">
                        <?php
$discounts = [];
            foreach ($field as $index => $values) {
                if (!array_key_exists(@$values['plan_type']['value'], $discounts)) {

                    echo "<option value='" . @$values['plan_type']['value'] . "' >" . @$values['plan_type']['label'] . "</option>";
                    $discounts[@$values['plan_type']['value']] = @$values['discount-amount'];
                }
            }
            ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="add-to-cart-btn">
        <button class="btn btn-primary add_to_cart_button ajax_add_to_cart" data-arbid="0" data-shine="1" href="?add-to-cart=<?php echo $key; ?>" data-quantity="1" data-product_id="<?php echo $key; ?>" id="<?php echo $key; ?>_btn">Add to Cart</button>

        </div>
    </div>

</div>
<!-- Ends card one -->
<?php
} else if ($key == SHINE_COMPLETE_PRODUCT_ID) {
            $field = get_field('define_shine_membership_plans', $key);
            ?>
<div class="savings-card-wrapper card-saving-best-value <?php echo ($result && in_array(SHINE_COMPLETE_PRODUCT_ID, $result) ? 'disabled_card' : ''); ?>" data-aos="slide-up" data-aos-delay="50">

    <div class="saving-card-header" style="background:#4acac9">
        <div class="shine-smile-logo rounded-shine-smile">
            <img class="img-fluid"
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-package-2.png"
                alt="Shine" />
            <!-- <span class="shine-text">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-text-white.png" alt="Shine" />
            </span>
            <div class="shine-smile-symbal">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/smile.png" />
            </div> -->

        </div>

        <div class="shine-text-wrap">
            <span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE</span>
            <span class="text-wrap-two">Complete</span>
        </div>


        <div class="priceHeaderMobile">
            <div class="saving-price-wrapper"><span class="currency-indicator" id="M<?php echo $key; ?>_indicator">$</span><div id="D<?php echo $key; ?>_price"></div><span
                    class="charges-yearly" id="D<?php echo $key; ?>_perTenure"></span></div>
        </div>

    </div>

    <div class="saving-shine-content">
        <div class="saving-price-wrapper"  data-aos="fade-up" data-aos-delay="0"  ><span class="currency-indicator" id="D<?php echo $key; ?>_indicator">$</span><div id="M<?php echo $key; ?>_price"></div><span
                class="charges-yearly" id="M<?php echo $key; ?>_perTenure"></span></div>
        <div class="sbr-logo-with-option row-flex align-items-center">
            <div class="sbr-round-logo"  data-aos="fade-up" data-aos-delay="50" >
                <img class="img-fluid"
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo.png"
                    alt="Smilebrillilant" />
            </div>
            <div class="plus-indicator"  data-aos="fade-up" data-aos-delay="50" >+</div>
            <div class="aetna-logo-wrap"  data-aos="fade-up" data-aos-delay="70" >
                <div class="enhanced-width open-sans italic">
                    featuring
                </div>
                <div class="aetna-logo">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/aetna-logo.png"
                        alt="aetna" />
                </div>
                <div class="dental-access">
                    <img class="img-fluid"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/dental-access-text-r.png"
                        alt="Dental Access" />
                </div>
                <div class="eligible-text">
                    ELIGIBLE
                </div>
            </div>
            <div class="plus-indicator"  data-aos="fade-up" data-aos-delay="90" >+</div>
            <div class="product-graphic"  data-aos="fade-up" data-aos-delay="100" >
                <img class="img-fluid"
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/rfx-feature-logo.png"
                    alt="Rfx" style="max-width:95.5px" />
            </div>
        </div>


        <div class="tags-options row-flex"  data-aos="fade-up" data-aos-delay="0" >
            <span class="sbr-tag-default sbr-tag-smile " style="background: #4597cb;">+ SMILE
                BRILLIANT</span>
            <span class="sbr-tag-default sbr-dental " style="background: #00bbb4;">+ DENTAL</span>
            <span class="sbr-tag-default sbr-vision" style="background: #f5e2aa;">+ VISION</span>
            <span class="sbr-tag-default  sbr-rx" style="background: #002244;">+ RX</span>
        </div>


        <div class="shine-product-description">
            <ul  data-aos="fade-up" data-aos-delay="0" >
                <li>Shine Member Perks package included</li><!-- with This package. -->
                <li>Aetna Dental Access® In-office savings (262,000+ Providers)</li>
                <li>Vision / Eyewear Savings (20,000+ vision centers)</li>
                <li>Rx Prescription Drug Savings (65,000+ major pharmacies)</li>
                <li class="italic">$15 One-time registration fee</li>
            </ul>
            <span class="combinationNotAvailable" id="<?php echo $key; ?>_info" style="display:none;">This combination of Package is not available.</span>
        </div>

        <div class="dropdown-selection"  data-aos="fade-up" data-aos-delay="0" >
            <div class="form-group">
                <label>Payment Frequency:</label>
                <div class="select-option">
                <select name="frequency" id="<?php echo $key; ?>_frequency" onchange="getPrices(<?php echo $key; ?>)">
                    <?php
$prices = [];
            $indexes = [];
            $pcombinations = [];
            foreach ($field as $index => $values) {
                if (!array_key_exists(@$values['billingshipping_frequency']['value'], $prices)) {
                    if ($affiliate_version != '' && $affiliate_version == 'yes') {
                        if (@$values['billingshipping_frequency']['value'] == 30 || @$values['billingshipping_frequency']['label'] == 'Monthly') {
                            continue;
                        }
                    }
                    echo "<option value='" . @$values['billingshipping_frequency']['value'] . "'>" . @$values['billingshipping_frequency']['label'] . "</option>";
                    $prices[@$values['billingshipping_frequency']['value']] = @$values['price'];
                }
                $indexes[$key . '_' . @$values['plan_type']['value'] . '_' . @$values['billingshipping_frequency']['value']] = $index;
                $pcombinations[$key . '_' . @$values['plan_type']['value'] . '_' . @$values['billingshipping_frequency']['value']] = @$values['price'];
            }
            ?>
                    <input type="hidden" name="combinations" id="<?php echo htmlspecialchars($key); ?>_combinations" indexs="<?php echo htmlspecialchars(json_encode($indexes), ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars(json_encode($pcombinations), ENT_QUOTES, 'UTF-8'); ?>">

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Quantity of Members:</label>
                <div class="select-option">
                    <select name="members" id="<?php echo $key; ?>_members" onchange="getPrices(<?php echo $key; ?>)">
                        <?php
$discounts = [];
            foreach ($field as $index => $values) {
                if (!array_key_exists(@$values['plan_type']['value'], $discounts)) {

                    echo "<option value='" . @$values['plan_type']['value'] . "' >" . @$values['plan_type']['label'] . "</option>";
                    $discounts[@$values['plan_type']['value']] = @$values['discount-amount'];
                }
            }
            ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="add-to-cart-btn">
        <button class="btn btn-primary add_to_cart_button ajax_add_to_cart" data-arbid="0" data-shine="1" href="?add-to-cart=<?php echo $key; ?>" data-quantity="1" data-product_id="<?php echo $key; ?>" id="<?php echo $key; ?>_btn">Add to Cart</button>

        </div>
    </div>

</div>
<!-- Ends card Best  value -->
<?php
} else if ($key == SHINE_PERK_PRODUCT_ID) {
            $field = get_field('define_shine_membership_plans', $key);
            ?>
<div class="savings-card-wrapper card-saving-perks <?php echo ($result && in_array(SHINE_PERK_PRODUCT_ID, $result) ? 'disabled_card' : ''); ?>" data-aos="slide-up" data-aos-delay="100">
    <div class="saving-card-header" style="background:#eeeeee">
        <div class="shine-smile-logo rounded-shine-smile">
            <img class="img-fluid"
                src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/shine-package-3.png"
                alt="Shine" />
            <!-- <span class="shine-text">Sh<span class="yellow-text"  style="color:#f0c23a">!</span>ne</span>
            <div class="shine-smile-symbal">
                <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/smile.png" />
            </div> -->


        </div>
        <div class="shine-text-wrap">
            <span class="shine-text">SH<span class="yellow-text" style="color:#f0c23a">!</span>NE</span>
            <span class="text-wrap-two">Perks</span>
        </div>

        <div class="priceHeaderMobile">
            <div class="saving-price-wrapper"><span class="currency-indicator" id="M<?php echo $key; ?>_indicator">$</span><div id="D<?php echo $key; ?>_price"></div><span class="charges-yearly" id="D<?php echo $key; ?>_perTenure"></span></div>
        </div>


    </div>

    <div class="saving-shine-content">
        <div class="saving-price-wrapper"  data-aos="fade-up" data-aos-delay="0" ><span class="currency-indicator" id="D<?php echo $key; ?>_indicator">$</span><div id="M<?php echo $key; ?>_price"></div><span
                class="charges-yearly" id="M<?php echo $key; ?>_perTenure"></span></div>
        <div class="sbr-logo-with-option row-flex align-items-center" >
            <div class="sbr-round-logo"  data-aos="fade-up" data-aos-delay="50" >
                <img class="img-fluid"
                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/sbr-logo.png"
                    alt="Smilebrillilant" />
            </div>
            <div class="perks-option"  data-aos="fade-up" data-aos-delay="100" >
                <div class="member-text">member</div>
                <div class="perks-text"><strong>PERKS</strong></div>
            </div>
        </div>


        <div class="tags-options row-flex"  data-aos="fade-up" data-aos-delay="0" >
            <span class="sbr-tag-default sbr-tag-smile " style="background: #4597cb;">+ SMILE
                BRILLIANT</span>
            <span class="sbr-tag-default sbr-dental disable-tag" style="background: #eeeeee;">no
                DENTAL</span>
            <span class="sbr-tag-default sbr-no-vision disable-tag" style="background: #eeeeee;">no
                VISION</span>
            <span class="sbr-tag-default  sbr-no-rx disable-tag" style="background: #eeeeee;">no
                RX</span>
        </div>


        <div class="shine-product-description">
            <ul  data-aos="fade-up" data-aos-delay="0" >
                <li>20-70% off Smile Brilliant & partner websites</li>
                <!-- <li>Lifetime free shipping</li> -->
                <li>First access to exclusive sales & product sampling</li>
                <li>Free order bumps and priority lab processing</li>
                <li>Extended warranties & free order protection</li>
                <li>Can be used by family & friends as well</li>
            </ul>
            <span class="combinationNotAvailable" id="<?php echo $key; ?>_info" style="display:none;">This combination of Package is not available.</span>
        </div>

        <div class="dropdown-selection"  data-aos="fade-up" data-aos-delay="0" >
            <div class="form-group">
                <label>Payment Frequency:</label>
                <div class="select-option">
                    <select name="frequency" id="<?php echo $key; ?>_frequency" onchange="getPrices(<?php echo $key; ?>)">
                    <?php
$prices = [];
            $indexes = [];
            $pcombinations = [];
            foreach ($field as $index => $values) {
                if (!array_key_exists(@$values['billingshipping_frequency']['value'], $prices)) {
                    if ($affiliate_version != '' && $affiliate_version == 'yes') {
                        if (@$values['billingshipping_frequency']['value'] == 30 || @$values['billingshipping_frequency']['label'] == 'Monthly') {
                            continue;
                        }
                    }
                    echo "<option value='" . @$values['billingshipping_frequency']['value'] . "'>" . @$values['billingshipping_frequency']['label'] . "</option>";
                    $prices[@$values['billingshipping_frequency']['value']] = @$values['price'];
                }
                $indexes[$key . '_' . @$values['plan_type']['value'] . '_' . @$values['billingshipping_frequency']['value']] = $index;
                $pcombinations[$key . '_' . @$values['plan_type']['value'] . '_' . @$values['billingshipping_frequency']['value']] = @$values['price'];
            }
            ?>
                    <input type="hidden" name="combinations" id="<?php echo htmlspecialchars($key); ?>_combinations" indexs="<?php echo htmlspecialchars(json_encode($indexes), ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars(json_encode($pcombinations), ENT_QUOTES, 'UTF-8'); ?>">

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Quantity of Members:</label>
                <div class="select-option">
                    <select name="members" id="<?php echo $key; ?>_members" onchange="getPrices(<?php echo $key; ?>)">
                        <?php
$discounts = [];
            foreach ($field as $index => $values) {
                if (!array_key_exists(@$values['plan_type']['value'], $discounts)) {
                    if (in_array(@$values['plan_type']['value'], ['individual', 'couples'])) {
                        continue;
                    }
                    //".@$values['plan_type']['label']."
                    echo "<option value='" . @$values['plan_type']['value'] . "' >Unlimited</option>";
                    $discounts[@$values['plan_type']['value']] = @$values['discount-amount'];
                }
            }
            ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="add-to-cart-btn">
            <button class="btn btn-primary add_to_cart_button ajax_add_to_cart" data-arbid="0" data-shine="1" href="?add-to-cart=<?php echo $key; ?>" data-quantity="1" data-product_id="<?php echo $key; ?>" id="<?php echo $key; ?>_btn">Add to Cart</button>

        </div>
    </div>

</div>


<!-- Ends card Best  value -->
<?php
}
        ?>
<?php
}
    ?>

</div>


<?php
}
