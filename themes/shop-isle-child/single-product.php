<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php


	do_action( 'woocommerce_before_single_product' );

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

	<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
	</div>


</div>



		<?php endwhile; // end of the loop. ?>

<?php 
function get_string_between($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

function print_post_image($imageCssId, $image) {
	?>
	<div class="col-sm-4">
		<img id="<?php echo $imageCssId ?>" src= <?php echo $image ?> >	
	</div>
	<?php
}
function print_post_text($textCssId, $banner_post, $displayReadMore) {
	?>
	<div class="col-sm-8" id="<?php echo $textCssId ?>">	
		<p > <?php echo get_string_between($banner_post->post_content, "#TEASER START#", "#TEASER END#") ?> </p>
		<?php if($displayReadMore == true) { ?> <button class="btn read-more" type="button" onclick="window.location.href='<?php echo get_post_permalink($banner_post->ID) ?>'">READ MORE</button>  <?php } ?>
	</div>
	<?php
}
function getMultiplePictures($the_post) {
	if (class_exists('MultiPostThumbnails') && get_post_type( $the_post->ID ) == 'f_sketches') {
		$imageExists = true;
		$counter = 0;
		$images_array = array();
		while($imageExists) {
			$multi_image = MultiPostThumbnails::get_post_thumbnail_id(get_post_type( $the_post->ID ), 'multi_image_'.$counter, $the_post->ID);
			if($multi_image != null) {
				array_push($images_array, wp_get_attachment_image_src($multi_image, 'single-post-thumbnail')[0]);
				$counter++;
			} else {
				$imageExists = false;
			}
		}
		return $images_array;
	} else {
		return array();
	}
	
}

function banner_printer($post_type_name, $delimiter1, $delimiter2, $imageCssId, $textCssId, $imageFirst, $displayReadMore, $product) {

	 $banner_posts = query_posts('post_type='.$post_type_name);
	 $banner_category_names = explode(',', get_string_between($product->description, $delimiter1, $delimiter2));
	 ?>
	 <div class="container-fluid banner">
		<div class="row center-with-flex" >
				<?php

				if(!empty($banner_posts) && !empty($banner_category_names)) {
					foreach ($banner_posts as $banner_post) {
						foreach($banner_category_names as $banner_category_name) {
							if (strcasecmp($banner_category_name, $banner_post->post_title) === 0) {
								if (has_post_thumbnail( $banner_post->ID ) ) { $image = wp_get_attachment_image_src( get_post_thumbnail_id( $banner_post->ID ), 'single-post-thumbnail' )[0]; } else { $image = ['no image :c']; }
				?>
				<div id="posts-wrapper">
				<?php
					if($imageFirst) {
					print_post_image($imageCssId, $image);
					print_post_text($textCssId, $banner_post, $displayReadMore);
					} else {
					print_post_text($textCssId, $banner_post, $displayReadMore);
					print_post_image($imageCssId, $image);
					}
				?>
				</div>
				<?php
							}
						}
					}
				} else {
					echo 'no results :(';
				}
				?>
				<div></div>
			
		</div>
	</div>
	<?php
}

function sketch_banner_printer($post_type_name, $delimiter1, $delimiter2, $displayReadMore, $product) {

	$banner_posts = query_posts('post_type='.$post_type_name);
	$banner_category_names = explode(',', get_string_between($product->description, $delimiter1, $delimiter2));
	?>
	<div class="container-fluid banner">
	   <div class="row center-with-flex">
			   <?php

			   if(!empty($banner_posts) && !empty($banner_category_names)) {
				   foreach ($banner_posts as $banner_post) {
					   foreach($banner_category_names as $banner_category_name) {
						   if (strcasecmp($banner_category_name, $banner_post->post_title) === 0) {
							   $extra_images = getMultiplePictures($banner_post);
							   if (has_post_thumbnail( $banner_post->ID ) ) { $image = wp_get_attachment_image_src( get_post_thumbnail_id( $banner_post->ID ), 'single-post-thumbnail' )[0]; } else { $image = ['no image :c']; }
			   ?>

			   <?php 
				   	if(!empty($extra_images)) {
						$image_counter = 0;
						foreach($extra_images as $extra_image) {
							if($image_counter == 0) echo '<div id="sketch-posts-wrapper">';
							if($image != null) { echo '<div class="col-sm-4" id="sketches">	
															<img src='.$image.'>
														</div>';
														$image = null; 
														$image_counter++;
													}
							?>

							<div class="col-sm-4" id="sketches">	
								<img src=<?php echo $extra_image ?>>
							</div>
							
							<?php
							$image_counter++;
							if($image_counter == 3) {
								echo '</div>';
								$image_counter = 0;
							}
					   }
				} 
					
			   ?>
				   

			   
			   <?php
						   }
					   }
				   }
			   } else {
				   echo 'no results :(';
			   }
			   ?>
	   </div>
   </div>
   <?php
}


sketch_banner_printer("f_sketches", "¤sketches¤", "¤/sketches¤", false, $product);
banner_printer("f_sketches", 		"¤sketches¤", 			"¤/sketches¤", 		"sketches", 	"text-sketches", false, 	false,	$product);
banner_printer("f_designer", 		"¤designers¤", 		"¤/designers¤", 	"designer", 	"text-design", 		true, 	true,	$product);
banner_printer("f_manufacturer", 	"¤manufacturers¤", 	"¤/manufacturers¤", "manufacturer", "text-manufac", 	false, 	true, 	$product);
banner_printer("f_distributor", 	"¤distributors¤", 	"¤/distributors¤", 	"distributor", 	"text-distri", 		true, 	true, 	$product);


?>











	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */


