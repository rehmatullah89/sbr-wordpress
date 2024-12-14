<?php
/*
 * Shortcode for Stain cConcealer page
 */

function members_logos_shortcode() {
    ob_start(); // Start output buffering
    ?>


<style>
    .section-our-members {
  padding: 35px 0;
position: relative;
  z-index: 1;
  max-height: 110px;
  overflow: hidden;
}
.section-our-members .logo{text-align: center;}

.section-our-members .logo:not(.cnt-logo) img{ max-height: 38px;margin-left: auto;margin-right: auto;}

.section-our-members  .client-logos img{
    max-height: 67px;
}
.section-our-members .logo.cnt-logo img{ 
    max-height: 67px;
    margin-left: auto;
    margin-right: auto;
}
.slick-slide {
    margin: 0 15px;
  }
  
  
  .slick-list {
    margin: 0 -15px;
  }
 

</style>

    <section class="section SBRbrandsLogoes section-our-members logoesSection_one">
        <div class="container">
            <div class="customer-brand-slide align-items-center">
                <div class="logo health-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/health-logo.png" />
                </div>
                <div class="logo forbes-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/forbes-logo.png" />
                </div>
                <div class="logo fox-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/fox-logo.png" />
                </div>
                <div class="logo new-york-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/new-york-logo.png" />
                </div>
                <div class="logo client-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/client-logo.png" />
                </div>
                <div class="logo sleep-foundation-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/sleep-foundation-logo.png" />
                </div>

                <div class="logo health-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/health-logo.png" />
                </div>
                <div class="logo forbes-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/forbes-logo.png" />
                </div>
                <div class="logo fox-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/fox-logo.png" />
                </div>
                <div class="logo new-york-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/new-york-logo.png" />
                </div>
                <div class="logo client-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/client-logo.png" />
                </div>
                <div class="logo sleep-foundation-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/sleep-foundation-logo.png" />
                </div>

            </div>
        </div>
    </section>
    <?php
    return ob_get_clean(); // Return the buffered output
}
add_shortcode('members_logos', 'members_logos_shortcode');
?>



<?php
/*
 * Shortcode for proshield page
 */

function members_logos_shortcode_whitening_tray() {
    ob_start(); // Start output buffering
    ?>


<style>
    .section-our-members {
  padding: 35px 0;
position: relative;
  z-index: 1;
  max-height: 110px;
  overflow: hidden;
}


.section-our-members .logo{text-align: center;}

.section-our-members .logo:not(.cnt-logo) img{ max-height: 38px;margin-left: auto;margin-right: auto;}

.section-our-members  .client-logos img{
    max-height: 67px;
}
.section-our-members .logo.cnt-logo img{ 
    max-height: 67px;
    margin-left: auto;
    margin-right: auto;
}
.slick-slide {
    margin: 0 15px;
  }
  
  
  .slick-list {
    margin: 0 -15px;
  }

  @media only screen and (min-width: 768px) {

        /* for water flosser page */
        .postid-428535 .section-our-members{
            padding: 0;
        }
        /* for water flosser page  Ends*/

  }


  @media only screen and (max-width: 767px) {
        .postid-782204 .logoContainerSbr .column,.postid-782204 .logoContainerSbr  .columns
        ,  .postid-427572 .logos-container-mbt .wpb_column.columns.medium-12.thb-dark-column.small-12
        , .postid-428535 .logos-container-mbt .wpb_column.columns.medium-12.thb-dark-column.small-12
        
        {
            padding-left: 0;
            padding-right: 0;
        }

        /* for water flosser page */
        .postid-428535 .section-our-members{
            padding-bottom: 0;
        }
        /* for water flosser page  Ends*/

        
    }

</style>

    <section class="section SBRbrandsLogoes section-our-members teethWhiteningTray logoesSection_two">
        <div class="container">
            <div class="customer-brand-slide align-items-center">

                <div class="logo geha-logo">
                    <img class="img-fluid" src="https://www.smilebrilliant.com/wp-content/uploads/2024/10/geha-logo-blue-light-300x99-1.png" />
                </div>
                <div class="logo health-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/health-logo.png" />
                </div>
                <div class="logo forbes-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/forbes-logo.png" />
                </div>
                <div class="logo fox-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/fox-logo.png" />
                </div>
                <div class="logo new-york-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/new-york-logo.png" />
                </div>
                <div class="logo client-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/client-logo.png" />
                </div>
                <div class="logo sleep-foundation-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/sleep-foundation-logo.png" />
                </div>







                <div class="logo geha-logo">
                    <img class="img-fluid" src="https://www.smilebrilliant.com/wp-content/uploads/2024/10/geha-logo-blue-light-300x99-1.png" />
                </div>
                <div class="logo health-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/health-logo.png" />
                </div>
                <div class="logo forbes-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/forbes-logo.png" />
                </div>
                <div class="logo fox-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/fox-logo.png" />
                </div>
                <div class="logo new-york-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/new-york-logo.png" />
                </div>
                <div class="logo client-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/client-logo.png" />
                </div>
                <div class="logo sleep-foundation-logo">
                    <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/product-shine/images/members-logo/sleep-foundation-logo.png" />
                </div>



            </div>
        </div>
    </section>
    <?php
    return ob_get_clean(); // Return the buffered output
}
add_shortcode('members_logos_whitening_tray', 'members_logos_shortcode_whitening_tray');
?>


