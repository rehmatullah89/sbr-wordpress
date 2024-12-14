jQuery(document).on("click", ".view-detail-btn", function ($) {
var text=jQuery(this).text();
if(text=='View Detail'){
    jQuery(this).text('Close Detail');
}
else{
   jQuery(this).text('View Detail'); 
}

jQuery(this).parent().parent().nextAll().slideToggle();
    //jQuery(this).parent().parent().nextAll().show();
    jQuery('.replay-box textarea').show();

    var ticket_id = jQuery(this).attr('data-ticketid');
    var user_id = jQuery(this).attr('data-userid');
    var ajax_url = '/wp-admin/admin-ajax.php';
    data = 'ticket_id=' + ticket_id + '&user_id=' + user_id + '&action=zendesk_get_commnets_by_id';
    if (jQuery("#" + ticket_id + ' .appenddata').html() == '') {

        jQuery('.loading-contentt').show();
        jQuery.ajax({
            url: ajax_url,
            data: data,
            type: "POST",
            success: function (response) {

                jQuery("#" + ticket_id + ' .appenddata').html(response);
                jQuery('.loading-contentt').hide();
            }

        });
    }

});
/*
 * Add Ticket
 */
jQuery(document).on("submit", "#submit_ticket_form", function (e) {
    has_error = false;
 
    e.preventDefault();
    jQuery(".error-message").remove();
     jQuery("#ticket_subject, #ticket_message").removeClass("has_error");
 if (jQuery("#ticket_subject").val() == '') {
        jQuery("#ticket_subject").addClass('has_error');
        jQuery("#ticket_subject").after('<span class="error-message" style="color: red;">Please Enter the subject for Ticket</span>');
        has_error = true;
    }
    if (jQuery("#ticket_message").val() == '') {
        jQuery("#ticket_message").addClass('has_error');
        jQuery("#ticket_message").after('<span class="error-message" style="color: red;">Please Enter the Description for Ticket</span>');
        has_error = true;
    }
  
    if (has_error) {
        return false;
    }
   if(!has_error){
        jQuery('.loading-contentt').show();
     var data = jQuery(this).serialize();   
    
     console.log(data);
     
     jQuery.ajax({
         data:data,
         url:'/wp-admin/admin-ajax.php',
         type:'POST',
         success:function(response){
             
             if(response=="sub_error"){
                 jQuery("#ticket_subject").addClass('has_error');
                 jQuery("#ticket_subject").after('<span class="error-message" style="color: red;">Please Enter the subject for Ticket</span>');
             }
            else if(response=="mess_error"){
                 jQuery("#ticket_message").addClass('has_error');
                 jQuery("#ticket_message").after('<span class="error-message" style="color: red;">Please Enter the Description for Ticket</span>');
             }
             if(response=="success"){
                 jQuery('.loading-contentt, #submit-ticketform').hide();
                 swal("Ticket sent!", "Your Ticket is sent successfully", "success");
               setInterval(function () {
                              location.reload();
                            }, 2000);
             }
             else{
               
               jQuery('.loading-contentt, #submit-ticketform').hide();
                 swal("Ticket not sent!", "Your Ticket is sent please contact to site admin", "warning");
               setInterval(function () {
                              location.reload();
                            }, 2000);
             }
              jQuery('.loading-contentt').hide();
              
         }
     });
     
   }
   
});
/*
 * Add Comment
 */
jQuery(document).on("submit", ".comment-zendesk", function () {
    has_error = false;
    event.preventDefault();
    formid= jQuery(this).attr("id");
    

    comment_rep= jQuery("#"+formid+" #comment-rep");
    jQuery(".error-message").remove();
     jQuery("#comment-rep").removeClass("has_error");
   if (jQuery(comment_rep).val() == '') {
        jQuery(comment_rep).addClass('has_error');
        jQuery(comment_rep).after('<span class="error-message" style="color: red;">Please Enter the Description for Ticket</span>');
        has_error = true;
    }
    
   
    if (has_error) {
        return false;
    }
   if(!has_error){
        jQuery('.loading-contentt').show();
     var data = jQuery(this).serialize();   
    
     
     jQuery.ajax({
         data:data,
         url:'/wp-admin/admin-ajax.php',
         type:'POST',
         success:function(response){
             
             
           if(response=="mess_error"){
                 jQuery(comment_rep).addClass('has_error');
                 jQuery(comment_rep).after('<span class="error-message" style="color: red;">Please Enter the Description for Ticket</span>');
             }
             else{
                 jQuery('.response-div').html(response);
                 jQuery('.loading-contentt div').html(response);
             }
              location.reload();
         }
     });
     
   }
   
});
/*
 * Update Ticket
 */
jQuery(document).on("click", ".close_ticket", function () {
    //var confirm_close = confirm("Are You shure you want to update this ticket!");
   // if(confirm_close==true){
    var ticket_id=jQuery(this).attr('data-ticketid');
    var commnet_form_id=jQuery(this).prev('form').attr('id');
    commnet_form_id='#'+commnet_form_id;
    comment=jQuery(commnet_form_id+' #comment-rep').val();
    status=jQuery('#ticket_status').val();
   
    if(ticket_id!=''){
    data='ticket_id='+ticket_id+'&comment='+comment+'&action=zendesk_update_ticket&status='+status;
    jQuery('.loading-contentt').show();
    
    
     
     jQuery.ajax({
         data:data,
         url:'/wp-admin/admin-ajax.php',
         type:'POST',
         success:function(response){
             
          jQuery('.response-div').html(response);
          
              jQuery('.loading-contentt div').html(response);
              location.reload();
         }
     });
 }
   
    //}
});

jQuery(document).on("click",".ticket-subject",function($){
    var parent_id = jQuery(this).parent().parent().parent().attr('id');
    parent_id = '#'+parent_id;
    
    jQuery(parent_id+' .view-detail').click();
    
});
jQuery(document).on("click",".view-detail, .back-btn",function($){
     jQuery('.loading-contentt').show();
    
});
