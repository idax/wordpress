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



<div class="container-fluid bg-1">
	<div class="row">
		<div class="col-sm-4">

			<?php 
			
			function get_string_between($string, $start, $end){
				$string = ' ' . $string;
				$ini = strpos($string, $start);
				if ($ini == 0) return '';
				$ini += strlen($start);
				$len = strpos($string, $end, $ini) - $ini;
				return substr($string, $ini, $len);
			}

			$designers = query_posts('post_type=f_designer');
			$distributors = query_posts('post_type=f_distributor');
			$manufacturers = query_posts('post_type=f_manufacturer');

			$prod_designers = 	explode(',',get_string_between($product->description, '¤designers¤','¤/designers¤'));
			$prod_distributors = 	explode(',',get_string_between($product->description, '¤distributors¤','¤/distributors¤'));
			$prod_manufacturers =	explode(',',get_string_between($product->description, '¤manufacturers¤','¤/manufacturers¤'));

			// DESIGNERS
			if(!empty($designers) && !empty($prod_designers)) {
				foreach ($designers as $designer) {
					foreach($prod_designers as $prod_designer) {
						if (strcasecmp($prod_designer, $designer->post_title) === 0) {
						if (has_post_thumbnail( $designer->ID ) ) { $image = wp_get_attachment_image_src( get_post_thumbnail_id( $designer->ID ), 'single-post-thumbnail' ); } else { $image = ['no image :c']; }
			?>
					
			<p> <?php echo $designer->post_content ?> </p>
			<img id="designer" src= <?php echo $image[0] ?> >

			<?php
						}
					}
				}
			} else {
				echo 'no posts! :(';
			}
			?>
		</div>
	</div>
</div>


<div class="container-fluid bg-2">
	<div class="row">
		<div class="col-sm-4">
			<?php
			//DISTRIBUTORS
			if(!empty($distributors) && !empty($prod_distributors)) {
				foreach ($distributors as $distributor) {
					foreach($prod_distributors as $prod_distributor) {
						if (strcasecmp($prod_distributor, $distributor->post_title) === 0) {
						if (has_post_thumbnail( $distributor->ID ) ) { $image = wp_get_attachment_image_src( get_post_thumbnail_id( $distributor->ID ), 'single-post-thumbnail' ); } else { $image = ['no image :c']; }
			?>
					
			<p> <?php echo $distributor->post_content ?> </p>
			<img id="designer" src= <?php echo $image[0] ?> >

			<?php
						}
					}
				}
			} else {
				echo 'no posts :(';
			}
			?>

			<?php
			//MANUFACTURERS
			if(!empty($manufacturers) && !empty($prod_manufacturers)) {
				foreach ($manufacturers as $manufacturer) {
					foreach($prod_manufacturers as $prod_manufacturer) {
						if (strcasecmp($prod_manufacturer, $manufacturer->post_title) === 0) {
						if (has_post_thumbnail( $manufacturer->ID ) ) { $image = wp_get_attachment_image_src( get_post_thumbnail_id( $manufacturer->ID ), 'single-post-thumbnail' ); } else { $image = ['no image :c']; }
			?>
					
			<p> <?php echo $manufacturer->post_content ?> </p>
			<img id="designer" src= <?php echo $image[0] ?> >

			<?php
						}
					}
				}
			} else {
				echo 'no posts :(';
			}
			?>




		</div>
	</div>
</div>








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


