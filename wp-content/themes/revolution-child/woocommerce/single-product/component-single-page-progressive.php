<?php
/**
 * Single Page Progressive Component template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/component-single-page-progressive.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 4.0.0
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<style>
    .single .component_product_thumbnail_wrapper {
    max-width: 80px;
    float: left;
    margin-right: 11px;
}
.single .component_description p {
    font-size: 16px;
    line-height: 19px;
}
.single .composite_form .component_title_toggled .component_title_text:before {

    left: 7px;
}
.single .composite_form .component_title_toggled {
    display: inline-block;
    position: relative;
    line-height: 1em;
    margin-bottom: 1rem;
    cursor: pointer;
    display: block;
       background: #edededa3;
    font-size: 26px;
    padding-left: 1px;
    border-radius: 0px;
    font-weight: 500;
    padding-top: 6px;
    padding-bottom: 6px;    margin-bottom: 5px;
}
.single .component_inner {
    padding: 13px;    padding-bottom: 0rem !important;
}
.single .thb-product-detail .product-information p {
    font-size: 16px;
    margin-bottom: 0;
}
.single  .component .component_description {
    margin-bottom: 0em;
}
.composite_button {
    display: flex;
}    
.composite_wrap label.screen-reader-text {
  display: none !important;
}
.composite_wrap button.single_add_to_cart_button {
    width: 80%;
    text-transform: uppercase;
    font-size: 21px;
    border-radius: 0;
}
.composite_form .aria_button, .widget_composite_summary .aria_button:focus{ border: 0 !important;; outline: none !important; }
p.warranty_info {
    margin-top: 15px;
}
.composite_form:not(.paged) .composite_wrap {
    padding-top: 0rem;
}

.composite_form .composite_price p.price, .single-product .composite_form .composite_price p.price {
    margin: 0 0 11px;font-size: 20px;
}

</style>
<div id="component_<?php echo $component_id; ?>" class="<?php echo esc_attr(implode(' ', $component_classes)); ?>" data-nav_title="<?php echo esc_attr($component->get_title()); ?>" data-item_id="<?php echo $component_id; ?>" style="display:none;">

    <div class="component_title_wrapper"><?php
        wc_get_template('single-product/component-title.php', array(
            'step' => $step,
            'title' => $component->get_title(),
            'is_toggled' => in_array('toggled', $component_classes),
            'is_open' => in_array('open', $component_classes)
                ), '', WC_CP()->plugin_path() . '/templates/');
        ?></div>

    <div id="component_<?php echo $component_id; ?>_inner" class="component_inner" <?php echo in_array('toggled', $component_classes) && in_array('closed', $component_classes) ? 'style="display:none;"' : ''; ?>>

        <div class="block_component"></div>
        <?php
        $product_component_id = $component->get_image_data();
        if (isset($product_component_id['image_src']) && $product_component_id['image_src'] <> '') {
            echo '<div class="component_product_thumbnail_wrapper">';
            echo '<img src="' . $product_component_id['image_src'] . '" class="" alt="' . $product_component_id['image_title'] . '">';
            echo '</div>';
        }
        ?>
        <div class="component_description_wrapper"><?php
            if ($component->get_description() !== '') {
                wc_get_template('single-product/component-description.php', array(
                    'description' => $component->get_description()
                        ), '', WC_CP()->plugin_path() . '/templates/');
            }
            ?></div>
        <div class="component_selections"><?php
            /**
             * Action 'woocommerce_composite_component_selections_progressive'.
             *
             * @param  string                $component_id
             * @param  WC_Product_Composite  $product
             *
             * @hooked wc_cp_component_options_progressive_start     -  0
             * @hooked wc_cp_component_options_sorting               - 10
             * @hooked wc_cp_component_options_filtering             - 20
             * @hooked wc_cp_component_options_title                 - 30
             * @hooked wc_cp_component_options_pagination_top        - 39
             * @hooked wc_cp_component_options                       - 40
             * @hooked wc_cp_component_options_pagination_bottom     - 41
             * @hooked wc_cp_component_options_progressive_end       - 45
             * @hooked wc_cp_component_selection                     - 50
             * @hooked wc_cp_component_selection_message_progressive - 40
             */
            do_action('woocommerce_composite_component_selections_progressive', $component_id, $product);
            ?></div>
    </div>
</div>
