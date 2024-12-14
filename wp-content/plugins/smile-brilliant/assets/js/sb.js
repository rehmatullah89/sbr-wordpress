var user_id_customer = '';
var admin_note = '';
var customer_note = '';
var clicked_chat = '';
var extra_whitening_tray_exc = '';
var night_guard_reorder_exc = '';
// Get the modal
var smile_brillaint_order_modal = document.getElementById("smile_brillaint_order_modal");
var smile_brillaint_order_close = document.getElementsByClassName("close")[0];
var smile_brillaint_order_modal2 = document.getElementById("smile_brillaint_order_modal2");
var smile_brillaint_order_close2 = document.getElementsByClassName("close")[1];
var refreshpage = '';
if (window.location.href.indexOf("?page=sb_orders_page") > -1) {
    var refreshpage = 'listing';
} else {
    var refreshpage = 'product';
}
smile_brillaint_order_close.onclick = function () {
    // var reload_order_id = jQuery('body').find('#orderListingPopupID').val();
    // if(reload_order_id > 0){
    //     reloadOrderEntry(reload_order_id);
    // }
    smile_brillaint_order_modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == smile_brillaint_order_modal) {
        smile_brillaint_order_modal.style.display = "none";
    }
}
smile_brillaint_order_close2.onclick = function () {
    smile_brillaint_order_modal2.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == smile_brillaint_order_modal2) {
        smile_brillaint_order_modal2.style.display = "none";
    }
}
jQuery('body').on("select2:open", () => {
    document.querySelector(".select2-container--open .select2-search__field").focus()
})

