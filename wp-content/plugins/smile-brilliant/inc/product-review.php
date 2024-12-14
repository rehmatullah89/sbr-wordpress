<?php
/**
 * Display the product rating HTML and related scripts.
 *
 * @action product_rating_html
 */
add_action('product_rating_html', 'product_rating_html_callback');

/**
 * Callback function to display the product rating HTML and related scripts.
 */
function product_rating_html_callback()
{
?>

    <div class="form-popup ult-overlay addReviewFormPop" id="addReviewForm" style="display:none">
        <div class="popupInnerBody ult_modal">
            <div class="ult_modal-content">

                <button type="button" class="cancel cancelButton"><i class="fa fa-times" aria-hidden="true"></i>
                </button>
                
                <div class="container-inner-section" id="reviewContainerSection">

                </div>


            </div>
        </div>
    </div>

    <script>
        jQuery('#addReviewForm .cancelButton').on('click', function() {
            jQuery("#addReviewForm").css("display", "none");
            jQuery("body").removeClass("popupOpen");
        });

        function addProductReview(product_id, item_id, order_number) {

            
            var html =
                '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
            html +=
                '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
            html +=
                '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
            html +=
                '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';
            html +=
                '<div class="wrapper-cell"><div class="image"></div><div class="text"><div class="text-line"> </div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div></div></div>';


            jQuery('body').find('#reviewContainerSection').html(html);
            jQuery("#addReviewForm").css("display", "block");
            jQuery("body").addClass("popupOpen");
            var data = {
                product_id: product_id,
                item_id: item_id,
                order_id: order_number,
                action: 'loadRatingPopup'
            };
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: data,
                async: true,
                dataType: 'html',
                method: 'POST',
                beforeSend: function(xhr) {

                },
                success: function(response) {
                    jQuery('body').find('#reviewContainerSection').html(response);

                },
                error: function(xhr) {
                    jQuery('body').find('#reviewContainerSection').html('Request failed...Something went wrong.');
                },
                cache: false,
            });
        }

        jQuery('body').on('click', '#submitFormRating', function() {


            if (!jQuery.trim(jQuery('body').find('#review_textarea').val())) {
                jQuery('body').find('#review_textarea').css('border', '1px solid red');
                return;
            }
            jQuery('.loading-sbr').show();
            var elementT = document.getElementById("review-form");
            var formdata = new FormData(elementT);
            jQuery.ajax({
                url: ajaxurl,
                data: formdata,
                async: true,
                dataType: 'html',
                method: 'POST',
                success: function(response) {
                    jQuery('body').find('#reviewContainerSection').html(response);
                    jQuery('.loading-sbr').hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });


        });
    </script>
<?php
}
/**
 * Load the rating popup content via AJAX.
 *
 * @action wp_ajax_loadRatingPopup
 */
add_action('wp_ajax_loadRatingPopup', 'loadRatingPopup_callback');

/**
 * Callback function to load the rating popup content FOR MY ACCOUNT
 */

function loadRatingPopup_callback()
{

    $product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : 0;
    global $wpdb;
    $user = wp_get_current_user();
    if ($user->ID == 0)
        return false;
    $review = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}comments WHERE comment_post_ID = $product_id AND comment_author_email = '{$user->user_email}'", ARRAY_A);
    $review_id = 0;
    $review_message = '';
    $rating = 1;
    if ($review) {
        $review_id = $review['comment_ID'];
        $review_message = $review['comment_content'];
        $rating = get_comment_meta($review_id, 'rating', true);
    }
    $activeClass = array(
        1 => 'active',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
    );


    $activeChecked = array(
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
    );
  

    if ($rating > 1) {

        for ($x = 1; $x <= $rating; $x++) {
            $activeClass[$x] = 'active';
            $activeChecked[$rating] = 'checked=""';
        }
    }
