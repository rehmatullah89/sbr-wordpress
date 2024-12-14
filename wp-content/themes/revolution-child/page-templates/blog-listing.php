<?php

/*

Template Name: Article New Layout template

*/

get_header();


?>
<div class="loading-sbr" style="display: none;">
    <div class="inner-sbr"></div>
</div>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<style>
    .slick-initialized .slick-slide {
        width: auto !important;
    }

    button.slick-prev.slick-arrow {
        display: none !important;
    }

    button.slick-next.slick-arrow {
        display: none !important;
    }
</style>

<div class="blog-wrapper">
    <div class="vc_empty_space" style="height:90px"></div>
    <div class="blog-listing-title">
        <h1>ARTICLES WRITTEN BY <b class="blue-text weight-600"> OUR TEAM </b></h1>
        <h2 class="text-center">We geek out over dental care & teeth whitening.</h4>
    </div>
</div>

<!-- blog caetgory buttons -->

<div class="blog-menus-wrapper">
    <div class="menu-items">
        <ul class="menu-items-slick">
          
            <?php
            $categories = get_categories(array(
                'orderby' => 'name',
                'order'   => 'ASC',
                'parent' => 0
            ));

            foreach ($categories as $category) {
                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="slider-shadow"></div>
</div>
<?php /* ?>
<div class="feature-articles">
    <h2>Featured Articles</h2>
</div>
<div class="blog-cards-wrapper">
    <?php $articlesData = sbr_articles_callback('feature'); ?>
    <div class="card-list" id="feature_card-list">
        <?php echo $articlesData['articles'] ?>
    </div>

</div>

<div id="button-wrapper_feature">
    <?php echo $articlesData['load_more'] ?>
</div>
<?php */ ?>
<!-- cards -->
<?php $articlesData = sbr_articles_callback(); ?>
<div class="blog-cards-wrapper">
    <!--filters by-->
    <div class="filter-wrapper">
        <div class="filter">
            <div class="dropdown-blog" id="drop-down">
                <span>FILTER BY</span>
                <label>
                <input type="checkbox">
                <ul id="filterTags" autocomplete="off">
                    <li val="0">All</li>
                    <li val="kids">Kids</li>
                    <li val="teens">Teens</li>
                    <li val="Adults">Adults</li>
                    <li val="55">55+</li>
                    <li val="during-pregnancy">During pregnancy</li>
                    <li val="product-reviews">Product reviews</li>
                    <li val="professionals">For professionals</li>
                    <li val="ingredients">Ingredients</li>
                    <li val="interviews">Interviews</li>


                </ul>
            </label>
            </div>
        </div>
    </div>
    <div class="card-list" id="articles_card-list">
        <?php echo $articlesData['articles'] ?>
    </div>
</div>

<div id="button-wrapper_articles">
    <?php echo $articlesData['load_more'] ?>
</div>


<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.menu-items-slick').slick({
            responsive: [{
                    breakpoint: 9999,
                    settings: "unslick"
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: false,
                    }
                }
            ]
        });
    });

    jQuery('body').on('click', '#filterTags li', function() {
        jQuery('#articles_card-list').html('');
        jQuery('#button-wrapper_articles').html('');
        sbr_articles('listing', 1);
    });

    function sbr_articles(type, paged) {
        jQuery('.loading-sbr').show();
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: {
                action: 'sbr_articles',
                type: type,
                page: paged,
                tag: jQuery('#filterTags').find('.drop-selected').attr('val')

            },
            async: true,
            dataType: 'JSON',
            method: 'POST',

            success: function(res) {
                if (type == 'listing') {
                    jQuery('#articles_card-list').append(res.articles);
                    jQuery('#button-wrapper_articles').html(res.load_more);
                } else {
                    jQuery('#feature_card-list').append(res.articles);
                    jQuery('#button-wrapper_feature').html(res.load_more);
                }
                jQuery('.loading-sbr').hide();
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('.dropdown-blog ul>li').click(function() {
            $('.dropdown-blog ul>li').each(function() {
                $(this).removeClass('drop-selected');
            });
            $(this).toggleClass('drop-selected');
            if ($(this).attr("val") == 0) {
                $('.dropdown-blog>span').text('All')
            } else {
                $('.dropdown-blog>span').text($(this).text())
            }
        });
    });
</script>
<?php

get_footer();
