<?php
global $wp;
$url_array = explode('/', wp_get_referer());
$term_id = 0;
if (isset($url_array['4']) && $url_array['4'] == 'category') {
	if (isset($url_array['5'])) {
		$term_id = get_category_by_slug($url_array['5']);
	}
}

get_header(); ?>
<div class="vc_empty_space" style="height:90px"></div>
<div class="blog-detail-container">
	<div class="bolg-detail-wrapper">
		<div class="blog-detail">
			<div class="title">
				<?php

				if ($term_id) {
					echo '<small>';
					echo '<a href="' . site_url('articles/') . '">Science & Articles</a> >> ';
					echo '<b><a href="' . get_category_link($term_id) . '">' . get_term($term_id)->name . '</a></b> </small>';
				} else {
					echo '<small>';
					echo '<a href="' . site_url('articles/') . '">Science & Articles</a> >> ';
					$categoriesPost = get_the_category(get_the_ID());
					$last_key = array_key_last($categoriesPost);
					foreach ($categoriesPost as $key => $cate) {
						if ($key == $last_key) {
							echo '<b><a href="' . get_category_link($cate->term_id) . '">' . $cate->name . '</a></b>';
						} else {
							echo '<b><a href="' . get_category_link($cate->term_id) . '">' . $cate->name . '</a>,</b>&nbsp;';
						}
					}
					echo '</small>';
				}

				/*
<small><a href="<?php echo  site_url('articles/'); ?>">Science & Articles</a> >> <b><a href="<?php echo  get_category_link(get_the_category(get_the_ID())[0]->term_id); ?>"><?php echo get_the_category(get_the_ID())[0]->name; ?></a></b> </small>
*/

				?>

				<h1><?php the_title(); ?></h1>

				<?php if (get_field('article_sub_title')) : ?>
					<h2><?php the_field('article_sub_title'); ?></h2>
				<?php endif; ?>
			</div>
			<div class="social-icons-wrapper">
				<div class="author">
					<?php

					$field_value = '';
					if(function_exists('bp_is_active')){
						$field_value = bp_get_profile_field_data(array(
							'field' => 'Referral',
							'user_id' => get_the_author_meta('ID'),

						));
					}




					$rdhTitle = get_field('rdh_titleline', 'user_' . get_the_author_meta('ID'));
					if ($rdhTitle) {
						$rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
					}
					if ($field_value != '') {
						$buddy_name = bp_core_get_username(get_the_author_meta('ID'));
						echo '<b><a href="/rdh/profile/' . $buddy_name . '">' . get_the_author_meta('display_name') . '</a>' . $rdhTitle . '</b>';
					} else {
						echo '<b>' . get_the_author_meta('display_name') . $rdhTitle . '</b>';
					}

					if (get_field('co_author')) :
						foreach (get_field('co_author') as $co_author) {
							echo '<span class="co-author">';
							$rdhTitle = get_field('rdh_titleline', 'user_' . $co_author);
							if ($rdhTitle) {
								$rdhTitle = ',<span>&nbsp;' . $rdhTitle . '</span>';
							}
							if ($field_value != '') {
								$buddy_name = bp_core_get_username($co_author);
								echo '<b><a href="/rdh/profile/' . $buddy_name . '">' . get_the_author_meta('display_name', $co_author) . '</a>' . $rdhTitle . '</b>';
							} else {
								echo '<b>' . get_the_author_meta('display_name', $co_author) . $rdhTitle . '</b>';
							}
							echo '</span>';
						}

					endif;
					?>

				</div>

				<div class="icons">
					<ul class="social-icon">

						<li>
							<a rel="nofollow" target="_blank" class="twitter-share-button" href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>+-+<?php the_permalink(); ?>">
								<i class="fa fa-twitter fa-lg"></i>
							</a>
						</li>
						<li>
							<a rel="nofollow" target="_blank" href="https://www.facebook.com/share.php?u=<?php the_permalink(); ?>&title=<?php the_title(); ?>">
								<i class="fa fa-facebook-square fa-lg"></i>
							</a>
						</li>
						<li>
							<a rel="nofollow" target="_blank" href="https://www.reddit.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>">
								<i class="fa fa-reddit fa-lg"></i>
							</a>
						</li>
						<li>
							<a rel="nofollow" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>">
								<i class="fa fa-google-plus fa-lg"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>


			<?php

			if (has_post_thumbnail()) :
				$feat_image = wp_get_attachment_url(get_post_thumbnail_id());
				echo '<div class="blog-image">';
				echo '<img src="' . $feat_image . '">';
				echo '</div>';
			endif;
			?>
			<div class="detail-description">
				<?php
				//$content = preg_replace('/ style=("|\')(.*?)("|\')/', '', get_the_content());
				//$content = preg_replace('/ align=("|\')(.*?)("|\')/', '', $content);
				//echo  $content;
				echo apply_filters('the_content', get_the_content());
				?>
			</div>
		</div>
		<div class="blog-detail-sidebar">
			<div class="related-blogs-wrapper">
				<?php

				$related = get_posts(array('category__in' => wp_get_post_categories(get_the_ID()), 'numberposts' => 5, 'post__not_in' => array(get_the_ID())));
				if ($related) {

					echo '<p class="title">RELATED ARTICLES</p>';
					echo '<div class="related-blogs">';

					foreach ($related as $post) {
						setup_postdata($post);
						echo '<div class="related-blog-box">';
						if (has_post_thumbnail()) {
							$feat_image = wp_get_attachment_url(get_post_thumbnail_id());
							echo '<div class="image">';
							echo '<img src="' . $feat_image . '">';
							echo '</div>';
						} else {
							echo '<div class="image">';
							echo '<img src="https://www.smilebrilliant.com/wp-content/uploads/2021/09/smilebrilliant-teeth-whitening-share.jpg">';
							echo '</div>';
						}

						echo '<div class="details">';
						echo '<h6> <a href=' . get_the_permalink() . '">' . get_the_title() . '</a> </h6>';
						echo '<p class="author">By: ' . get_the_author_meta('display_name');
						if (get_field('co_author')) :
							foreach (get_field('co_author') as $co_author) {
								echo '<span class="co-author">' . get_the_author_meta('display_name', $co_author) . ' </span>';
							}
						endif;
						echo '</p>';
						echo '</div>';
						echo '</div> ';
					}
					echo '</div>';
				}
				wp_reset_postdata();

				$postCategories = array();
				foreach ((get_the_category()) as $cate) {
					$postCategories[] = $cate->term_id;
				}
				?>
				<div class="categories-wrapper">
					<div class="categories-list">
						<p>TOPICS</p>
						<ul>
							<li>
								<a href="<?php echo  site_url('articles/'); ?>">ALL</a>
							</li>
							<?php
							$categories = get_categories(array(
								'orderby' => 'name',
								'order'   => 'ASC',
								'parent' => 0
							));
							foreach ($categories as $category) {
								$activeClass = "";
								if (in_array($category->term_id, $postCategories)) {
									$activeClass = "active";
								}
								echo '<li><a class="' . $activeClass . '"  href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
							}
							?>

						</ul>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<?php
get_footer();
