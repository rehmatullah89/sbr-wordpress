<?php
die();
/**
Template Name: import script
 */
get_header();
$nextnumber =$_GET['page_num']+1;
?>
<script>
    <script>

location_new = "<?php echo home_url();?>/script-import?page_num=<?php echo $nextnumber;?>&addrefferals=true";

window.location = location_new;

    function import_affiliat_refferals(){
         $.ajax({
             type : "POST",
             url : "/wp-admin/admin-ajax.php",
             data : {action: "import_affiliat_refferals"},
             success: function(response) {

                        console.log(response);
                      import_affiliat_refferals();
                  
                   
                }
        });   
    }
    
jQuery(document).ready(function(){
   //import_affiliat_refferals();
   
});
</script>