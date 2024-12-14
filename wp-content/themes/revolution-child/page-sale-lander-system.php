<?php

/* Template Name: Shop Landing Page */

	$vc                 = class_exists( 'WPBakeryVisualComposerAbstract' );

	$enable_pagepadding = get_post_meta( get_the_ID(), 'enable_pagepadding', true );

	$classes[]          = 'on' === $enable_pagepadding ? 'page-padding' : false;

	$bannerh1 =  get_field('banner_h1');

	$banner_h2 =  get_field('banner_h2');

	$banner_background_color =  get_field('banner_background_color');

	$banner_hero_image =  get_field('banner_hero_image');
	$button_background_color =  get_field('button_background_color');
	

?>

<?php get_header(); ?>

<style>

	.hentry > .row.wpb_row.row-fluid:not(.banner-featured-section){ display: none;}
.product-selection-price-wrap .btn,.section-button button,.section-button a {
	background-color:<?php echo $button_background_color;?> !important;
	text-transform: uppercase;
}
</style>





	<section class="shopLanderPageHader">

		<div class="pageHeader">

			<div class="pageheaderTop" style="background:<?php echo $banner_background_color;?>">

				<div class="row no-flex">

					<?php echo $bannerh1;?>

					<?php echo $banner_h2;?>



				<div class="whitening-teeth-girl-with-smile">

						<img src="<?php echo $banner_hero_image;?>" alt="" />

				</div>



				</div>

			</div>

			<div class="pageheaderBotm">

			<div class="row no-flex">				

				<div class="flex-row">

					<div class="filterproductsOption">

						<select id="filter_products">

						

						</select>

					</div>



					<div class="all-product-dropdown">

						<select id="price-sort">

						<option value="default">Recommended</option>

						<option value="price-low-to-high">Low price to high</option>

						<option value="price-high-to-low">high price to low</option>

						<option value="newest">Newest</option>

						</select>

					</div>


						<div class="resetFilter">
							<a href="javascript:;" id="resetButton">Reset </a>
						</div>


				</div>

				</div>				

			</div>



		</div>







	</section>





<?php

if ( have_posts() ) :

	while ( have_posts() ) :

		echo apply_filters('the_content', get_the_content());

		?>

			<?php

			if ( post_password_required() ) {

				get_template_part( 'inc/templates/password-protected' );

			} elseif ( $vc && ! thb_is_woocommerce() ) {

				?>

		<div <?php post_class( $classes ); ?>>

				<?php echo apply_filters('the_content', get_the_content()); ?>

		</div>

		<?php } elseif ( thb_is_woocommerce() ) { ?>

		<div <?php post_class( 'page-padding' ); ?>>

			<div class="row">

				<div class="small-12 columns">

					<div class="post-content no-vc">

						<?php echo apply_filters('the_content', get_the_content()); ?>

					</div>

				</div>

			</div>

		</div>

	<?php } else { ?>

		<div <?php post_class( 'page-padding' ); ?>>

			<div class="row">

				<div class="small-12 columns">

					<header class="post-title page-title">

						<?php the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' ); ?>

					</header>

					<div class="post-content no-vc">

						<?php echo apply_filters('the_content', get_the_content()); ?>

					</div>

				</div>

			</div>

		</div>

	<?php } ?>

		<?php if ( comments_open() || get_comments_number() ) : ?>

	<!-- Start #comments -->

			<?php comments_template( '', true ); ?>

	<!-- End #comments -->

	<?php endif; ?>

		<?php

	endwhile;

endif;

?>

<div id="product-list" class="row teethWhieteingSystemWrapper"></div>

