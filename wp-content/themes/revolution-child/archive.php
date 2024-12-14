<?php
get_header();
$category = get_category(get_query_var('cat'));
$cat_id = $category->cat_ID;
?>
<div class="loading-sbr" style="display: none;">
    <div class="inner-sbr"></div>
</div>
<!--category title-->
<div class="vc_empty_space" style="height:90px"></div>
<div class="category-lander-wrapper">
    <div class="vc_empty_space" style="height:90px"></div>
    <div class="heading-wrapper">
        <div class="title">
            <a href="<?php echo  site_url('articles/'); ?>"> <small>Science & Articles</small></a>
            <h1><?php echo $category->cat_name; ?></h1>
        </div>
    </div>
</div>

<?php $articlesData = sbr_articles_callback('listing', $cat_id); ?>
<!--cards-->
<div class="blog-cards-wrapper">

    <div class="filter-container">
        <!--category filter -->
        <div class="filter-category">
            <div class="dropdown">
                <button onclick="myFunction()" class="dropbtn">TOPIC: <span class="selected-category"><?php echo $category->cat_name; ?></span> </button>
                <div id="myDropdown" class="dropdown-content">
                    <a href="<?php echo  site_url('articles/'); ?>">ALL</a>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order'   => 'ASC',
                        'parent' => 0
                    ));

                    foreach ($categories as $category) {
                        if ($cat_id == $category->term_id) {
                            continue;
                        }
                        echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                    }
                    ?>

                </div>
            </div>
        </div>
        <!--filters by-->
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
        <?php /*
        <div class="filter-wrapper">
            <div class="filter">
            <select id="filterTags" autocomplete="off">
                <option value="0">FILTER BY</option>
                <!-- <optgroup label="LIFE STAGES"> -->
                    <option value="kids">Kids</option>
                    <option value="teens">Teens</option>
                    <option value="adults">Adults</option>
                    <option value="55">55+</option>
                    <option value="during-pregnancy">During pregnancy</option>
                <!-- </optgroup>
                <optgroup label="Ancillary"> -->
                    <option value="product-reviews">Product reviews</option>
                    <option value="professionals">For professionals</option>
                    <option value="ingredients">Ingredients</option>
                    <option value="interviews">Interviews</option>
                <!-- </optgroup> -->
            </select>
            </div>
        </div>
 */ ?>
    </div>

    <div class="card-list" id="articles_card-list">
        <?php echo $articlesData['articles'] ?>
    </div>
</div>
<div id="button-wrapper_articles">
    <?php echo $articlesData['load_more'] ?>
</div>
<script>
    /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    /*
    jQuery('body').on('change', '#filterTags', function() {
        jQuery('#articles_card-list').html('');
        jQuery('#button-wrapper_articles').html('');
        sbr_articles('listing', 1);
    });
*/
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
                cat: '<?php echo $cat_id; ?>',
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