function sbr_uniqId() {
    return Math.round(new Date().getTime() + (Math.random() * 100));
}
jQuery('body').on('click', '.packagingNoteShip', function (e) {
    e.preventDefault();
    var get_ajax_url = jQuery(this).attr('custom-url');
    var noteMsg = jQuery(this).attr('note');
    var source = jQuery(this).attr('source');
    var order_id = jQuery(this).attr('data-order-id');
    Swal.fire({
        title: "Packaging slip note",
        icon: 'info',
        input: 'textarea',
        inputValue: noteMsg,
        inputPlaceholder: 'Notes:',
        inputAttributes: {
            'aria-label': 'Notes:'
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Save',
        showLoaderOnConfirm: true,
        preConfirm: (note) => {
            return fetch(get_ajax_url + '&note=' + note, {
                method: 'POST',
            }).then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();
            }).catch(error => {
                Swal.showValidationMessage('Request failed: ${error}')
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            if (source == 1) {
                reloadOrderEntry(order_id);
            } else {
                reloadOrderEntry_ByStatus(order_id, 'pending-lab');
            }
            Swal.fire({
                toast: true,
                icon: 'success',
                title: 'Packaging note added succesfully',
                animation: false,
                position: 'center',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        }
    });
});
jQuery('body').on('click', '.loadIframeSBROrder', function (event) {
    //var order_url = jQuery(this).attr('data-order-url');
    var order_id = jQuery(this).attr('data-order-id');
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    //smile_brillaint_order_modal.style.display = "block";
    //jQuery('body').find('#orderListingPopupID').val(order_id);
    jQuery.ajax({
        url: ajaxurl,
        data: 'order_id=' + order_id + '&action=loadOrderBillingShipping',
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            smile_brillaint_order_modal.style.display = "block";
        },
        success: function (response) {
            // console.log(response)
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
    });
    //jQuery('body').find('#smile_brillaint_order_popup_response').html(' <iframe class="iframeOrderDetail" style="width: 100%;height: 600px;" src="'+order_url+'"></iframe>');
});
jQuery('body').on('click', '#saveBillingShippingInfo', function (event) {
    event.preventDefault();
    var order_id = jQuery(this).attr('order_id');
    jQuery('body').find('#billingShippingOrderInfo').block({
        message: 'Please Wait...',
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        }
    });
    var elementT = document.getElementById("billingShippingOrderInfo");
    var formdata = new FormData(elementT);
    jQuery.ajax({
        url: ajaxurl,
        data: formdata,
        async: true,
        //  dataType: 'JSON',
        method: 'POST',
        success: function (response) {
            jQuery('#billingShippingOrderInfo').unblock();
            reloadOrderEntry(order_id);
            smile_brillaint_order_modal.style.display = "none";
        },
        cache: false,
        contentType: false,
        processData: false
    });
})
jQuery('body').on('click', '.sb_customer_chat , .rma_request , .splitOrder', function (event) {
    event.preventDefault();
    clicked_chat = this;
    jQuery("body").find('#smile_brillaint_order_popup_response').addClass(' addOn_mbt shipment-popup');
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    var get_ajax_url = jQuery(this).attr('custom-url');
    // alert(get_ajax_url);
    // var order_id = jQuery(this).attr('data-order-id');
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            smile_brillaint_order_modal.style.display = "block";
        },
        success: function (response) {
            ///console.log(response)
            // jQuery('#analyzing_impression_form').unblock();
            //             if (refreshpage == 'product') {
            //                 reload_order_item_table_mbt(order_id);
            //             }
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
            // 
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
        // contentType: false,
        //  processData: false
    });
});
function addPackageGroup(products_data, reload = false, order_id = false, package_html = '', errorCode = 0) {

    if (errorCode == '43') {
        Swal.fire({
            icon: 'error',
            title: 'WARNING! ',
            html: package_html,
        });
    } else if (package_html != '') {
        Swal.fire({
            icon: 'error',
            title: 'WARNING! ',
            html: 'Multiple shipment package combinations detected against this order. Please select one and remove ALL extra package combinations. To proceed close this box and open the order detail page in a new TAB. Then click create shipment button from there. From there you can remove all extra combinations.',
        });
    } else {
        Swal.fire({
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Save Package',
            html: sb_object.sbr_packages,
            showLoaderOnConfirm: true,
            inputAttributes: {
                autocapitalize: 'off'
            },
            preConfirm: () => {
                var package_id = Swal.getPopup().querySelector('#shipment_package_id').value;
                const formdata = products_data + '&action=addPackageGroup&package_id=' + package_id;
                if (package_id == 0) {
                    Swal.showValidationMessage('Please select package plan.');
                }
                return fetch(ajaxurl + '?' + formdata).then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                }).catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error}`)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.code == 'success') {
                    // Swal.fire('Saved!', '', 'success');
                    if (reload) {
                        load_packages();
                    }
                    if (order_id) {
                        jQuery('body').find('#print_order_' + order_id + ' .current-response').html('<span class="packageselected">Package has been selected</span>');
                    }
                } else {
                    Swal.fire(result.value.msg, '', 'warning')
                }
            }
        });
    }

}
function addPackageGroup_bkPreviousVersion(products_data, reload = false, order_id = false) {
    Swal.fire({
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Save Package',
        html: sb_object.sbr_packages,
        showLoaderOnConfirm: true,
        inputAttributes: {
            autocapitalize: 'off'
        },
        preConfirm: () => {
            var package_id = Swal.getPopup().querySelector('#shipment_package_id').value;
            const formdata = products_data + '&action=addPackageGroup&package_id=' + package_id;
            if (package_id == 0) {
                Swal.showValidationMessage('Please select package plan.');
            }
            return fetch(ajaxurl + '?' + formdata).then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json()
            }).catch(error => {
                Swal.showValidationMessage(`Request failed: ${error}`)
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value.code == 'success') {
                // Swal.fire('Saved!', '', 'success');
                if (reload) {
                    load_packages();
                }
                if (order_id) {
                    jQuery('body').find('#print_order_' + order_id + ' .current-response').html('<span class="packageselected">Package has been selected</span>');
                }
            } else {
                Swal.fire(result.value.msg, '', 'warning')
            }
        }
    });
}
jQuery('body').on('change', '#batchPrintSort', function () {
    if (jQuery(this).val() == 'all') {
        jQuery('body').find('#batch_print tbody tr').each(function () {
            jQuery(this).show();
        });
    } else if (jQuery(this).val() == 'left') {
        jQuery('body').find('#batch_print tbody tr').each(function () {
            if (jQuery(this).attr('status') == 0) {
                jQuery(this).show();
            } else if (jQuery(this).attr('status') == 1) {
                jQuery(this).hide();
            }
        });
    } else {
        jQuery('body').find('#batch_print tbody tr').each(function () {
            if (jQuery(this).attr('status') == 0) {
                jQuery(this).hide();
            } else if (jQuery(this).attr('status') == 1) {
                jQuery(this).show();
            }
        });
    }
});
jQuery('body').on('click', '#sbr-orders-table #doaction', function (event) {
    event.preventDefault();
    if (jQuery('body').find('#bulk-action-selector-top').val() == 'bulk-batch-printing') {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, I am sure!'
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('body').find('#sbr-orders-list').submit();
            } else {
                return false;
            }
        })
    }
});
jQuery('body').on('click', '#sbr-orders-table #doaction', function (event) {
    event.preventDefault();
    if (jQuery('body').find('#bulk-action-selector-top').val() == 'bulk-batch-printing-second') {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, I am sure!'
        }).then((result) => {
            if (result.isConfirmed) {
                jQuery('body').find('#sbr-orders-list').submit();
            } else {
                return false;
            }
        })
    }
});

function sbr_kitReady(item_id, product_id, order_id, log_id) {
    var btn = jQuery('body').find('#btn_kitReady_' + item_id);
    btn.attr('disabled', 'disabled');
    btn.text('Wait...');
    jQuery.ajax({
        url: ajaxurl,
        data: 'order_id=' + order_id + '&item_id=' + item_id + '&product_id=' + product_id + '&log_id=' + log_id + '&action=second_stage_kit_ready&source=1',
        method: 'post',
        //dataType: 'JSON',
        success: function (res) {
            reloadOrderEntry_ByStatus(order_id, 'pending-lab');
        }
    });
}
/*
function sbr_impressionReceived(item_id, product_id, order_id, log_id) {
    var btn = jQuery('body').find('#btn_impressionReceived_' + item_id);
    btn.attr('disabled', 'disabled');
    btn.text('Wait...');
    jQuery.ajax({
        url: ajaxurl,
        data: 'order_id=' + order_id + '&item_id=' + item_id + '&product_id=' + product_id + '&log_id=' + log_id + '&action=create_acknowledged&source=1',
        method: 'post',
        //dataType: 'JSON',
        success: function(res) {
            reloadOrderEntry_ByStatus(order_id, 'waiting-impression');
        }
    });
}
*/
function sbr_impressionReceived(
    item_id,
    product_id,
    order_id,
    log_id,
    source = 0
) {
    if (source == 2) {
        Swal.fire({
            text: "Notification (Email and SMS) to customer?",
            // title: "Email to customer?",
            showDenyButton: true,
            confirmButtonColor: "#3085d6",
            showCancelButton: true,
            confirmButtonText: "Yes",
            denyButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                email_notification = 1;
                sms_notification = 1;
                jQuery("#order_item_data-" + item_id).html(
                    '<td colspan="8" style="text-align: center;">' +
                    sb_js_loader() +
                    "</td>"
                );
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        order_id: order_id,
                        item_id: item_id,
                        product_id: product_id,
                        log_id: log_id,
                        email_notification: 1,
                        sms_notification: 1,
                        action: "create_acknowledged",
                    },
                    method: "post",
                    success: function (res) {
                        reload_order_item_table_mbt(order_id);
                    },
                });
            } else if (result.isDenied) {
                email_notification = 0;
                sms_notification = 0;
                jQuery("#order_item_data-" + item_id).html(
                    '<td colspan="8" style="text-align: center;">' +
                    sb_js_loader() +
                    "</td>"
                );
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        order_id: order_id,
                        item_id: item_id,
                        product_id: product_id,
                        log_id: log_id,
                        email_notification: 0,
                        sms_notification: 0,
                        action: "create_acknowledged",
                    },
                    method: "post",
                    success: function (res) {
                        reload_order_item_table_mbt(order_id);
                    },
                });
            }
        });
    } else {
        var btn = jQuery("body").find("#btn_impressionReceived_" + item_id);
        btn.attr("disabled", "disabled");
        btn.text("Wait...");
        jQuery.ajax({
            url: ajaxurl,
            data: {
                order_id: order_id,
                item_id: item_id,
                product_id: product_id,
                log_id: log_id,
                action: "create_acknowledged",
            },
            method: "post",
            //dataType: 'JSON',
            success: function (res) {
                reloadOrderEntry_ByStatus(order_id, "waiting-impression");
            },
        });
    }
}
function sbr_setAsShipOrder(order_id) {
    var btn = jQuery('body').find('#btn_setAsShipOrder_' + order_id);
    btn.attr('disabled', 'disabled');
    var previousText = btn.html();
    btn.text('Sending...');
    jQuery.ajax({
        url: ajaxurl,
        data: 'order_id=' + order_id + '&action=createOrderShipment',
        method: 'post',
        dataType: 'JSON',
        success: function (res) {
            if (res.code == 'error') {
                if (res.packageId == 0) {
                    if (res.errorCode == '43') {
                        addPackageGroup(res.packageUrl, false, order_id, res.msg, res.errorCode);
                    } else if (res.combinationHtml != 0) {
                        addPackageGroup(res.packageUrl, false, order_id, res.combinationHtml);
                    } else {
                        addPackageGroup(res.packageUrl, false, order_id);

                    }
                    btn.removeAttr('disabled');
                } else {
                    if (res.errorCode == 51) {
                        var locationRedirect = res.redirect_url;
                        window.open(locationRedirect, '_blank');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: res.msg,
                        });
                        btn.removeAttr('disabled');
                    }
                }
                btn.html(previousText);
            } else {
                reloadOrderEntry(order_id);
                Swal.fire({
                    icon: 'success',
                    html: res.msg
                });
            }
        }
    });
}

function orderGoodToShip(order_id, flag) {
    if (flag == 1) {
        var btn = jQuery('body').find('#btn_goodToShip_' + order_id);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Clear this order!'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.attr('disabled', 'disabled');
                btn.text('Loading...');
                jQuery.ajax({
                    url: ajaxurl,
                    data: 'order_id=' + order_id + '&action=update_order_good_to_ship',
                    method: 'post',
                    // dataType: 'JSON',
                    success: function (res) {
                        reloadOrderEntry(order_id);
                    }
                });
            }
        })
    } else {
        var btn = jQuery('body').find('#btn_goodToShip_' + order_id);
        btn.attr('disabled', 'disabled');
        btn.text('Loading...');
        jQuery.ajax({
            url: ajaxurl,
            data: 'order_id=' + order_id + '&action=update_order_good_to_ship',
            method: 'post',
            // dataType: 'JSON',
            success: function (res) {
                reloadOrderEntry(order_id);
            }
        });
    }
}

function sbr_setAsCompleteOrder(order_id) {
    var btn = jQuery('body').find('#btn_setAsCompleteOrder_' + order_id);
    btn.attr('disabled', 'disabled');
    btn.text('Loading...');
    jQuery.ajax({
        url: ajaxurl,
        data: 'order_id=' + order_id + '&action=sbr_setAsCompleted',
        method: 'post',
        dataType: 'JSON',
        success: function (res) {
            reloadOrderEntry(order_id);
        }
    });
}

function reloadOrderEntry(order_id) {
    if (order_id) {
        var orderRow = jQuery('body').find('#sbr_order_' + order_id);
        orderRow.html('<td colspan="8">Loading...</span>');
        orderRow.find('td').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        setTimeout(function () {
            jQuery.ajax({
                url: ajaxurl,
                data: 'order_id=' + order_id + '&action=reloadOrderRow',
                method: 'post',
                success: function (res) {
                    orderRow.html(res);
                    if (res.indexOf("NIGHT GUARD REORDER") >= 0 && night_guard_reorder_exc == 'yes') {

                        jQuery(orderRow).find('input[type=checkbox]').attr('disabled', 'disabled');
                        jQuery(orderRow).addClass('redborder');
                    }
                    if (res.indexOf("Extra Whitening Tray Set") >= 0 && extra_whitening_tray_exc == 'yes') {
                        jQuery(orderRow).find('input[type=checkbox]').attr('disabled', 'disabled');
                        jQuery(orderRow).addClass('redborder');
                    }
                }
            });
        }, 500);
    }
}

function reloadOrderEntry_ByStatus(order_id, type = 0) {
    var orderRow = jQuery('body').find('#sbr_order_' + order_id);
    tray_number = jQuery('#search-tray-number').val();
    orderRow.html('<td colspan="9">Loading...</span>');
    orderRow.find('td').block({
        message: null,
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        }
    });
    jQuery.ajax({
        url: ajaxurl,
        data: 'order_id=' + order_id + '&action=reloadOrderRow&product_status=' + type + '&tray_number=' + tray_number,
        method: 'post',
        success: function (res) {
            orderRow.html(res);
            //  console.log(res)
            if (orderRow.find('.column-ordernumber').html() == '') {
                orderRow.hide();
            }
        }
    });
}
jQuery('body').on('click', '.openChat', function () {
    var get_ajax_url = jQuery(this).attr('custom-url');
    tb_show('Zendesk Ticket Chat', get_ajax_url);
});
jQuery('body').on('click', '.createShipping', function () {
    var get_ajax_url = jQuery(this).attr('custom-url');
    tb_show('Create Shipping', get_ajax_url);
});
jQuery('body').on('click', '.create_shipping_metabox', function () {
    // Prevent default anchor click behavior
    //event.preventDefault();
    // Store hash
    var hash = "#sb_shipping_meta_box";
    // Using jQuery's animate() method to add smooth page scroll
    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
    });
});
jQuery(document).on('change', '#customer_user', function () {
    user_id_customer = jQuery(this).val();
    ajaxurl = jQuery('#ajaxurll').val();
    jQuery.ajax({
        url: ajaxurl,
        data: 'user_id=' + user_id_customer + '&action=get_user_cim_by_email',
        method: 'post',
        success: function (res) {
            if (res == 0) {
                alert('error')
            } else {
                jQuery('#cim_profiles').html(res);
            }
        }
    });
});
jQuery(document).on("change", "#capture_new_card", function () {
    if (this.checked) {
        if (user_id_customer == '') {
            alert("Please Select/Create Customer First");
            return false;
        }
        jQuery('#payment_new_form').show();
        jQuery('#wc-authorize-net-cim-credit-card-account-number').attr('required', 'required');
        jQuery('#wc-authorize-net-cim-credit-card-expiry-month').attr('required', 'required');
        jQuery('#wc-authorize-net-cim-credit-card-expiry-year').attr('required', 'required');
    } else {
        jQuery('#payment_new_form').hide();
        jQuery('#wc-authorize-net-cim-credit-card-account-number').removeAttr('required');
        jQuery('#wc-authorize-net-cim-credit-card-expiry-month').removeAttr('required');
        jQuery('#wc-authorize-net-cim-credit-card-expiry-year').removeAttr('required');
    }
});
jQuery(document).on('keyup', '#wc-authorize-net-cim-credit-card-expiry-year', function () {
    credit_card_num = jQuery('#wc-authorize-net-cim-credit-card-account-number').val();
    credit_card_month = jQuery('#wc-authorize-net-cim-credit-card-expiry-month').val();
    credit_card_year = jQuery('#wc-authorize-net-cim-credit-card-expiry-year').val();
    card_expiry_date = credit_card_month + '/' + credit_card_year;
    var lastFour = credit_card_num.substr(credit_card_num.length - 4);
    if (lastFour != '') {
        counter = 0;
        card_last_four = '';
        card_exp_month = '';
        card_exp_year = '';
        jQuery('#cim_profiles tr td').each(function () {
            if (counter == 0) {
                card_last_four = jQuery(this).text();
            }
            if (counter == 1) {
                card_exp_month = jQuery(this).text();
            }
            if (counter == 2) {
                card_exp_year = jQuery(this).text();
            }
            counter++;
        });
        if (card_last_four == lastFour && card_exp_year == card_expiry_date) {
            alert('card Already Exists in Cim Profile');
        }
    }
});
jQuery(document).on("change", "#print_label_shipment", function () {
    if (this.checked) {
        jQuery('#payment_new_form').val('yes');
    } else {
        jQuery('#payment_new_form').val('');
    }
});
jQuery(document).on("change", "#print_label_shipment", function () {
    if (this.checked) {
        jQuery('.payment_new_form').val('yes');
    } else {
        jQuery('.payment_new_form').val('');
    }
});
jQuery(document).on("change", "#package_label_shipment", function () {
    if (this.checked) {
        jQuery('.package_label_shipment').val('yes');
    } else {
        jQuery('.package_label_shipment').val('');
    }
});
jQuery(document).on("change", "#tracking_email_shipment", function () {
    if (this.checked) {
        jQuery('.tracking_email_shipment').val('yes');
    } else {
        jQuery('.tracking_email_shipment').val('');
    }
});
jQuery(document).ready(function () {
    add_refund_notes_html();
});

function add_refund_notes_html() {
    admin_note = '<tr><td class="label"><label for="refund_reason">Admin Note (optional):</label></td><td class="total"><textarea id="refund_admin_note" name="refund_admin_note" /></textarea><div class="clear"></div></td></tr>';
    customer_note = '<tr><td class="label"><label for="refund_reason">Customer Note (optional):</label></td><td class="total"><textarea id="refund_customer_note" name="refund_customer_note" /></textarea><div class="clear"></div></td></tr>';
    $refund_email = '<tr><td class="label"><input type="checkbox" id="send_refund_email" name="send_refund_email" value="yes" checked="checked"><label for="send_refund_email"> Send Refund Email</label><br><div class="clear"></div></td></tr>';
    jQuery('.wc-order-refund-items .wc-order-totals tbody').append(admin_note);
    jQuery('.wc-order-refund-items .wc-order-totals tbody').append(customer_note);
    jQuery('.wc-order-refund-items .wc-order-totals tbody').append($refund_email);
    jQuery('.wc-order-refund-items .wc-order-totals tbody').addClass('refundAdded');
    jQuery('body').find('.refund_amount').removeAttr('readonly');
}
//billing_country
jQuery(document).on("change", "#shipment_country", function () {
    var selectedCountry = '';
    var selectedCountry = 'shipment_state';
    var countryCode = jQuery(this).val();
    shipmentContent(countryCode);
    var get_ajax_url = sb_object.searchStateByCountryCode + '&countryCode=' + countryCode + '&name=' + selectedCountry;
    // console.log(get_ajax_url);
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            jQuery('body').find('#shipmentStateHtml').empty();
            jQuery('body').find('#shipmentStateHtml').html('Loading....');
        },
        success: function (response) {
            jQuery('body').find('#shipmentStateHtml').empty();
            jQuery('body').find('#shipmentStateHtml').html(response);
        },
        error: function (xhr) {
            Swal.fire('Oops!', 'Request failed...Something went wrong.', 'error');
        },
        cache: false,
    });
});

function shipmentContent($country, $shipmentMethod) {
    var $optionHtml = '';
    if ($country == 'US') {
        // jQuery('body').find('#shipmentContentWapper').hide();
        if ($shipmentMethod == 'First') {
            $optionHtml += '<option value="First" selected="">First Class</option>';
        } else {
            $optionHtml += '<option value="First">First Class</option>';
        }
        if ($shipmentMethod == 'Priority') {
            $optionHtml += '<option value="Priority" selected="">Priority</option>';
        } else {
            $optionHtml += '<option value="Priority">Priority</option>';
        }
        if ($shipmentMethod == 'Express') {
            $optionHtml += '<option value="Express" selected="">Express</option>';
        } else {
            $optionHtml += '<option value="Express">Express</option>';
        }
    } else {
        // jQuery('body').find('#shipmentContentWapper').show();
        if ($shipmentMethod == 'FirstClassPackageInternationalService') {
            $optionHtml += '<option value="FirstClassPackageInternationalService" selected="">First Class International</option>';
        } else {
            $optionHtml += '<option value="FirstClassPackageInternationalService">First Class International</option>';
        }
        if ($shipmentMethod == 'PriorityMailInternational') {
            $optionHtml += '<option value="PriorityMailInternational" selected="">Priority International</option>';
        } else {
            $optionHtml += '<option value="PriorityMailInternational">Priority International</option>';
        }
        if ($shipmentMethod == 'ExpressMailInternational') {
            $optionHtml += '<option value="ExpressMailInternational" selected="">Express International</option>';
        } else {
            $optionHtml += '<option value="ExpressMailInternational">Express International</option>';
        }
    }
    jQuery('body').find('#shipmentLabelService').html($optionHtml);
}
jQuery('body').on('click', '.btn_tray_number_cancel', function () {
    $this = jQuery(this);
    var get_parent = jQuery(this).parentsUntil('.item_sb');
    get_parent.find('.item_tray span').show();
    get_parent.find('.item_tray_input').hide();
    get_parent.find('.try_edit').show();
});
jQuery("body").on("click", ".shipment_remove_field", function (e) { //user click on remove text
    e.preventDefault();
    jQuery(this).closest('.newOrderShipmentEntry').remove();
    disable_shipmentOrderIds();
});

function disable_shipmentOrderIds() {
    // jQuery('.shipmentOrderIds').
    jQuery(".shipmentOrderIds option").each(function () {
        that = this;
        selected_text = jQuery(this).text();
        //   console.log(selected_text);
        jQuery('.order_shipment_number_mbt').each(function () {
            already_selected = jQuery(this).text();
            //    console.log(already_selected + '--');
            if (selected_text == already_selected) {
                jQuery(that).attr('disabled', 'disabled');
            } else {
                // jQuery(that).removeAttr("disabled");
            }
        });
    });
}
jQuery(document).on('click', '#add_order_shipment_btn', function () {
    disable_shipmentOrderIds();
});
jQuery('body').on('change', '.shipmentOrderIds', function () {
    let $currentOrder = jQuery(this);
    jQuery('body').find('#add_order_shipment_btn').hide();
    if (jQuery(this).val()) {
        $currentOrder.closest(".newOrderShipmentEntry").block({
            message: '',
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        var elementT = document.getElementById("shipping_metabox_form");
        var formdata = new FormData(elementT);
        formdata.set('action', 'mbt_shipment_item_data');
        formdata.set('order_id', jQuery(this).val());
        jQuery.ajax({
            url: ajaxurl,
            data: formdata,
            async: true,
            method: 'POST',
            dataType: 'html',
            success: function (response) {
                $currentOrder.closest(".newOrderShipmentEntry").unblock();
                $currentOrder.closest(".newOrderShipmentEntry").find('.orderShipItems').html(response);
                load_packages();
                jQuery('body').find('#add_order_shipment_btn').show();
                //disable_shipmentOrderIds();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});

function addMatchingOrderShipment(order_id) {
    let $currentOrder = jQuery('#matchOrder_' + order_id);
    jQuery('body').find('#add_order_shipment_btn').hide();
    if (order_id) {
        $currentOrder.block({
            message: '',
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        var elementT = document.getElementById("shipping_metabox_form");
        var formdata = new FormData(elementT);
        formdata.set('action', 'mbt_shipment_item_data');
        formdata.set('order_id', order_id);
        jQuery.ajax({
            url: ajaxurl,
            data: formdata,
            async: true,
            method: 'POST',
            dataType: 'html',
            success: function (response) {
                $currentOrder.remove();
                orderId_html = '';
                orderId_html += '<div class="newOrderShipmentEntry">';
                orderId_html += '<div class="orderShipItems">' + response + '</div>';
                orderId_html += '<div class="shipment_remove_field"><a href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></div>';
                orderId_html += '</div>';
                jQuery('body').find('#mbt_shipping_Item_listing').append(orderId_html);
                load_packages();
                jQuery('body').find('#add_order_shipment_btn').show();
                disable_shipmentOrderIds();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}
function removePackageGroup(package_id, group_id, random_id = 0) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Submit delete requests for remove package combination.You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Create Request',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(ajaxurl + '?action=delete_group_by_id&package_id=' + package_id + '&group_id=' + group_id, {
                method: 'POST',
            }).then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText)
                }
                return response.json();

            }).catch(error => {
                Swal.showValidationMessage(
                    'Request failed: ${error}'
                )

            });

        }
    }).then((result) => {
        if (result.isConfirmed) {
            smile_brillaint_order_modal2.style.display = "none";
            Swal.fire({
                icon: 'success',
                html: 'Group #' + group_id + ' Deleted',
            });
            if (random_id != 0) {
                searchPackageRequest();
            } else {
                load_packages();
            }
        }
    });
}

function disable_shipmentOrderIds() {
    // jQuery('.shipmentOrderIds').
    jQuery(".shipmentOrderIds option").each(function () {
        that = this;
        selected_text = jQuery(this).text();
        //   console.log(selected_text);
        jQuery('.order_shipment_number_mbt').each(function () {
            already_selected = jQuery(this).text();
            //   console.log(already_selected + '--');
            if (selected_text == already_selected) {
                jQuery(that).attr('disabled', 'disabled');
            } else {
                // jQuery(that).removeAttr("disabled");
            }
        });
    });
}
jQuery('body').on('click', '.btn_tray_number', function () {
    var get_parent = jQuery(this).parentsUntil('.item_sb').parent();
    var tray_number = get_parent.find('.tray_number-input').val();
    var shipmentScreen = get_parent.find('.shipmentScreen').val();
    if (tray_number) {
        get_parent.find('.item_tray_input').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        /// console.log(get_parent.find('.trayResponseDiv'));
        get_parent.find('.trayResponseDiv').html('');
        //Sending data
        jQuery.ajax({
            url: ajaxurl,
            data: {
                smilebrilliant_order_information_key: get_parent.find('.smilebrilliant_order_information_key').val(),
                action: 'update_tray_number',
                tray_number: tray_number
            },
            method: 'POST',
            dataType: 'JSON',
            // async: false,
            success: function (response) {
                get_parent.find('.item_tray_input').unblock();
                if (response.flag) {
                    get_parent.find('.item_tray span').show();
                    get_parent.find('.try_edit').show();
                    get_parent.find('.item_tray_input').hide();
                    get_parent.find('.item_tray span').html(tray_number);
                    if (shipmentScreen == 'yes') {
                        var item_number = get_parent.find('.item_number').val();
                        var order_number = get_parent.find('.order_number').val();
                        reload_shipment_item(item_number, order_number);
                        get_parent.find('.trayResponseDiv').html(response.msg);
                    }
                } else {
                    get_parent.find('.trayResponseDiv').html(response.msg);
                }
            },
            // cache: false,
            //    contentType: false,
            //  processData: false
        });
    }
});

function reload_shipment_item(item_id, order_id) {
    $itemKey = '#mbt_shipping_Item_listing';
    jQuery($itemKey).block({
        message: null,
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        }
    });
    var data = {
        item_id: item_id,
        order_id: order_id,
        action: 'mbt_shipment_item_data'
    };
    jQuery.ajax({
        url: ajaxurl,
        data: data,
        type: 'POST',
        success: function (response) {
            jQuery('body').find($itemKey).html(response);
            jQuery($itemKey).unblock();
            load_packages();
        }
    });
}

function sb_js_loader() {
    var html = '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
    return html;
}
jQuery('body').on('click', '.try_edit', function () {
    $this = jQuery(this);
    var get_parent = jQuery(this).parentsUntil('.item_sb');
    get_parent.find('.item_tray span').hide();
    $this.hide();
    get_parent.find('.item_tray_input').show();
    get_parent.find('.btn_tray_number_cancel').show();
});
/*********Added********/
jQuery('body').on('click', '.sb_claim_warranty , .existingAddonOrders', function (event) {
    event.preventDefault();
    jQuery("body").find('#smile_brillaint_order_popup_response').addClass(' addOn_mbt');
    //analyze_impression_mbt
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    var get_ajax_url = jQuery(this).attr('custom-url');
    // alert(get_ajax_url);
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            smile_brillaint_order_modal.style.display = "block";
        },
        success: function (response) {
            // jQuery('#analyzing_impression_form').unblock();
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
            // reload_order_item_table_mbt(order_id);
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
        // contentType: false,
        //  processData: false
    });
});
jQuery('body').on('click', '.kit_ready', function (event) {
    event.preventDefault();
    var get_ajax_url = jQuery(this).attr('custom-url');
    var order_id = jQuery(this).attr('order_id');
    var item_id = jQuery(this).attr('item_id');
    jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: false,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) { },
        success: function (response) {
            //  console.log(response)
            reload_order_item_table_mbt(order_id);
        },
        error: function (xhr) { },
        cache: false,
        // contentType: false,
        //  processData: false
    });
});
jQuery('body').on('click', '.sb_activity_note', function (event) {
    event.preventDefault();
    jQuery("body").find('#smile_brillaint_order_popup_response').addClass('activity_note');
    //sb_activity_note
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    var get_ajax_url = jQuery(this).attr('custom-url');
    // alert(get_ajax_url);
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            smile_brillaint_order_modal.style.display = "block";
        },
        success: function (response) {
            // jQuery('#analyzing_impression_form').unblock();
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
            // reload_order_item_table_mbt(order_id);
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
        // contentType: false,
        //  processData: false
    });
});
//#RB
jQuery('body').on('click', '.delete_activity_log', function (event) {
    event.preventDefault();
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    var get_ajax_url = jQuery(this).attr('custom-url');
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        success: function (response) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
    });
});
var count_addToCart = true;
jQuery("body").on('click', '#generate_addOn_order', (function (e) {
    var swaltext = '';
    var refreshpage = '';
    var confirmButtonText = '';
    var type = jQuery('body').find('#warranty_claim_id').val();
    if (window.location.href.indexOf("?page=sb_orders_page") > -1) {
        var refreshpage = 'listing';
    } else {
        var refreshpage = 'product';
    }
    var swaltext = 'Please make sure everything before create addon Order.';
    var confirmButtonText = 'Create Addon';
    if (type == 1) {
        var confirmButtonText = 'Create Replacement';
        var swaltext = 'Please make sure everything before create replacement Order.';
    }
    //    console.log(confirmButtonText)
    //    console.log(swaltext)
    //    console.log(type)
    //    console.log(refreshpage)
    Swal.fire({
        title: 'Are you sure?',
        text: swaltext,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            jQuery('body').find('#smile_brillaint_order_popup_response').block({
                message: 'Please Wait...',
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });
            //jQuery('body').find('.addOn-modal-footer_create').html('<span class="spinner is-active"></span>');
            e.preventDefault();
            var elementT = document.getElementById("addOn_order_form");
            var order_id = jQuery(elementT).find('input[name="order_id"]').val();
            //// console.log(elementT);
            var formdata = new FormData(elementT);
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                method: 'POST',
                dataType: 'JSON',
                success: function (response) {
                    count_addToCart = true;
                    jQuery('#smile_brillaint_order_popup_response').unblock();
                    if (response.error) {
                        Swal.fire('', response.msg, 'error');
                    } else {
                        jQuery('body').find('#smile_brillaint_order_modal .close').trigger('click');
                        if (refreshpage == 'listing') {
                            Swal.fire('Replacement Order Created!', response.msg, 'success');
                        } else {
                            reload_order_item_table_mbt(order_id);
                            Swal.fire('Addon Order Created!', response.msg, 'success');
                        }
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
}));
jQuery('body').on('click', '.removeActivity', function () {
    event.preventDefault();
    var get_ajax_url = jQuery(this).attr('custom-url');
    var order_id = jQuery(this).attr('order_id');
    // console.log(order_id)
    Swal.fire({
        text: "Are you sure you want to revert impression.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Revert'
    }).then((result) => {
        if (result.isConfirmed) {
            jQuery.ajax({
                url: get_ajax_url,
                data: [],
                async: true,
                dataType: 'html',
                method: 'POST',
                beforeSend: function (xhr) { },
                success: function (response) {
                    reload_order_item_table_mbt(order_id);
                },
                error: function (xhr) { },
                cache: false,
            });
        }
    });
});
jQuery('body').on('click', '.create_sb_shipment', function () {
    event.preventDefault();
    jQuery("body").find('#smile_brillaint_order_popup_response').addClass(' addOn_mbt shipment-popup');
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    var get_ajax_url = jQuery(this).attr('custom-url');
    // alert(get_ajax_url);
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            smile_brillaint_order_modal.style.display = "block";
        },
        success: function (response) {
            // jQuery('#analyzing_impression_form').unblock();
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
            // reload_order_item_table_mbt(order_id);
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
        // contentType: false,
        //  processData: false
    });
});
var sending_print_label_request = true;
/*

 var toastMixin = Swal.mixin({

 toast: true,

 icon: 'success',

 title: 'General Title',

 animation: false,

 position: 'top-right',

 showConfirmButton: false,

 timer: 3000,

 timerProgressBar: true,

 didOpen: (toast) => {

 toast.addEventListener('mouseenter', Swal.stopTimer)

 toast.addEventListener('mouseleave', Swal.resumeTimer)

 }

 });

 */
jQuery('body').on('click', '#close_order_popup', function () {
    smile_brillaint_order_modal.style.display = "none";
});
var shipmentDatatable = '';
jQuery('body').on('click', '.sb_addon_order', function () {
    event.preventDefault();
    jQuery("body").find('#smile_brillaint_order_popup_response').addClass(' addOn_mbt');
    //analyze_impression_mbt
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    var get_ajax_url = jQuery(this).attr('custom-url');
    // alert(get_ajax_url);
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            smile_brillaint_order_modal.style.display = "block";
        },
        success: function (response) {
            // jQuery('#analyzing_impression_form').unblock();
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
            // reload_order_item_table_mbt(order_id);
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
        // contentType: false,
        //  processData: false
    });
});
jQuery('body').on('click', '.sb_analyze_impression', function () {
    event.preventDefault();
    jQuery("body").find('#smile_brillaint_order_popup_response').addClass(' addOn_mbt analyze_impression');
    jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_load_html());
    var get_ajax_url = jQuery(this).attr('custom-url');
    // alert(get_ajax_url);
    jQuery.ajax({
        url: get_ajax_url,
        data: [],
        async: true,
        dataType: 'html',
        method: 'POST',
        beforeSend: function (xhr) {
            smile_brillaint_order_modal.style.display = "block";
        },
        success: function (response) {
            // jQuery('#analyzing_impression_form').unblock();
            jQuery('body').find('#smile_brillaint_order_popup_response').html(response);
            // reload_order_item_table_mbt(order_id);
        },
        error: function (xhr) {
            jQuery('body').find('#smile_brillaint_order_popup_response').html(smile_brillaint_fail_status_html('Request failed...Something went wrong.'));
        },
        cache: false,
        // contentType: false,
        //  processData: false
    });
});
jQuery('body').on('click', '#addPaymentProfile_checkbox', function () {
    if (jQuery(this).prop('checked') == true) {
        jQuery('body').find('#addOn-modal-footer_cc').hide();
        jQuery('body').find('#addOn_addPaymentProfile_form').show();
    } else {
        jQuery('body').find('#addOn_addPaymentProfile_form').hide();
        jQuery('body').find('#addOn-modal-footer_cc').show();
    }
});
jQuery('body').on('keypress', '#wc-authorize-net-cim-credit-card-account-number , #wc-authorize-net-cim-credit-card-expiry-year ,  #wc-authorize-net-cim-credit-card-csc', function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    } else {
        jQuery(this).css('border-color', '#7e8993');
    }
});
jQuery('body').on('click', '.print_lable_request', function () {
    // console.log('Click')
    $this = jQuery(this);
    event.preventDefault();
    if (sending_print_label_request) {
        sending_print_label_request = false;
        jQuery.ajax({
            url: $this.attr('custom-url'),
            data: [],
            async: true,
            dataType: 'html',
            method: 'POST',
            beforeSend: function (xhr) {
                $this.html('Wait...');
            },
            success: function (response) {
                //  console.log(response);
                sending_print_label_request = true;
                $this.html('Print');
                /*

                 toastMixin.fire({

                 animation: true,

                 title: 'Label is being print.'

                 });

                 */
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: 'Label is being print.',
                    animation: false,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            },
            error: function (xhr) {
                $this.html('Print');
            },
            cache: false,
            // contentType: false,
            //  processData: false
        });
    }
})
var count_shipment = true;
jQuery('body').on('click', '#btn_ship_now', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "Please make sure before create shipment against selected item.\n\n Are you sure you want to genrate shipment.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Create Shipment'
    }).then((result) => {
        if (result.isConfirmed) {
            var order_id = jQuery(this).attr('order_id');
            if (count_shipment) {
                jQuery('#shipping_metabox_form').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });
                count_shipment = false;
                var elementT = document.getElementById("shipping_metabox_form");
                /// formdata.set('action', 'generate_shipment_id');
                //   console.log(elementT);
                var formdata = new FormData(elementT);
                jQuery.ajax({
                    url: ajaxurl,
                    data: formdata,
                    async: true,
                    method: 'POST',
                    dataType: 'JSON',
                    statusCode: {
                        502: function () {
                            // Handle the 502 Bad Gateway response
                            Swal.fire({
                                icon: 'success',
                                text: 'Shipment created successfully'
                            });
                            location.reload();
                        }
                    },
                    success: function (response) {
                        jQuery('#shipping_metabox_form').unblock();
                        if (response.code == 'success') {
                            Swal.fire({
                                icon: 'success',
                                text: response.msg
                            });
                            if (refreshpage == 'listing') {
                                reloadOrderEntry_ByStatus(order_id, 'pending-lab');
                                document.getElementById("smile_brillaint_order_modal").style.display = "none";
                                jQuery('body').find('#smile_brillaint_order_modal .close').trigger('click');
                            } else {
                                if (response.status) { } else {
                                    jQuery('body').find('.button-primary.create_sb_shipment').hide();
                                }
                                if (response.source == 'add') {
                                    location.reload();
                                } else {
                                    // shipmentDatatable.ajax.reload();
                                    document.getElementById("smile_brillaint_order_modal").style.display = "none";
                                    jQuery('body').find('#smile_brillaint_order_modal .close').trigger('click');
                                    reload_order_item_table_mbt(order_id);
                                }
                            }
                        } else {
                            $error_msg = '<div class="alert">';
                            $error_msg += '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
                            $error_msg += response.msg;
                            $error_msg += '</div>';
                            jQuery('body').find('#shipment_response').html($error_msg);
                        }
                        count_shipment = true;
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        // Handle other types of errors
                        console.error('An error occurred:', textStatus, errorThrown);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        }
    })
});

jQuery('body').on('click', '.reject_item', function () {
    var log_id = jQuery(this).attr('log_id');
    var item_id = jQuery(this).attr('item_id');
    // jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
    //Sending data
    jQuery.ajax({
        url: ajaxurl,
        data: {
            log_id: log_id,
            action: 'reject_item_warranty',
        },
        method: 'POST',
        dataType: 'JSON',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                //var item_id = response[i].item_id;
                var html = response[i].html;
                // var tray = response[i].tray;
                // jQuery('#item_tray_number_' + item_number).html(tray);
                jQuery('#order_item_data-' + item_id).html(html);
                //jQuery('#order_item_data-' + item_id).html(item_id);
            }
        }
        // cache: false,
        //    contentType: false,
        //  processData: false
    });
});
jQuery("body").on("click", ".suggest_order_remove_field", function (e) { //user click on remove text
    e.preventDefault();
    jQuery(this).closest('.suggestEntry').remove();
    disable_shipmentOrderIds();
});

function n__handleShippingMethod(method, country = 0, shipmentMethod = 0, all = 0) {
    console.log(method.value)
    jQuery('body').find('#shipmentLabelService').block({
        message: '',
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        }
    });
    var formdata = new FormData();
    formdata.set('action', 'get_carrierServiceMethod');
    formdata.set('method', method);
    formdata.set('shipmentMethod', shipmentMethod);
    formdata.set('country', country);
    formdata.set('all', all);
    jQuery.ajax({
        url: ajaxurl,
        data: formdata,
        /// dataType: 'JSON',
        async: true,
        method: 'POST',
        success: function (response) {
            jQuery('#shipmentLabelService').unblock();
            jQuery('body').find('#shipmentLabelService').html(response);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}


function load_packages() {
    jQuery('body').find('#package_configuration').block({
        message: '',
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        }
    });
    var elementT = document.getElementById("shipping_metabox_form");
    var formdata = new FormData(elementT);
    formdata.set('action', 'generate_order_package');
    jQuery.ajax({
        url: ajaxurl,
        data: formdata,
        /// dataType: 'JSON',
        async: true,
        method: 'POST',
        success: function (response) {
            jQuery('#package_configuration').unblock();
            jQuery('body').find('#package_configuration').html(response);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

jQuery('body').on('keypress', '#wc-authorize-net-cim-credit-card-account-number , #wc-authorize-net-cim-credit-card-expiry-year ,  #wc-authorize-net-cim-credit-card-csc', function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    } else {
        jQuery(this).css('border-color', '#7e8993');
    }
});
var clickedCC = true;
jQuery('body').on('click', '#create_payment_profile_mbt', function (e) {
    $validate_cc = true;

    jQuery('body').find('#addPaymentMethod .validate-required input').each(function () {
        var currentItem = jQuery(this);
        if (currentItem.val() == '') {
            $validate_cc = false;
            currentItem.attr('style', 'border-color: red !important');
        } else {
            currentItem.attr('style', 'border-color: #4BB543 !important');
        }
    });
    jQuery('body').find('#addPaymentMethod .validate-required select').each(function () {
        var currentItem = jQuery(this);
        if (currentItem.val() == '') {
            $validate_cc = false;
            currentItem.attr('style', 'border-color: red !important');
        } else {
            currentItem.attr('style', 'border-color: #4BB543 !important');
        }
    });
    if ($validate_cc) {
        if (clickedCC) {
            clickedCC = false;
            jQuery("#responsePaymentMethod").html('');
            jQuery("#responsePaymentMethod").removeClass('errorCase');
            jQuery("#responsePaymentMethod").removeClass('successCase');
            jQuery('.loading-sbr').show();
            //jQuery('body').find('#smile_brillaint_payment_gateway_user').empty();
            e.preventDefault();
            var elementT = document.getElementById("addPaymentMethod");
            var formdata = new FormData(elementT);
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                method: 'POST',
                dataType: 'JSON',
                success: function (res) {
                    clickedCC = true;
                    if (res.response === false) {
                        jQuery("#responsePaymentMethod").addClass('errorCase');
                    } else {
                        jQuery("#responsePaymentMethod").addClass('successCase');
                        jQuery('body').find('#smile_brillaint_payment_gateway_user').html(res.resultHTML);
                    }
                    jQuery("#responsePaymentMethod").html(res.error);
                    jQuery("#responsePaymentMethod").show("slow").delay(3000);

                    jQuery('.loading-sbr').hide();
                },
                error: function () {
                    clickedCC = true;
                    jQuery('.loading-sbr').hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

});

var count_analyzer = true;
jQuery("body").on('click', '#analyzing_impression_btn', (function (e) {
    Swal.fire({
        text: "Are you sure you want to save putty impression.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Save'
    }).then((result) => {
        if (result.isConfirmed) {
            if (count_analyzer) {
                jQuery('#analyzing_impression_form').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });
                count_analyzer = false;
                e.preventDefault();
                var elementT = document.getElementById("analyzing_impression_form");
                var order_id = jQuery(elementT).find('input[name="order_id"]').val();
                //// console.log(elementT);
                var formdata = new FormData(elementT);
                jQuery.ajax({
                    url: ajaxurl,
                    data: formdata,
                    async: true,
                    method: 'POST',
                    success: function (response) {
                        jQuery('#analyzing_impression_form').unblock();
                        jQuery('body').find('#smile_brillaint_order_modal .close').trigger('click');
                        count_analyzer = true;
                        if (refreshpage == 'listing') {
                            reloadOrderEntry_ByStatus(order_id, 'waiting-impression');
                            //  reloadOrderEntry(order_id);
                        } else {
                            reload_order_item_table_mbt(order_id);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        }
    });
}));
jQuery(document).on('click', '.orde_refund_reason_mbt', function () {
    orderid = jQuery(this).attr('data-order-id');
    that = this;
    jQuery(that).parents('.refund-popup-container').addClass('refundloading');
    jQuery.ajax({
        url: ajaxurl,
        data: 'action=get_refund_reason_order_listing&order_id=' + orderid,
        async: true,
        method: 'POST',
        success: function (response) {
            jQuery(that).parent().parent().find('.add-sbr-data').html(response);
            jQuery(that).parent().parent().find('.add-sbr-data').parent().show();
            jQuery(that).parents('.refund-popup-container').removeClass('refundloading');
        },
    });
});
jQuery(document).on('click', '.cross-div', function () {
    jQuery(this).parent().hide();
});
jQuery('body').on('click', '.create_warranty_request', function () {
    var log_id = jQuery(this).attr('log_id');
    var item_id = jQuery(this).attr('item_id');
    jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
    //Sending data
    jQuery.ajax({
        url: ajaxurl,
        data: {
            log_id: log_id,
            action: 'create_customer_warranty',
        },
        method: 'POST',
        dataType: 'JSON',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                //var item_id = response[i].item_id;
                var html = response[i].html;
                // var tray = response[i].tray;
                // jQuery('#item_tray_number_' + item_number).html(tray);
                jQuery('#order_item_data-' + item_id).html(html);
                //jQuery('#order_item_data-' + item_id).html(item_id);
            }
        }
        // cache: false,
        //    contentType: false,
        //  processData: false
    });
});
jQuery('body').on('click', '.btn_orderIdRMA', function () {
    var get_parent = jQuery(this).parent('.orderIdRMA_container');
    var spinner = get_parent.find('.btn_orderIdRMA .spinner');
    spinner.removeClass('hidden-class');
    var order_id_rma = get_parent.find('.orderIdRMA_input').val();
    var item_number = get_parent.find('.item_number').val();
    var event_id = get_parent.find('.event_id').val();
    var log_id = get_parent.find('.log_id').val();
    if (order_id_rma) {
        jQuery('#td_tracking_id_' + item_number).html('Please wait. Processing..');
        //Sending data
        jQuery.ajax({
            url: ajaxurl,
            data: {
                order_id: get_parent.find('.order_number').val(),
                item_number: item_number,
                product_id: get_parent.find('.product_id').val(),
                action: 'orderIdRMA',
                order_id_rma: order_id_rma,
                event_id: event_id,
                log_id: log_id
            },
            method: 'POST',
            dataType: 'JSON',
            //async: false,
            success: function (response) {
                // console.log(response);
                spinner.addClass('hidden-class');
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    //var item_id = response[i].item_id;
                    var html = response[i].html;
                    jQuery('body').find('#order_item_data-' + item_number).html(html);
                }
            },
            // cache: false,
            //    contentType: false,
            //  processData: false
        });
    }
});
jQuery('body').on('click', '.btn_tracking_number', function () {
    var get_parent = jQuery(this).parent('.tracking_number_container');
    var spinner = get_parent.find('.btn_tracking_number .spinner');
    spinner.removeClass('hidden-class');
    var tracking_number = get_parent.find('.tracking_number_input').val();
    var item_number = get_parent.find('.item_number').val();
    var event_id = get_parent.find('.event_id').val();
    var order_id = get_parent.find('.order_number').val();
    if (tracking_number) {
        jQuery('#td_tracking_id_' + item_number).html('Please wait. Processing..');
        //Sending data
        jQuery.ajax({
            url: ajaxurl,
            data: {
                order_id: order_id,
                item_number: item_number,
                product_id: get_parent.find('.product_id').val(),
                action: 'update_tracking_number',
                tracking_number: tracking_number,
                event_id: event_id
            },
            method: 'POST',
            dataType: 'JSON',
            //async: false,
            success: function (response) {
                if (response.code == 'success') {
                    reload_order_item_table_mbt(order_id);
                } else {
                    Swal.fire('', response.msg, 'warning')
                }
            },
            // cache: false,
            //    contentType: false,
            //  processData: false
        });
    } else {
        spinner.addClass('hidden-class');
    }
});
jQuery('body').on('click', '.refund_order_mbt', function () {
    jQuery('body').find('.add-items .button.refund-items').trigger('click');
    var hash = "#order_line_items";
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
    });
});
jQuery('body').on('click', '.arrow-up , .arrow-down', function () {
    var item_id = jQuery(this).attr('item_id');
    var product_id = jQuery(this).attr('product_id');
    var order_id = jQuery(this).attr('order_id');
    var event_action = jQuery(this).attr('action');
    if (event_action == 'up') {
        jQuery(this).parentsUntil('.arrow-container').parent().find('.arrow-up').removeClass('active');
        jQuery(this).parentsUntil('.arrow-container').parent().find('.arrow-down').addClass('active');
    } else {
        jQuery(this).parentsUntil('.arrow-container').parent().find('.arrow-up').addClass('active');
        jQuery(this).parentsUntil('.arrow-container').parent().find('.arrow-down').removeClass('active');
    }
    jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
    //Sending data
    jQuery.ajax({
        url: ajaxurl,
        data: {
            order_id: order_id,
            action: 'item_log_sorting',
            product_id: product_id,
            item_id: item_id,
            event_action: event_action,
        },
        method: 'POST',
        dataType: 'JSON',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                //var item_id = response[i].item_id;
                var html = response[i].html;
                // var tray = response[i].tray;
                // jQuery('#item_tray_number_' + item_number).html(tray);
                jQuery('#order_item_data-' + item_id).html(html);
                //jQuery('#order_item_data-' + item_id).html(item_id);
            }
        }
    });
});
jQuery('body').on('click', '.load_more_item', function () {
    var item_id = jQuery(this).attr('item_id');
    var product_id = jQuery(this).attr('product_id');
    var order_id = jQuery(this).attr('order_id');
    jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
    //Sending data
    jQuery.ajax({
        url: ajaxurl,
        data: {
            order_id: order_id,
            action: 'load_item_data',
            product_id: product_id,
            item_id: item_id,
        },
        method: 'POST',
        dataType: 'JSON',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                //var item_id = response[i].item_id;
                var html = response[i].html;
                // var tray = response[i].tray;
                // jQuery('#item_tray_number_' + item_number).html(tray);
                jQuery('#order_item_data-' + item_id).html(html);
                //jQuery('#order_item_data-' + item_id).html(item_id);
            }
        }
        // cache: false,
        //    contentType: false,
        //  processData: false
    });
});
jQuery('body').on('click', '.create_child_order', function () {
    var item_id = jQuery(this).attr('item_id');
    var product_id = jQuery(this).attr('product_id');
    var order_id = jQuery(this).attr('order_id');
    // var event_action = jQuery(this).attr('action');
    jQuery('#order_item_data-' + item_id).html('<td colspan="8" style="text-align: center;">' + sb_js_loader() + '</td>');
    //Sending data
    jQuery.ajax({
        url: ajaxurl,
        data: {
            order_id: order_id,
            action: 'create_addon_order',
            product_id: product_id,
            item_id: item_id,
        },
        method: 'POST',
        dataType: 'JSON',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                //var item_id = response[i].item_id;
                var html = response[i].html;
                // var tray = response[i].tray;
                // jQuery('#item_tray_number_' + item_number).html(tray);
                jQuery('#order_item_data-' + item_id).html(html);
                //jQuery('#order_item_data-' + item_id).html(item_id);
            }
        }
        // cache: false,
        //    contentType: false,
        //  processData: false
    });
});
jQuery('body').on('click', '.save_item_options', function () {
    var get_parent = jQuery(this).parent('.mbt_item_option');
    var spinner = get_parent.find('.save_item_options .spinner');
    spinner.removeClass('hidden-class');
    var tray_number = get_parent.find('.tray_number-input').val();
    var tracking_number = get_parent.find('.tracking_number-input').val();
    var impression_received_date = get_parent.find('.impression_received_date-input').val();
    var impression_redo_tracking_code = get_parent.find('.impression_redo_tracking_code-input').val();
    var ship_date = get_parent.find('.ship_date-input').val();
    var shipment_address = get_parent.find('.shipment_address-input').val();
    //Sending data
    jQuery.ajax({
        url: ajaxurl,
        data: {
            order_key: get_parent.find('#order_key').val(),
            action: 'update_tray_number',
            tray_number: tray_number,
            tracking_number: tracking_number,
            impression_received_date: impression_received_date,
            impression_redo_tracking_code: impression_redo_tracking_code,
            ship_date: ship_date,
            shipment_address: shipment_address,
        },
        method: 'POST',
        //async: false,
        success: function (response) {
            //console.log(response);
            spinner.addClass('hidden-class');
        }
        // cache: false,
        //    contentType: false,
        //  processData: false
    });
});
jQuery("body").on('click', '.customer_chat', function (event) {
    event.preventDefault();
    var get_ajax_url = jQuery(this).attr('custom-url');
    //tb_show('Customer area', get_ajax_url);
});

jQuery("body").on('click', '.composited_parent', function (event) {
    $parent_item = jQuery(this).attr('data-parent-id');
    if (jQuery('#shipping_qty_' + $parent_item).prop('checked') == true) {
        jQuery('.composited_child_' + $parent_item).show();
    } else {
        jQuery('.composited_child_' + $parent_item).hide();
    }
});
jQuery("body").on('click', 'input[name="is_shipping_address_changed"]', function (event) {
    if (jQuery(this).val() == 'new') {
        jQuery('#is_shipping_address_changed_tbody').show();
    } else {
        jQuery('#is_shipping_address_changed_tbody').hide();
    }
})
jQuery("body").on('click', 'input[name="is_billing_address_changed"]', function (event) {
    if (jQuery(this).val() == 'new') {
        jQuery('#is_billing_address_changed_tbody').show();
    } else {
        jQuery('#is_billing_address_changed_tbody').hide();
    }
})
jQuery("body").on('click', '#get_notes_tab', function (event) {
    event.preventDefault();
    var hash = "#woocommerce-order-notes";
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        window.location.hash = hash;
    });
});
jQuery("body").on('click', '#browsingHistoryEvent', function (event) {
    event.preventDefault();
    var hash = "#woocommerce-customer-browsing-history";
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        window.location.hash = hash;
    });
});
jQuery("body").on('click', '#product_log_event', function (event) {
    event.preventDefault();
    var hash = "#order_line_items";
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        window.location.hash = hash;
    });
});
jQuery("body").on('click', '#shipmentEvent', function (event) {
    event.preventDefault();
    var hash = "#order-shipment";
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        window.location.hash = hash;
    });
});
jQuery("body").on('click', '#refundsEvent', function (event) {
    event.preventDefault();
    var hash = "#order-refunds";
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        window.location.hash = hash;
    });
});
jQuery("body").on('click', '#pruchaseHistroyEvent', function (event) {
    event.preventDefault();
    var hash = "#woocommerce-customer-purchase-history";
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 800, function () {
        window.location.hash = hash;
    });
})
jQuery('body').on('click', '.sysncQty', function (event) {
    jQuery(this).hide();
    order_item_id = jQuery(this).attr('data-orderitemid');
    order_id = jQuery(this).attr('data-order_id');
    order_qty = jQuery(this).attr('data-order_qty');
    if (order_item_id != '') {
        jQuery.ajax({
            url: ajaxurl,
            data: 'order_item_id=' + order_item_id + '&action=change_qty_shipped_sbr' + '&order_qty=' + order_qty + '&order_id=' + order_id,
            async: true,
            dataType: 'html',
            method: 'POST',
            success: function (response) {
                console.log(response);
                reloadOrderEntry(order_id);
            }
        });
    }
});
/*

 * Status edit inline on listing page

 */
jQuery(document).on("click", ".status_edit", function () {
    jQuery(this).parents('.column-ship').find('.item_status_input').show();
});
jQuery(document).on("click", ".btn_edit_status_cancel", function () {
    jQuery(this).parents('.column-ship').find('.item_status_input').hide();
});
jQuery(document).on("click", ".btn_edit_status", function () {
    selected_status = jQuery(this).parents('.column-ship').find('#edit_status_inline').val();
    order_id = jQuery(this).attr('data-order_id');
    if (order_id != '') {
        var orderRow = jQuery('body').find('#sbr_order_' + order_id);
        orderRow.html('<td colspan="8">Loading...</span>');
        jQuery.ajax({
            url: ajaxurl,
            data: 'action=change_order_status_inline_listing' + '&selected_status=' + selected_status + '&order_id=' + order_id,
            async: true,
            dataType: 'json',
            method: 'POST',
            success: function (res) {
                console.log(res);
                if (res.status == 'success') {
                    reloadOrderEntry(order_id);
                } else {
                    alert(res.message);
                }
            }
        });
    }
});
/*

 * shipping edit inline on listing page

 */
jQuery(document).on("click", ".shipping_edit", function () {
    jQuery(this).parents('.column-shipping').find('.item_shipping_input').show();
});
jQuery(document).on("click", ".btn_edit_shipping_cancel", function () {
    jQuery(this).parents('.column-shipping').find('.item_shipping_input').hide();
});
jQuery(document).on("click", ".btn_edit_shipping", function () {
    selected_shipping = jQuery(this).parents('.column-shipping').find('#edit_shipping_inline').val();
    order_id = jQuery(this).attr('data-order_id');
    itemid = jQuery(this).parents('.column-shipping').find('#edit_shipping_inline option:selected').attr('data-itemid');
    itemtitle = jQuery(this).parents('.column-shipping').find('#edit_shipping_inline option:selected').text();
    that = this;
    if (order_id != '') {
        jQuery(that).parents('.column-shipping').find('.item_shipping_input.flex-row-mbt').block({
            message: 'loading...',
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        var orderRow = jQuery('body').find('#sbr_order_' + order_id);
        orderRow.html('<td colspan="8">Loading...</span>');
        jQuery.ajax({
            url: ajaxurl,
            data: 'action=change_order_shipping_inline_listing' + '&w3tc_note=flush_all&selected_shipping=' + selected_shipping + '&order_id=' + order_id + '&itemid=' + itemid + '&itemtitle=' + itemtitle,
            async: true,
            dataType: 'json',
            method: 'POST',
            success: function (res) {
                jQuery(that).parents('.column-shipping').find('.item_shipping_input.flex-row-mbt').unblock();
                if (res.status == 'success') {
                    if (jQuery('.shipping_edit').hasClass('button-small')) {
                        reload_order_item_table_mbt(order_id);
                        jQuery(that).parents('.column-shipping').find('.item_shipping_input.flex-row-mbt').hide();
                    } else {
                        reloadOrderEntry(order_id);
                    }
                } else {
                    alert(res.message);
                }
            }
        });
    }
});
/*

 Add Model

 */
//jQuery(document).find('.add_model').on('click',function(){
jQuery(document).on('click', '.add_model', function () {
    that = this;
    item_id = jQuery(this).attr('data-item_id');
    order_id = jQuery(this).attr('data-oid');
    if (item_id != '') {
        jQuery(this).parent().parent().block({
            message: 'Loading...',
            overlayCSS: {
                background: '#fff',
                opacity: 0.8
            }
        });
        jQuery.ajax({
            url: ajaxurl,
            data: 'action=add_model_order_item' + '&orde_item_id=' + item_id,
            async: true,
            dataType: 'json',
            method: 'POST',
            success: function (res) {
                //smile_brillaint_order_modal.style.display = "none";
                if (res.status == 'success') {
                    reload_js_model_flag(that, 'https://www.smilebrilliant.com/wp-content/plugins/smile-brilliant/assets/images/3d-tooth-icon.svg', 'added');
                } else {
                    alert('some thing went wrong ');
                }
            }
        });
    }
});
/*

 Add Model

 */
jQuery(document).on('click', '.have_model', function () {
    that = this;
    item_id = jQuery(this).attr('data-item_id');
    order_id = jQuery(this).attr('data-oid');
    if (item_id != '') {
        jQuery(this).parent().parent().block({
            message: 'Loading...',
            overlayCSS: {
                background: '#fff',
                opacity: 0.8
            }
        });
        //  smile_brillaint_order_modal.style.display = "block";
        jQuery.ajax({
            url: ajaxurl,
            data: 'action=remove_model_order_item' + '&orde_item_id=' + item_id,
            async: true,
            dataType: 'json',
            method: 'POST',
            success: function (res) {
                //smile_brillaint_order_modal.style.display = "none";
                if (res.status == 'success') {
                    //alert('3d model is unmarked ');
                    reload_js_model_flag(that, 'https://www.smilebrilliant.com/wp-content/plugins/smile-brilliant/assets/images/3d-tooth-icon-grey.svg', 'removed');
                } else {
                    alert('some thing went wrong ');
                }
            }
        });
    }
});

function reload_js_model_flag(obj, url_icon, att) {
    jQuery(obj).parent().parent().unblock();
    jQuery(obj).find('img').attr('src', url_icon);
    //jQuery(obj).find('img').hide();
    if (att == 'added') {
        jQuery(obj).removeClass('add_model');
        jQuery(obj).addClass('have_model');
        jQuery(obj).find('.tooltiptext').text('Remove Digital Model');
    }
    if (att == 'removed') {
        jQuery(obj).removeClass('have_model');
        jQuery(obj).addClass('add_model');
        jQuery(obj).find('.tooltiptext').text('Add Digital Model');
    }
}
/* 
Sale Price Calculation based on new field
*/
jQuery(document).ready(function () {
    jQuery(document).on('keyup', '#_percentage_calculate', function () {
        discount_amount = jQuery(this).val();
        if (discount_amount != '') {
            regular_price = jQuery('#_regular_price').val();
            if (regular_price != '') {
                if (discount_amount.includes("%")) {
                    discount_amount = discount_amount.replace("%", '');
                    percentage = (regular_price * discount_amount) / 100;
                    sale_price = regular_price - percentage;
                } else {
                    sale_price = regular_price - discount_amount;
                }
                sale_price = sale_price.toFixed(2)
                if (sale_price > 0) {
                    jQuery('#_sale_price').val(sale_price);
                } else {
                    alert('sale price should be greater than 0');
                    jQuery('#_sale_price').val('');
                }
            }
        }
    });
});

$send_chat = true;
jQuery('body').on('click', '#btn_customer_zendesk_chat', function () {

    if ($send_chat) {
        tinyMCE.triggerSave();
        jQuery('#chat_container').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
        $send_chat = false;
        var elementT = document.getElementById("customer_zendesk_chat");
        var formdata = new FormData(elementT);
        jQuery.ajax({
            url: ajaxurl,
            data: formdata,
            async: true,
            dataType: 'JSON',
            method: 'POST',
            success: function (response) {
                $send_chat = true;
                if (response.status == 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: response.message
                    });
                } else {
                    jQuery('body').find('#smile_brillaint_order_modal .close').trigger('click');
                    //    jQuery('#response_chat').html(response.message);
                    //    jQuery('.close_ticket').show();
                    if (refreshpage == 'listing') {
                        backend_row_refreshZD();
                    }
                    //    tinymce.activeEditor.setContent('');
                    //   jQuery('#zendesk_macro').val('');
                    //  jQuery(document).find('.tickestatus').html('open');
                    //  jQuery(document).find('.tickestatus').addClass('open');
                    //  jQuery(document).find('.tickestatus').removeClass('solved');
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        title: 'Message Sent to customer.',
                        animation: false,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                }
                jQuery('#chat_container').unblock();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
jQuery('body').on('click', '.close_ticket', function () {
    jQuery('#chat_container').block({
        message: null,
        overlayCSS: {
            background: '#fff',
            opacity: 0.6
        }
    });
    jQuery.ajax({
        url: jQuery(this).attr('data-close-ticket'),
        async: true,
        dataType: 'json',
        method: 'POST',
        success: function (response) {
            jQuery('body').find('#smile_brillaint_order_modal .close').trigger('click');
            if (refreshpage == 'listing') {
                backend_row_refreshZD();
            }
            jQuery('#chat_container').unblock();
            /*
            jQuery(document).find('.tickestatus').html('solved');
            jQuery(document).find('.tickestatus').removeClass('open');
            jQuery(document).find('.tickestatus').addClass('solved');
            jQuery(document).find('.status-res').html(response.message);
            jQuery('.close_ticket').hide();
            jQuery('#chat_container').unblock();
            backend_row_refreshZD();
            */
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
jQuery("body").on("click", ".unblockFruad", function () {
    var order_id_f = jQuery(this).attr("order_id");
    var email_f = jQuery(this).attr("email");
    jQuery("#unblockFruadContainer-" + order_id_f).block({
        message: null,
        overlayCSS: {
            background: "#fff",
            opacity: 0.6,
        },
    });

    jQuery.ajax({
        url: ajaxurl,
        async: true,
        data: {
            'action': "unblockFruadEmail",
            'email': email_f,
        },
        method: "POST",
        success: function (response) {
            jQuery("#unblockFruadContainer-" + order_id_f)
                .find(".unblockFruad")
                .remove();
            jQuery("#unblockFruadContainer-" + order_id_f)
                .find("span")
                .removeAttr("style");
            jQuery("#unblockFruadContainer-" + order_id_f).unblock();
        },
    });
});

function sbr_markAsCompleteItem(item_id, product_id, order_id, log_id) {
    Swal.fire({
        title: "Mark as completed status",
        text: "You won't be able to revert this! ",
        icon: "warning",
        ///  showDenyButton: true,
        confirmButtonColor: "#3085d6",
        showCancelButton: true,
        confirmButtonText: "Yes. Set as completed",
        // denyButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    order_id: order_id,
                    item_id: item_id,
                    product_id: product_id,
                    log_id: log_id,
                    action: "markItemStatusAsCompleted",
                },
                method: "post",
                success: function (res) {
                    reload_order_item_table_mbt(order_id);
                },
            });
        }
    });
}
function sbr_markAsBogoItem(item_id, order_old_id, order_id) {
    Swal.fire({
        title: "BOGO Legacy Order Item",
        text: "You won't be able to revert this! ",
        icon: "warning",
        //  showDenyButton: true,
        confirmButtonColor: "#3085d6",
        showCancelButton: true,
        confirmButtonText: "Yes.",
        // denyButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    order_id: order_id,
                    item_id: item_id,
                    order_old_id: order_old_id,
                    action: "markAsBogoLegacyItem",
                },
                method: "post",
                success: function (res) {
                    reload_order_item_table_mbt(order_id);
                },
            });
        }
    });
}
jQuery(document).ajaxComplete(function (event, xhr, settings) {
    var stringUrl = settings.url;

    if (stringUrl.indexOf("advance_search") >= 0 || stringUrl.indexOf("simple_search") >= 0 || stringUrl.indexOf("batch_printing") >= 0) {
        if (stringUrl.indexOf("exclude_extra_whitening_tray_set=yes") >= 0) {
            extra_whitening_tray_exc = 'yes';
        }
        else {
            extra_whitening_tray_exc = '';
        }
        if (stringUrl.indexOf("exclude_night_guard_reorder=yes") >= 0) {
            night_guard_reorder_exc = 'yes';
        }
        else {
            night_guard_reorder_exc = '';
        }
        jQuery('.check-column input[type=checkbox]').each(function () {
            val = jQuery(this).val();
            if (val != 'on') {
                console.log(val);

                if (stringUrl.indexOf("product_status=waiting-impression") >= 0) {
                    reloadOrderEntry_ByStatus(jQuery(this).val(), 'waiting-impression');
                }
                else if (stringUrl.indexOf("product_status=pending-lab") >= 0) {
                    reloadOrderEntry_ByStatus(jQuery(this).val(), 'pending-lab');
                }
                else {
                    reloadOrderEntry(jQuery(this).val());
                }

            }

        });

    }
});