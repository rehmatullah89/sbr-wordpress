<?php

/*

Template Name: Article Temp

*/

get_header();


?>
<style>
.justify-content-center {
    -ms-flex-pack: center;
    justify-content: center;
}	
.sep-top-4x {
    padding-top: 6.5em;
}

hr {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #eee;max-width: 100%;
}
h1.product-header-primary {
    margin-bottom: 0;
}
h2.product-header-sub{
	    margin-top: 12px;
}

.post-title a {
    color: #565759;
    font-family: Montserrat;
    font-size: 32px;
    line-height: 35px;
}
.post-title a:hover{
	    color: #f8a18a;
}

article {
    padding-top: 4.3em;
}

ul.social-icon {
    text-align: right;list-style: none; 
}
ul.social-icon li{
	list-style: none;     display: inline-block;
    padding: 0 20px 0 0;
}
.readmore-link {
    text-align: right;
}
.body-cntn-article{ margin-top: 20px; }
section.articles-page h2.product-header-sub{ font-weight:300;}


</style>



<section class="articles-page">
	<div class="text-center sep-top-4x">
		<h1 class="product-header-primary" style="margin-top:40px;"> ARTICLES WRITTEN BY <span style="color:#4597cb;">OUR TEAM</span>
		</h1>
		<h2 class="product-header-sub">We geek out over dental care &amp; teeth whitening.</h2>
	</div>
	<hr>

    <?php
    $args = array( 'posts_per_page' => 100, 'offset'=> 1);

    $myposts = get_posts( $args );
    foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
        <article>
        	<div class="row justify-content-center ">
	        	<div class="col-md-10">
	        		<header>
	        			<div class="row">
	        				<div class="col-md-9">
	        					<h3 class="post-title">
	        						<a href="<?php the_permalink(); ?>" class="dark"><?php the_title(); ?></a>		
	        					</h3>
	        				</div>
	        				<div class="col-md-3 readmore-link hidden-mobile">
	        					<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-large ">READ MORE</a>
	        				</div>
	        			</div>
	        		</header>
	        		<div class="body-cntn-article row">
	        			<div class="col-md-12">
		            		<?php the_excerpt() ?>

						<div class="show-mobile readmore-link">
        					<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-large ">READ MORE</a>
        				</div>

		            	</div>
		        	</div>
		           <div class="social-icons-mbtt">
<ul class="social-icon">
							<li>
								<a rel="nofollow" target="_blank" class="twitter-share-button" href="https://twitter.com/intent/tweet?text=<?php the_title();?>+-+<?php the_permalink();?>">
									<i class="fa fa-twitter fa-lg"></i>
								</a>
							</li>
							<li>
								<a rel="nofollow" target="_blank" href="https://www.facebook.com/share.php?u=<?php the_permalink();?>&title=<?php the_title();?>">
									<i class="fa fa-facebook-square fa-lg"></i>
								</a>
							</li>
							<li>
								<a rel="nofollow" target="_blank" href="https://www.reddit.com/submit?url=<?php the_permalink();?>&title=<?php the_title();?>">
									<i class="fa fa-reddit fa-lg"></i>
								</a>
							</li>
							<li>
								<a rel="nofollow" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink();?>">
									<i class="fa fa-google-plus fa-lg"></i>
								</a>
							</li>
						</ul>		           	

		           </div> 
	          </div>
        </div>
        </article>
    <?php endforeach; 
    wp_reset_postdata();?>


    </section>



<?php

get_footer();

