/*
 Repeat the content for making a package
 */
default_package = true;
jQuery(document).on('click', '.add-more a', function () {
    doRepeaterClone(jQuery(this).parent().parent());
});
jQuery(document).on('click', '.remove-itm', function () {
    jQuery(this).parent('.repeating-content').remove();
});
// remove group
jQuery(document).on('click','.remove-grp',function(){
    if(jQuery(this).parents('.repeater').hasClass('initial-reapeater')){
        //
    }
    else{
        jQuery(this).parents('.repeater').remove();
    }
})
function doRepeaterClone(parent_append='') {
    if(parent_append!=''){
          jQuery(parent_append).append(jQuery('.initital-content .repeating-content').clone());
    }
    else{
         jQuery('.repeater').append(jQuery('.initital-content .repeating-content').clone()); 
    }
  
    if (jQuery('.sellect2').hasClass('select2-hidden-accessible')) {
        jQuery(this).removeClass('select2-hidden-accessible');
    }
    // else{
    jQuery(document).find(".sellect2").select2({

        placeholder: "Please select product.",
        allowClear: true,
        width: '100%'
    });
    //}
}

jQuery(document).ready(function () {
    if (jQuery('.repeater .repeating-content').length == 0 && !default_package) {
        doRepeaterClone();
    }
});
/*
 * repeat groups
 */
jQuery(document).on('click', '.add-more-group a', function () {
    window.scrollTo({top: 0, behavior: 'smooth'}); 
    group_number= jQuery(document).find('.repeater').length;
    console.log(group_number);
    doRepeaterCloneGroup(group_number+1);
});
jQuery(document).on('click', '.remove-group-itm', function () {
    jQuery(this).parent('.repeating-group').remove();
});

function doRepeaterCloneGroup(group_id=1) {
     if (jQuery('.repeater').length == 1){
          jQuery(document).find('.initial-reapeater').before('<div class="repeater"> <div class="remove-grp"><a href="javascript:void(0);" class="btn button"> <span class="dashicons dashicons-trash"></span></a></div><input type="hidden" name="group_id[]" class="group_id" value="'+group_id+'"><div class="add-more"><a href="javascript:void(0);" class="btn button"><span class="dashicons dashicons-welcome-add-page"></span> Add Products</a></div></div>');
     }
     else{
          jQuery(document).find('.repeater').first().before('<div class="repeater"> <div class="remove-grp"><a href="javascript:void(0);" class="btn button"><span class="dashicons dashicons-trash"></span></a></div> <input type="hidden" name="group_id[]" class="group_id" value="'+group_id+'"><div class="add-more"><a href="javascript:void(0);" class="btn button"><span class="dashicons dashicons-welcome-add-page"></span> Add Products</a></div></div>');
     }
   
    
    //}
}

jQuery(document).ready(function () {
    if (jQuery('.repeater .repeating-group').length == 0 && !default_package) {
        doRepeaterCloneGroup();
    }
});
jQuery(document).on('submit', '#submitpackage', function (event) {
    event.preventDefault();
    has_error = false;
      combinations=[];
var counter=0;

jQuery(document).find('.repeater').each(function(){
inner_array = [];
var str='';
jQuery(this).find('.packaging-product').each(function(){
//inner_array[jQuery(this).val()]=jQuery(this).parent().parent().find('.min_qty').val()+'|'+jQuery(this).parent().parent().find('.max_qty').val();

            str +='{product_id:'+jQuery(this).val()+',';
            str +='min_qty:'+jQuery(this).parent().parent().find('.min_qty').val()+',';
            str +='shipment_level:'+jQuery(this).parent().parent().find('.shipment_level').val()+',';
            str +='max_qty:'+jQuery(this).parent().parent().find('.max_qty').val()+'}';
       
});

if(str!=''){
combinations[counter]=str;

}
counter++;
});
jQuery(document).find('.append-grp-data').val(JSON.stringify(combinations));
console.log(JSON.stringify(combinations));
    jQuery('#submitpackage input, #submitpackage select').each(function () {
        jQuery(this).removeClass('hass_error');
        if (jQuery(this).val() == '' && jQuery(this).attr('id') != 'all-components') {
            has_error = true;
            jQuery(this).addClass('hass_error');
        }
    });
    if (has_error) {
        Swal.fire(
                        '',
                        'Please Fill all the Mandatory Fields',
                        'error'
                        )
        return false;
    }


    jQuery("body").addClass("loading");
    data = jQuery('#submitpackage').serialize();
   data += '&combinations='+combinations;
   jQuery('.loading-sbr').show();
    jQuery.ajax({
        type: "post",
        method: 'POST',
        dataType: "json",
        url: ajaxurl,
        data: data,
        success: function (response) {
            
            if (response.status == "success") {
                jQuery("body").removeClass("loading");
                jQuery('#spinner-mbt-admin').css('visibility', 'hidden');
                jQuery('.component-items').append(response.options);
                Swal.fire(
                        '',
                        response.message,
                        'success'
                        )

                if (response.message != 'package is updated successfully') {
                    window.location.href = siteUrl + '/wp-admin/admin.php?page=packaging-dashboard';
                }
                if (response.message == 'package is updated successfully') {
                    location.reload();
                }
            } else {
                jQuery('.loading-sbr').hide();
                jQuery('#spinner-mbt-admin').css('visibility', 'hidden');
                Swal.fire(
                        '',
                        response.message,
                        'error'
                        )
            }
            jQuery("body").removeClass("loading");

        }
    })
});
jQuery(document).on('click', '.pacakge_component_heading', function () {
    //jQuery('.package_components').hide();
    return false;
    jQuery(this).parents('.package_contanier').find('.package_components').slideToggle().slideClass("active");
    jQuery('.package_components').each(function ($) {
        if ($(this).hassClass('active')) {
            //
        } else {
            $(this).hide();
        }
    });
});

