<?php

/*

Template Name: Faqs

*/

get_header();
global $wp;
$faq_id=get_query_var('faq_id','');
$scroll_to=get_query_var('scroll_to','');

if($faq_id =='impressions'){
   $faq_id = 861491;
}
if($faq_id =='mouthguard'){
   $faq_id = 861492;
}
if($faq_id =='bad-impression'){
   $faq_id = 861493;
}


//  echo do_shortcode('[ultimate-faqs]');
// echo 'Data: <pre>' .print_r($faq_id,true). '</pre>';
//echo do_shortcode('[ultimate-faqs cat="101"]'); 
?>


<style type='text/css'>

#contactFormTitle{ margin-top: 120px;} 
h2.product-header-sub{    margin-top: 20px;}
.category-title{
padding-bottom:0px;margin-top:52px;margin-bottom:0px;color:#4597cb;font-family:Montserrat;font-weight:normal;font-size:31px;    
font-weight: 400;
}
.faq-question-section {
    padding: 30px;    padding-left: 16px;
}
.faq-question-text {

    font-size: 22px;
    color: #565759;
    font-family: Montserrat;
    line-height: 1em;
    font-weight: normal;
    padding-top: 0px;
    display: block;
    font-weight: 400;
        padding-left: 12px;
}
.faq-answer-text {
    font-size: 1.3em;
    color: #565759;
    padding: 20px;
    padding-left: 30px;
    padding-right: 30px;
    display: none;
}
p strong {
    color: #222222;
}
.faq-question-section  p,.faq-question-section ul li {
    margin: 0 0 10px;
    line-height: 26px;font-size: 18px;
}
.faq-question-section p:last-child {
    margin-bottom: 0;
}
.faq-question-section.active {
    background-color: rgb(238, 238, 238);
}
.faq-question-section.active a {
    color: rgb(69, 151, 203);
}
.faq-question-text a:hover,.faq-question-text p a:hover {
    color: #ee9982;
}
.faq-question-section ul {
    padding-left: 40px;
}
.faq-question-section ul li{ margin-bottom: 0; }



    @media (max-width : 767px)
    {

        .product-header-primary {
            font-size: 2.3em;
        }
        section .product-header-sub{
            font-size: 1.2em;
             margin-bottom: 30px;
        }
        .faq-answer-text{ 
    padding-left: 10px;
    padding-right: 10px;
         }




    }




</style>


<section class="text-center" id="faq-page">
    <h1 class="product-header-primary" id="contactFormTitle">FREQUENTLY ASKED QUESTIONS</h1>
    <h2 class="product-header-sub weight-300">Because sometimes long-winded answers are needed.</h2>
</section>
<section class="faqs-content-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                  <?php
                  $faq_category_slugs = ['most-popular','product','helpful-tips', 'shipping-returns','science-results','caripro','night-guards','ultrasonic-cleaner','instruction-manuals']; // Add your category slugs here
                  $faq_count = 1;
                  foreach ($faq_category_slugs as $slug) {
                  // Get the term by slug
                  $category = get_term_by('slug', $slug, 'ufaq-category');
              
                  if ($category) {
                      // Query FAQs for the current category
                      $faqs = new WP_Query([
                          'post_type' => 'ufaq',
                          'tax_query' => [
                              [
                                  'taxonomy' => 'ufaq-category',
                                  'field' => 'slug',
                                  'terms' => $slug,
                              ]
                          ],
                          'posts_per_page' => -1, // Get all FAQs in this category
                      ]);
              
                      if ($faqs->have_posts()) {
                          // Output the category title
                          echo '<h4 class="category-title">' . esc_html($category->name) . '</h4>';
                          echo '<hr>';
              
                          // Initialize counter
                          while ($faqs->have_posts()) {
                              $faqs->the_post();
                              $contentPage = get_the_content();
                              // Format each FAQ
                              echo '<div class="faq-question-section" id="faqSection' . get_the_id() . '">';
                              echo '<a href="javascript:;" id="question' . get_the_id() . '" class="faq-question-text">' . get_the_title() . '</a>';
                              
                              if (!empty($contentPage)) {
                                 echo '<div id="faqAnswer' . esc_attr(get_the_id()) . '" class="faq-answer-text" style="display:none;">' . apply_filters('the_content', $contentPage) . '</div>';
                             }
                              echo '</div>';
              
                              $faq_count++; // Increment the counter
                          }
              
                          wp_reset_postdata(); // Reset after each loop
                      }
                  }
              }
              
?>
</div>
</div>
        </div>
</section>

<script>
    
jQuery(document).ready(function($){
  //you can now use $ as your jQuery object.
  $(".faq-question-text").click(function() {
    $(this).parent().addClass('active').find('.faq-answer-text').slideToggle(500);
    $(".faq-question-text").not(this).parent().removeClass('active').find('.faq-answer-text').slideUp(500);
  });
});

</script>

<?php
if($scroll_to!=''){
    ?>
<Script>
jQuery(document).ready(function($){
    setTimeout(function(){
  //you can now use $ as your jQuery object.

  jQuery('html, body').animate({
        scrollTop: jQuery('#instructions-manuals').offset().top-250
    }, 2000);
    }, 1000);
});
</script>
<?php
}
?>
<?php
if($faq_id!=''){
    ?>
<Script>
jQuery(document).ready(function($){
    setTimeout(function(){
  //you can now use $ as your jQuery object.

  jQuery('html, body').animate({
        scrollTop: jQuery('#faqSection<?php echo $faq_id;?>').offset().top-160
    }, 2000);
  jQuery('#question<?php echo $faq_id;?>').click();

    }, 1000);
});
</script>
<?php
}
?>
<?php

get_footer();
?>