<script>

	landing_str = '';

	var product_list;

	var landing_products;

	jQuery(document).on('change','#filter_products',function(){

		show_hide_div_by_tag(jQuery(this).val());

	});

	jQuery(document).ready(function(){

		counter = 0;

jQuery('.lander-shortcode').each(function(){

	data_Str = '';

current_html = jQuery(this).parents('.wpb_column').html();

col_class = jQuery(this).parents('.wpb_column').attr('class')+' landing-product';

data_Str +='data-price="'+jQuery(this).data('price')+'"';

data_Str +='data-recommended="'+jQuery(this).data('recommended')+'"';

data_Str +='data-date="'+jQuery(this).data('date')+'"';

data_Str +='data-default="'+counter+'"';

data_Str +='data-tagging="'+jQuery(this).data('tagging')+'"';

// col_class = col_class.replace("medium-9", "medium-6");

// col_class = col_class.replace("medium-7", "medium-6");

// col_class = col_class.replace("medium-12", "medium-6");

// jQuery(this).parent('.landing-product').attr('price',jQuery(this).attr('price'));

// 		jQuery(this).parent('.landing-product').attr('date',jQuery(this).attr('date'));

// 		jQuery(this).parent('.landing-product').attr('recommended',jQuery(this).attr('recommended'));

landing_str += '<div class="'+col_class+'" '+data_Str+'>'+current_html+'</div>';

counter++;



});

jQuery('#product-list').html(landing_str);

setTimeout(function(){ 

	// jQuery(document).find('.lander-shortcode').each(function(){

	// 	jQuery(this).parent('.landing-product').attr('price',jQuery(this).attr('price'));

	// 	jQuery(this).parent('.landing-product').attr('date',jQuery(this).attr('date'));

	// 	jQuery(this).parent('.landing-product').attr('recommended',jQuery(this).attr('recommended'));

	// });

	landing_products = jQuery(document).find('.landing-product');

product_list = $('#product-list');

str = '<option value="all">All products</option>';

jQuery(document).find('.landing-product').each(function(){

		attr_val = jQuery(this).data('tagging');

		if(str.includes(attr_val) || attr_val =='Select') {

			// continue

		}

		else{

			str +='<option value="'+attr_val+'">'+attr_val+'</option>';

		}

		

	});

	jQuery('#filter_products').html(str);

 }, 500);

 



	});





$('#price-sort').change( function() {

	

    if($(this).val() == 'price-low-to-high'){

       sortAsc('price');

    }

	else if($(this).val() == 'price-high-to-low'){

		sortDesc('price');

    }

	else if($(this).val() == 'newest'){

		sortDesc('date');

    }

	else if($(this).val() == 'default'){

		sortAsc('default');

    }

    else {

        sortAsc('recommended');

    }

	addremClass();

	

	

});

function show_hide_div_by_tag(tag_val) {

	if(tag_val =='all') {

		jQuery('.landing-product').show();

		

	}

	else{

		jQuery(document).find('.landing-product').each(function(){

		attr_val = jQuery(this).data('tagging');

		if(tag_val!=attr_val){

			jQuery(this).hide();

		}

		else{

			jQuery(this).show();

		}

	});

	}

	addremClass();



}

function addremClass() {

	if(jQuery('#price-sort').val()!='default' || (jQuery('#filter_products').val()!='all')) {

		jQuery('#wrapper,#product-list').addClass('grid-changed');

	}

	else{

		jQuery('#wrapper,#product-list').removeClass('grid-changed');

	}

}

function sortAsc(attr){

    product_list.empty();

    landing_products.sort(function(a, b){

      return $(a).data(attr)-$(b).data(attr)

    });

    product_list.append(landing_products);

}

function sortDesc(attr){

    product_list.empty(attr);

    landing_products.sort(function(a, b){

      return $(b).data(attr)-$(a).data(attr)

    });

    product_list.append(landing_products); 

}

jQuery(document).ready(function(){
    jQuery('#resetButton').click(function(){
        jQuery('#filter_products').val('all');
		jQuery('#price-sort').val('default');
        jQuery('#filter_products').trigger('change');
		jQuery('#price-sort').trigger('change');
	
    })
});


</script>

<style>

	.grid-changed .status-publish.hentry{

		display: none;

	}

</style>



<?php

get_footer();