jQuery(document).on('click', '.rem-element', function () {
    data_pcategory = jQuery(this).attr('data-pcategory');
    jQuery(this).parent().remove();
    jQuery("#all-components option[value=" + data_pcategory + "]").removeAttr('disabled');
});
jQuery(document).on('change', '#all-components', function () {
    //jQuery('.dependents').hide();
    valselected = jQuery(this).val();
    if (valselected != '') {
        if (jQuery('#package-' + valselected).length)
        {

            return false;
        }
        that = this;
        jQuery('#spinner-mbt-admin').css('visibility', 'visible');
        jQuery.ajax({
            type: "post",
            method: 'POST',
            dataType: "json",
            url: ajaxurl,
            data: {action: "mbt_get_product_components", 'p_category': valselected},
            success: function (response) {
                if (response.status == "success") {
                    jQuery("#all-components option[value=" + valselected + "]").attr('disabled', 'disabled');
                    jQuery('#spinner-mbt-admin').css('visibility', 'hidden');
                    jQuery('.component-items').append(response.options);
                } else {
                    jQuery('#spinner-mbt-admin').css('visibility', 'hidden');
                    Swal.fire(
                            '',
                            response.message,
                            'error'
                            )

                }
            }
        });
    }
});

// jQuery(document).find(".select21").select2({
//     placeholder: "Please select product.",
//     allowClear: true,
//     width: '100%'
// });
jQuery(document).ready(function () {
   setTimeout(function () {
       jQuery(document).find(".select22").select2({
           placeholder: "Please select product.",
           allowClear: true,
           width: '100%'
       });
   }, 1000);

});
var hrefnew;
jQuery(document).on('click','.remove-package',function(){
   hrefnew =jQuery(this).attr('data-href');
        swal.fire({
  title: "Are you sure?",
  text: "This package will be deleted permanently.",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, Delete it!",
  cancelButtonText: "No, cancel please!",
  closeOnConfirm: false,
  closeOnCancel: false
}).then((result) => {
    if (result.isConfirmed){
        window.location.href=hrefnew;
        //swal.fire("Done!", "It was succesfully deleted!", "success");
    }else{
        swal.fire("Error!", "Coudn't delet!", "error");
    }
});
});
jQuery(document).on('click','.check-grp',function(){
    var arr = {};
    package_id = jQuery(this).attr('data-package_id');
    group_id = jQuery(this).attr('data-group_id');
    jQuery(this).parent().find('.repeating-content').each(function(){
        product_id = jQuery(this).find('.packaging-product').val();
        qty = jQuery(this).find('.max_qty').val();
        shipment = jQuery(this).find('.shipment_level').val();
        arr[product_id+'|'+shipment]=qty;
        //arr.push({product_id:qty});
    });
    jQuery.ajax({
            type: "post",
            method: 'POST',
            dataType: "json",
            url: ajaxurl,
            data: {action: "check_duplicate_combinations", 'current_group': arr,'group_id':group_id,'package_id':package_id},
            success: function (response) {
                //var obj = jQuery.parseJSON(response);
                
                if (response.status == "success") {
                  Swal.fire(
                            '',
                            'No Duplication Found',
                            'success'
                            )
                   
                  
                }
                if (response.status == "error") {
                   console.log(response.status);
                    Swal.fire(
                            '',
                            response.message,
                            'error'
                            )
                    
                  
                }
            }
        });
    console.log(arr);
});
jQuery(document).on('click','.min_qty',function(){
    min_cuur_val = parseInt(jQuery(this).val());
    max_cuur_val = parseInt(jQuery(this).parent().parent().find('.max_qty').val());
    jQuery(this).attr('max',max_cuur_val);
    jQuery(this).parent().parent().find('.max_qty').attr('min',min_cuur_val);
});
jQuery(document).on('click','.max_qty',function(){
    max_cuur_val = parseInt(jQuery(this).val());
    min_cuur_val = parseInt(jQuery(this).parent().parent().find('.min_qty').val());
    jQuery(this).attr('min',min_cuur_val);
    jQuery(this).parent().parent().find('.min').attr('max',max_cuur_val);
});
jQuery(document).on('keyup','.min_qty',function(){
   
    min_cuur_val = parseInt(jQuery(this).val());
    max_cuur_val = parseInt(jQuery(this).parent().parent().find('.max_qty').val());
   
    if(min_cuur_val>max_cuur_val){
         
        jQuery(this).val(max_cuur_val);
    }
});
jQuery(document).on('keyup','.max_qty',function(){
    max_cuur_val = parseInt(jQuery(this).val());
    min_cuur_val = parseInt(jQuery(this).parent().parent().find('.min_qty').val());
    if(max_cuur_val<min_cuur_val){
        jQuery(this).val(min_cuur_val);
    }
});
