<?php
/*
Template Name: Live geha widget test
*/

//get_header();
echo '<div id="smilebrilliant_geha_widget_main"></div>';
$url = "https://smilebrilliant.com/geha-widget";
?>
<script>
	<?php
echo file_get_contents($url);
?>
</script>

<?php


//get_footer();
?>