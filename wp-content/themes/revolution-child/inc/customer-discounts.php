<?php

add_action('woocommerce_account_customer_discounts_endpoint', 'sbr_customer_account_customer_discounts_content');
function sbr_customer_account_customer_discounts_content()
{
    echo "<div class='shine-discount-card-mobile-wrapper'>";
  
    get_template_part('page-templates/customer-discounts-my-account');
    
    echo "</div>";
}