?>
    <form id="review-form">
        <h2>Write Your Review</h2>
        <p class="font-14">
            We strive to provide the best possible service for our clients. Please leave a review to let us
            know how we are doing and to share your experience with others.
        </p>


        <div id="rating">
            <div class="star-rating">
                <input id="star-5" type="radio" name="rating" value="5"   <?php echo $activeChecked[5]; ?> />
                <label for="star-5" title="5 stars" class="<?php echo $activeClass[5]; ?>">
                    <i class="<?php echo $activeClass[5]; ?> fa fa-star" aria-hidden="true"></i>
                </label>

                <input id="star-4" type="radio" name="rating" value="4"  <?php echo $activeChecked[4]; ?>/>
                <label for="star-4" title="4 stars" class="<?php echo $activeClass[4]; ?>">
                    <i class="<?php echo $activeClass[4]; ?> fa fa-star" aria-hidden="true"></i>
                </label>
                
                <input id="star-3" type="radio" name="rating" value="3" <?php echo $activeChecked[3]; ?> />
                <label for="star-3" title="3 stars" class="<?php echo $activeClass[3]; ?>">
                    <i class="<?php echo $activeClass[3]; ?> fa fa-star" aria-hidden="true"></i>
                </label>
                
                <input id="star-2" type="radio" name="rating" value="2"  <?php echo $activeChecked[2]; ?>/>
                <label for="star-2" title="2 stars" class="<?php echo $activeClass[2]; ?>">
                    <i class="<?php echo $activeClass[2]; ?> fa fa-star" aria-hidden="true"></i>
                </label>
                
                <input id="star-1" type="radio" name="rating" value="1"  <?php echo $activeChecked[1]; ?>/>
                <label for="star-1" title="1 star" class="<?php echo $activeClass[1]; ?>">
                    <i class="<?php echo $activeClass[1]; ?> fa fa-star" aria-hidden="true"></i>
                </label>
            </div>

        </div>
        <span id="starsInfo" class="help-block">
            Click on a star to change your rating 1 - 5, where <span style="color:#3c98cc;font-weight: 600;">5 = great!</span> and <span style="color:#ff5722;font-weight: 600;">1 = really bad</span>
        </span>
        <div class="form-group">
            <!-- <label class="control-label" for="review">Your Review:</label> -->
            <textarea class="form-control" rows="10" placeholder="Write Your Reivew" name="review" id="review_textarea"><?php echo $review_message; ?></textarea>
        </div>
        <span id="submitInfo" class="help-block">
            By clicking <strong>Submit</strong>, I authorize the sharing of my name and review
            on the smilebrilliant website. (email will not be shared)
        </span>
        <input type="hidden" value="save_product_review_sbr" name="action" />
        <input type="hidden" value="<?php echo $product_id; ?>" name="product_id" />
        <input type="hidden" value="<?php echo $review_id; ?>" name="review_id" />
        <a href="javascript:void(0);" id="submitFormRating" class="btn btn-primary">Submit</a>

    </form>


<?php
    die;
}



/**
 * Save or update a product review via AJAX.
 *
 * @action wp_ajax_save_product_review_sbr
 */
add_action('wp_ajax_save_product_review_sbr', 'saveProductReview_callback');

/**
 * Callback function to save or update a product review.
 */
function saveProductReview_callback()
{
    if (isset($_REQUEST['review_id']) && $_REQUEST['review_id'] > 0) {
        $review_id = $_REQUEST['review_id'];
    } else {
        $review_id = 0;
    }
    if ($review_id > 0) {
        $commentarr = array();
        $commentarr['comment_ID'] = $review_id;
        $commentarr['comment_approved'] = 0;
        $commentarr['comment_content'] =  $_REQUEST['review'];
        wp_update_comment($commentarr);
        update_comment_meta($review_id, 'rating', $_REQUEST['rating']);
        echo '<div class="updateReview reviewResponce">Review updated successfully. Thank you!</div>';
    } else {
        $user = wp_get_current_user();
        if ($user->ID == 0) {
            echo '<div class="reviewError reviewResponce">Something went wrong. please contact with customer support. Thank you!</div>';
        } else {
            $ip = '';
            if (array_key_exists('HTTP_CF_CONNECTING_IP', $_SERVER)) {
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
            }
            $review_id = wp_insert_comment(array(
                'comment_post_ID'      => $_REQUEST['product_id'],
                'comment_author'       => $user->user_firstname . ' ' . $user->user_lastname,
                'comment_author_email' => $user->user_email,
                'comment_author_url'   => '',
                'comment_content'      => $_REQUEST['review'],
                'comment_type'         => '',
                'comment_parent'       => 0,
                'user_id'              => $user->ID,
                'comment_author_IP'    => $ip,
                'comment_agent'        => '',
                'comment_date'         => date('Y-m-d H:i:s'),
                'comment_approved'     => 0,
            ));

            update_comment_meta($review_id, 'rating', $_REQUEST['rating']);
            //   update_comment_meta($review_id, 'order_id', $_REQUEST['order_id']);
            ///  update_comment_meta($review_id, 'item_id', $_REQUEST['item_id']);
            echo '<div class="reviewSuccess reviewResponce">Thank you for giving us your valuable feedback about our product.</div>';
        }
    }
    die;
}
