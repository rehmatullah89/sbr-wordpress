

//jQuery('#woocommerce-order-notes').on('click', 'a.delete_note_listing', this.delete_order_note_mbt);


function delete_order_note_mbt(obj) {
    if (confirm("Click Okay to Delete or Click Cancel")) {
        var note = jQuery(obj).closest('li.note');

        jQuery(note).block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });

        var data = {
            action: 'delete_order_note_mbt',
            note_id: jQuery(note).attr('rel'),

        };

        jQuery.post(ajaxurl, data, function () {
            jQuery(note).remove();
        });
    }

    return false;
}
function toggleClassMbtEdit(obj) {
    jQuery(obj).parents('.description').toggleClass('toggled');
}
function saveNoteMbt(obj) {
    note_text = jQuery(obj).parents('.description').find('.div-editText').text();
    note_id = jQuery(obj).parents('.note').attr('rel');
    if (note_id != '' && note_text != '') {
        jQuery.ajax({
            url: ajaxurl,
            method: 'post',
            data: 'action=saveNoteMbt&note_id='+ note_id+'&note_text='+note_text,
            success: function (response) {
              jQuery(obj).parents('.description').toggleClass('toggled');
            }
        });
    }
}
/*
 * order notes
 */
function get_admin_notes_ajax(order_id) {
     jQuery('.loading-sbr').show();
                var reshtml = '';
                if (order_id != '') {
                    jQuery.ajax({
                        url: ajaxurl,
                        data: 'action=get_order_internal_notes_by_orderid&order_id=' + order_id,
                        async: false,
                        method: 'POST',
                        success: function (response) {
                            reshtml = response;
                             jQuery('.loading-sbr').hide();

                        },

                    });

                }
                return reshtml;
            }
jQuery(document).on('click', '.sbr-button-order-add-notes', function () {
   
                let order_id = jQuery(this).attr('data-order-id');
                let is_customer_note = jQuery(this).attr('data-is_customer_note');
                popup_title = 'View Notes';
                if (is_customer_note == 1)
                    popup_title = 'Add Personalized Followup';
                admin_notes = get_admin_notes_ajax(order_id);
                console.log(admin_notes);
                
                Swal.fire({
                    title: popup_title,
                    html: ' <div id="appendres" style="color:red"></div>' + admin_notes + '<textarea id="order_note" placeholder="Note..." name="order_note" rows="10" cols="50" class="swal2-input" style="height:100px;"></textarea><input type="hidden" id="order_id" value="' + order_id + '" class="swal2-input" placeholder="Last Name"><input type="hidden" id="is_customer_note" value="' + is_customer_note + '" class="swal2-input">',
                    showLoaderOnConfirm: true,
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Add Note',
                    showLoaderOnConfirm: true,
                    customClass: {
                        popup: 'full-width-swal',
                    },
                    preConfirm: (login) => {
                        const order_note = Swal.getPopup().querySelector('#order_note').value
                        const order_id = Swal.getPopup().querySelector('#order_id').value
                        const is_customer_note = Swal.getPopup().querySelector('#is_customer_note').value
                        data_f = 'order_id=' + order_id + '&is_customer_note=' + is_customer_note + '&order_note=' + order_note + '&action=create_woo_order_note';
                        if (!order_note) {
                            Swal.showValidationMessage('Please Fill the Note')
                        }
                        return fetch(ajaxurl +'?'+data_f)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(response.statusText)
                                    }
                                    return response.json()
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                            'Request failed: ${error}'
                                            )
                                })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result);
                        res = result.value;
                        if (res.status == "0") {
                            jQuery('#appendres').html(res.error);
                            Swal.fire({
                                title: 'Error',
                                text: res.error
                            })
                        }
                        if (res.status == "1") {
                            Swal.fire({
                                title: 'Success',
                                text: "Note added successfully"
                            });
                             reloadOrderEntry(order_id);
                        }
                    }
                });
            });