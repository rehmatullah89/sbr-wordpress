<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();
$myaddresses = current_user_shipping_addresses();
if (count($myaddresses) == 0) {
    creat_initila_address_from_default();
}
if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            //   'billing' => __('Billing address', 'woocommerce'),
            'shipping' => __('Shipping address', 'woocommerce'),
        ),
        $customer_id
    );
} else {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
			'billing' => __( 'Billing address', 'woocommerce' ),
        ),
        $customer_id
    );
}

$oldcol = 1;
$col    = 1;
?>

<div class="d-flex align-items-center menuParentRowHeading menuParentRowHeadingBillingShipping borderBottomLine">
    <div class="pageHeading_sec ">
        <span><span class="text-blue">Shipping</span>Manage your shipping addresses..</span>
        <!-- <span><span class="text-blue">Billing & Shipping</span>Manage shipping and billings.</span> -->
    </div>
</div>
<div class="apnd-res">
    <?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) :

$message_form = get_transient('shipping_address_message');
if (!$message_form) {
    //       
} else {
    echo '<div class="alert alert-success">';
    echo '<ul>';
    echo $message_form;
    echo '</ul>';
    echo '</div>';
    delete_transient('shipping_address_message');
}
?>
</div>
    </div>
   
    <div class="row rowSpacing addresBoxesContainer">
        <div class="col-sm-4">
            <div class="addAddressBox">
                <a href="<?php echo site_url('my-account/edit-shipping-address/add'); ?>" class="addAddressAnchor d-flex align-items-center justify-content-center">
                    <div class="plusIcon">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                    <h4>Add Address</h4>
                </a>
            </div>
        </div>

        <?php
        $myaddresses = current_user_shipping_addresses();
        if (is_array($myaddresses) && count($myaddresses) > 0) {
            foreach ($myaddresses as $rr) {
                $default_html = '';
                $cls = '';
                if ($rr['is_default'] == 1) {
                    $cls = ' def';
                    $default_html = '<span>Default:</span>
                                <img src="' . get_stylesheet_directory_uri() . '/assets/images/smilebrilliant-logo-small.png" alt="" width="" height="" class="img-fluid"/>';
                }
        ?>
                <div class="col-sm-4<?php echo $cls; ?>" id="add-section-<?php echo $rr['id']; ?>">
                    <div class="addressBox">
                        <div class="boxHeader">
                            <div class="d-flex align-items-center">
                                <?php echo $default_html; ?>
                            </div>
                        </div>
                        <div class="addressBoxBody">
                            <p>
                                <strong class="kkk"><?php echo stripslashes($rr['shipping_first_name']); ?> <?php echo stripslashes($rr['shipping_last_name']); ?></strong><br>
                                <?php echo stripslashes($rr['shipping_address_1']); ?><br>
                                <?php echo stripslashes($rr['shipping_address_2']); ?><br>
                                <?php echo stripslashes($rr['shipping_country']); ?>, <?php echo stripslashes($rr['shipping_state']); ?> <?php echo stripslashes($rr['shipping_postcode']); ?>
                            </p>
                        </div>
                        <div class="addressBoxFooter">
                            <div class="d-flex align-items-center">
                                <a href="<?php echo site_url('my-account/edit-shipping-address/' . $rr['id']); ?>">
                                    Edit
                                </a>
                                <div class="not-del">
                                    <span class="sepratorLine"></span>
                                    <a href="javascript:;" data-toggle="modal" data-target="#deleteAddress" onClick="remove_shipping_address_initial('<?php echo $rr['id'];?>')">
                                        Remove
                                    </a>
                                    <span class="sepratorLine"></span>
                                    <a href="javascript:;" onClick="set_as_default_shipping_address('<?php echo $rr['id'];?>')">
                                        Set as Default
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?PHp
            }
        }
        ?>


        <script>
            var addid;
            function remove_shipping_address(address_id) {
                address_id = addid;
                id_to_target = '#add-section-' + address_id;
                jQuery('.loading-sbr').show();
                jQuery.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: 'action=remove_shipping_address_mbt&address_id=' + address_id,
                    success: function(res) {
                        jQuery('.loading-sbr').hide();
                        $('#deleteAddress').modal('toggle');
                        if (res.includes('success')) {
                            jQuery('.apnd-res').html('<div class="alert alert-success"> Address is deleted</div>');
                            jQuery(id_to_target).remove();
                        }
                    }
                });

            }
            function remove_shipping_address_initial(address_id) {
               parent_id = '#add-section-'+address_id;
                var address_info = jQuery(parent_id).find('.addressBoxBody').html();
                console.log(address_info);
                jQuery('.delboxdata').html(address_info);
                addid = address_id;
                
            }
            function set_as_default_shipping_address(address_id) {
               
                id_to_target = '#add-section-' + address_id;
                jQuery('.loading-sbr').show();
                jQuery.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: 'action=set_as_default_shipping_address_mbt&address_id=' + address_id,
                    success: function(res) {
                        jQuery('.loading-sbr').hide();
                        if (res.includes('success')) {
                            jQuery('.boxHeader').html('');
                            jQuery('.col-sm-4').removeClass('def');
                            jQuery(id_to_target).addClass('def');
                            jQuery(id_to_target).find('.boxHeader').html('<div class="d-flex align-items-center"><span>Default:</span><img src="https://www.smilebrilliant.com/wp-content/themes/revolution-child/assets/images/smilebrilliant-logo-small.png" alt="" width="" height="" class="img-fluid"></div>');
                            jQuery('.apnd-res').html('<div class="alert alert-success"> Default address is updated</div>');
                        }
                    }
                });
            }
        </script>
        <style>
            .def .not-del {
                display: none;
            }
        </style>
    </div>


    <style>
        .modal-backdrop.fade.show {
            display: none !important;
        }
        .backdropShahdow{ 
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            background-color: #00000070;
            display:none;
         }
         .deleteAddressPopup .modal-header{    padding: 0.5rem;}
         .deleteAddressPopup .addressBoxBody p {color: #000;}
    </style>

    <!-- Modal -->
    <div class="backdropShahdow"></div>
    <div class="modal fade deleteAddressPopup" id="deleteAddress" tabindex="-1" aria-labelledby="deleteAddressLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Confirm Removal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="addressBoxBody delboxdata">
                        
                    </div>
                    <p class="deleteNote"><strong>Please note:</strong> Removing this address will not affect any pending order being shipped to this address. To ensure uninterrupted fulfillment of future order, please update any wishlists, subscribe and save setting and periodical subscriptions using this address.</p>
                </div>
                <div class="modal-footer">


                    <a href="javascript:;" class="buttonDefault" data-dismiss="modal">No</a>
                    <a href="javascript:;" class="buttonDefault blueBg delboxbutton" onClick="remove_shipping_address()">Yes</a>                    
                </div>
            </div>
        </div>
    </div>

<?php
endif;
