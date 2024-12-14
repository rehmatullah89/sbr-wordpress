<?php
/**
 * Payment methods
 *
 * Shows customer payment methods on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/payment-methods.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.9.0
 */

defined( 'ABSPATH' ) || exit;

$saved_methods = wc_get_customer_saved_methods_list(get_current_user_id());

// echo '<pre>';
// print_r($saved_methods);
// echo '</pre>';
global $wpdb;
$has_methods = (bool) $saved_methods;
//$has_methods   = (bool) false;  //$saved_methods;
$types = wc_get_account_payment_methods_types();
$customer_profile_id = get_user_meta(get_current_user_id(), USER_CIM_PROFILE_ID, true);
do_action('woocommerce_before_account_payment_methods', $has_methods);
?>

<?php if ($has_methods) :
?>
    <style>
        .myAccountContainerMbtInnerMobile {
            padding-left: 0px;
            padding-right: 0px;
        }
    </style>

    <div class="d-flex align-items-center menuParentRowHeading paymentMethodFileParent borderBottomLine billingMethodHeading">
        <div class="pageHeading_sec">
            <span><span class="text-blue">Billing</span>Manage billing methods.</span>
        </div>
    </div>
    <?php
    wc_print_notices();
    ?>
    <div class="repsonsive-tabel payment-mode-mbt paymentModeWrapper db-row">
        <?php if (WC()->payment_gateways->get_available_payment_gateways()) : ?>
            <!-- <div class="col-md-6 ">
                <a class="button addPaymentMethod pyamentButtionBilling v_desktop" href="<?php echo esc_url(wc_get_endpoint_url('add_payment_card')); ?>">
                
                    <div class="plusIcon">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                    <h4><?php //esc_html_e('Add payment method', 'woocommerce'); ?></h4>
                </a>
            </div> -->
        <?php endif; ?>
        <?php
        foreach ($saved_methods as $type => $methods) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 

            foreach ($methods as $method) :
                $payment_profile_id = $method['token'];
                $hsa_fsa = $wpdb->get_var("SELECT  meta_value FROM {$wpdb->prefix}woocommerce_payment_tokens token inner join {$wpdb->prefix}woocommerce_payment_tokenmeta tokenmeta on token.token_id=tokenmeta.payment_token_id  WHERE token.token = $payment_profile_id AND tokenmeta.meta_key = 'hsa_fsa'");

                // echo '<pre>';
                // print_r($method);
                // echo '</pre>';
        ?>

                <div class="col-md-6 payment-methods-mbt">
                    <div class="sbr-payment-method<?php echo !empty($method['is_default']) ? ' default-payment-method' : ''; ?>">
                        <?php if (!empty($method['is_default'])) : ?>
                            <div class="defaultPaymentMethodSet">
                                <div class="boxHeader">
                                    <div class="d-flex align-items-center">
                                        <span>Default</span>
                                        <!-- <img src="<?php //echo get_stylesheet_directory_uri(); 
                                                        ?>/assets/images/smilebrilliant-logo-small.png" alt="" class="img-fluid" /> -->
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="paymentHeaderSec">
                            <div class="r1-payment ">
                                <?php
                                $hfsClass = '';
                                if ($hsa_fsa == 'yes') {
                                    $hfsClass = 'hsaFsaCard';
                                } ?>
                                <div class="r1-c1-payment clearfix  <?php echo $hfsClass; ?>">
                                    <div class="r1-c2-paymentHook clearfix">
                                        <?php
                                        if ($hsa_fsa == 'yes') {
                                            echo  '<div class="hsa_fsa_true showhsaFsa"></div>';
                                        } else {
                                            do_action('woocommerce_account_payment_methods_column_details', $method);
                                        }

                                        ?>
                                    </div>

                                    <div class="r1-c2-payment clearfix">
                                        <?php do_action('woocommerce_account_payment_methods_column_title', $method);

                                        echo '<div class="buttonsItemTap ">';


                                        if (isset($method['actions']['edit']['url'])) {
                                            echo '<a href="javascript:;" class="button edit buttionEdit buttoneditClick"></i></a>';
                                        }
                                        if (isset($method['actions']['save']['url'])) {
                                            echo '<a href="javascript:;" class="button save buttonSaveButton" style="display:none">Done</a>';
                                        }
                                        echo '</div>';

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="paymentLowerHeader">
                            <div class="r2-payment d-flex justify-content-between">
                                <div class="r2-c1-payment">
                                    <div class="tpParentMbtHsa">
                                        <div class="endingExpiring">
                                            <span>xxxx-xxxx-xxxx-</span>
                                            <span><? echo sprintf(esc_html__('%1$d', 'woocommerce'), esc_html($method['method']['last4'])); ?></span>
                                        </div>
                                    </div>


                                </div>

                                <div class="r2-c2-payment">
                                    <div class="endingExpiring">
                                        <span>Expiring on:</span>
                                        <strong><?php echo esc_html($method['expires']); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="paymentBody">
                            <div class="r3-payment authorize-customer-info" id="payment_profile-<?php echo $method['token']; ?>" data-customer_profile_id="<?php echo $customer_profile_id; ?>" data-tok="<?php echo $method['token']; ?>">
                                <?php
                                // $infoD =  getCustomerPaymentProfile($customer_profile_id, $method['token']);
                                // $html = '';
                                // if ($infoD) {
                                // 	$info = $infoD['paymentProfile']['billTo'];
                                // 	$html .= '<p>';
                                // 	$html .= $info['firstName'] . ' ' . $info['lastName'] . '</br>';
                                // 	$html .= $info['address'] . '</br>';
                                // 	$html .= $info['city'] . '</br>';
                                // 	$html .= $info['state'] . '(' . $info['zip'] . ')' . $info['country'];
                                // 	$html .= '</p>';
                                // }
                                // echo $html;
                                ?>
                            </div>
                        </div>

                        <div class="paymentFooter">
                            <div class="r4-payment d-flex align-items-center">
                                <div class="r4-c1-payment">
                                    <?php
                                    if (isset($method['actions']['delete']['url'])) {
                                        echo '<a href="' . esc_url($method['actions']['delete']['url']) . '" class="button delete">Delete</a>';
                                    }
                                    ?>
                                </div>
                                <div class="r4-c2-payment">

                                    <?php
                                    if (isset($method['actions']['default']['url'])) {
                                        echo ' <span class="sepratorLine"></span>';
                                        echo '<a href="' . esc_url($method['actions']['default']['url']) . '" class="button default">Make Default</a>';
                                    }
                                    ?>
                                </div>
                                <div class="r4-c3-payment">

                                    <?php
                                    if (isset($method['token'])) {
                                        echo ' <span class="sepratorLine"></span>';
                                       // echo '<a href="' . esc_url(wc_get_endpoint_url('edit_payment_card') . $method['token']) . '" class="button default">Edit Information</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
        <?php
            endforeach;
        endforeach;
        ?>




    </div>
    <script>
        var html_loader = '<div class="wrapper-cell paymentMthodLoadingWrapp"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
        var current_iteration = 0;
        var numItems;
        jQuery(".sbr-payment-method").on("click", ".button.delete", function(e) {
            if (confirm('Are you sure you want to delete this payment method?') == true) {
                void 0;
            } else {
                e.preventDefault();
            }
        });
        jQuery(".sbr-payment-method").on("click", ".button.save", function(e) {
            //	return o.save_method(e)
            jQuery('.loading-sbr').show();
            var currentItem = jQuery(this);
            var token_id = jQuery(this).parents(".sbr-payment-method").find("input[name=token-id]").val();
            var nickname = jQuery(this).parents(".sbr-payment-method").find("input[name=nickname]").val();
            jQuery.ajax({
                url: ajaxurl + '?action=saveNickCIM&token_id=' + token_id + '&nickname=' + nickname,
                data: {},
                type: 'POST',
                success: function(response) {
                    jQuery('.loading-sbr').hide();
                    currentItem.parents(".sbr-payment-method").find("div.view").html(nickname);
                    //console.log(currentItem.parents(".sbr-payment-method").find(".cancel-edit"));
                    //console.log(currentItem.parents(".sbr-payment-method"));
                    currentItem.parents(".sbr-payment-method").find(".cancel-edit").trigger('click');
                }
            });
        });
        jQuery(".sbr-payment-method").on("click", ".button.edit", function(e) {
            //return o.cancel_edit(e)
            jQuery(this).parents(".sbr-payment-method").find("div.view").hide();
            jQuery(this).parents(".sbr-payment-method").find("div.edit").show().addClass("editing editingSectionPanel");
            jQuery(this).parents(".sbr-payment-method").find(".button.save").show();
            jQuery(this).text('').removeClass("edit").addClass("cancel-edit");
        });
        jQuery(".sbr-payment-method").on("click", ".button.cancel-edit", function(e) {
            jQuery(this).parents(".sbr-payment-method").find("div.view").show();
            jQuery(this).parents(".sbr-payment-method").find(".button.save").hide();
            jQuery(this).parents(".sbr-payment-method").find("div.edit").hide().removeClass("editing editingSectionPanel");
            jQuery(this).text('').removeClass("cancel-edit").addClass("edit");
        });

        function load_payment_profile_data(current) {
            //console.log(numItems);
            //console.log(current);
            //tok = jQuery('authorize-customer-info').nth-child(current).attr('data-tok');
            //tok = jQuery('.payment-mode-mbt .payment-methods-mbt:nth-child(' + current + ')').find('.authorize-customer-info').attr('data-tok');
            //profile_id = jQuery('.payment-mode-mbt .payment-methods-mbt:nth-child(' + current + ')').find('.authorize-customer-info').attr('data-customer_profile_id');
            //profile_id = jQuery('.authorize-customer-info:nth-child('+current+')').attr('data-customer_profile_id');
            //console.log(current_iteration);
            //console.log(profile_id);
            tok = jQuery('.payment-mode-mbt .payment-methods-mbt').eq(current).find('.authorize-customer-info').attr('data-tok');
            profile_id = jQuery('.payment-mode-mbt .payment-methods-mbt').eq(current).find('.authorize-customer-info').attr('data-customer_profile_id');

            id_dynamic = '#payment_profile-' + tok;

            if (profile_id != '' && tok != '') {
                jQuery.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: 'action=getCustomerPaymentProfile_ajax&profile_id=' + profile_id + '&tok=' + tok,
                    success: function(res) {
                        if (res != '') {
                            jQuery(id_dynamic).html(res);
                            current_iteration = current_iteration + 1;
                            if (current_iteration <= numItems) {

                                load_payment_profile_data(current_iteration);
                            }

                        }
                    }
                });
            }
        }
        jQuery(document).ready(function() {
            numItems = jQuery('.authorize-customer-info').length;
            numItems = numItems + 1;
            jQuery('.authorize-customer-info').html(html_loader);
            load_payment_profile_data(current_iteration);
        });
    </script>

    <div class="repsonsive-tabel payment-mode-mbt hidden">
        <table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table">
            <thead>
                <tr>
                    <?php
                    foreach (wc_get_account_payment_methods_columns() as $column_id => $column_name) :
                        if ($column_id == 'default') {
                    ?>
                            <th class="woocommerce-PaymentMethod"><span class="nobr">Billing Address</span></th>
                        <?php
                            continue;
                        }
                        ?>
                        <th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr($column_id); ?> payment-method-<?php echo esc_attr($column_id); ?>"><span class="nobr"><?php echo esc_html($column_name); ?></span></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <?php foreach ($saved_methods as $type => $methods) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
            ?>
                <?php
                foreach ($methods as $method) :
                ?>
                    <tr class="payment-method<?php echo !empty($method['is_default']) ? ' default-payment-method' : ''; ?>">
                        <?php
                        foreach (wc_get_account_payment_methods_columns() as $column_id => $column_name) :

                            if ($column_id == 'default') {
                        ?>

                                <td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr($column_id); ?> payment-method-<?php echo esc_attr($column_id); ?>" data-title="<?php echo esc_attr($column_name); ?>">
                                    <?php
                                    echo getCustomerPaymentProfile($customer_profile_id, $method['token']);
                                    ?>
                                </td>
                            <?php
                                continue;
                            }
                            ?>

                            <td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr($column_id); ?> payment-method-<?php echo esc_attr($column_id); ?>" data-title="<?php echo esc_attr($column_name); ?>">
                                <?php
                                if (has_action('woocommerce_account_payment_methods_column_' . $column_id)) {
                                    do_action('woocommerce_account_payment_methods_column_' . $column_id, $method);
                                } elseif ('method' === $column_id) {

                                    if (!empty($method['method']['last4'])) {
                                        /* translators: 1: credit card type 2: last 4 digits */
                                        echo sprintf(esc_html__('%1$s ending in %2$s', 'woocommerce'), esc_html(wc_get_credit_card_type_label($method['method']['brand'])), esc_html($method['method']['last4']));
                                    } else {
                                        echo esc_html(wc_get_credit_card_type_label($method['method']['brand']));
                                    }
                                } elseif ('expires' === $column_id) {
                                    echo esc_html($method['expires']);
                                    if (isset($method['is_default']) && $method['is_default'] == 1) {
                                        //echo '<span class="woocommerce-PaymentMethod woocommerce-PaymentMethod--default payment-method-default">';
                                        echo '- <mark class="default">Default</mark>';
                                        //echo '</span>';
                                    }
                                } elseif ('actions' === $column_id) {
                                    //echo '<a href="javascript:;" class="button" onclick="editPaymentProfile()">Edit Profile</a>&nbsp;';
                                    foreach ($method['actions'] as $key => $action) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                                        echo '<a href="' . esc_url($action['url']) . '" class="button ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a>&nbsp;';
                                    }
                                }
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
    </div>

<?php else : ?>

    <p class="woocommerce-Message woocommerce-Message--info woocommerce-info"><?php esc_html_e('No saved methods found.', 'woocommerce'); ?></p>
    <?php if (WC()->payment_gateways->get_available_payment_gateways()) : ?>


        <!-- <a class="button addPaymentMethod pyamentButtionBilling mobileeeee col-sm-4" href="<?php echo esc_url(wc_get_endpoint_url('add_payment_card')); ?>">
         
            <div class="plusIcon">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </div>
            <h4><?php //esc_html_e('Add payment method', 'woocommerce'); ?></h4>


            <?php //esc_html_e('Add payment method', 'woocommerce'); 
            ?>
        </a> -->
    <?php endif; ?>
<?php endif; ?>

<?php do_action('woocommerce_after_account_payment_methods', $has_methods); ?>