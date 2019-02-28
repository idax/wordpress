<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/oocommerce/single-product.php.
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

get_header( 'shop' ); 

?>


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


/**
  * Tager imod en $start og $end string, som indikerer hvorfra og til i $string at du vil have en substring.
  *
  * @param $string En string som du vil have et stykke af.
  * @param $start En string som fortæller hvorfra i den ovenstående $string du vil have et stykke fra.
  * @param $end En string som fortæller hvorfra i den ovenstående $string du vil have et stykke til.
  *
  * @return string
  */
function get_string_between($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}


function banner_printer($post_type_name, $delimiter1, $delimiter2, $imageCssId, $textCssId, $product, $imageFirst = true, $displayReadMore = true) {

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
								if (has_post_thumbnail( $banner_post->ID ) ) { $image = wp_get_attachment_image_src( get_post_thumbnail_id( $banner_post->ID ), 'single-post-thumbnail' )[0]; } else { $image = 'no image :c'; }
				?>
				<div id="posts-wrapper">
				<div class="col-sm-4 <?php if(!$imageFirst) echo 'col-sm-push-8'; ?>">
						<img id="<?php echo $imageCssId ?>" src= <?php echo $image ?> >	
					</div>
					<div class="col-sm-8 <?php if(!$imageFirst) echo 'col-sm-pull-4'; ?>" id="<?php echo $textCssId ?>">
						<p> <?php echo get_string_between($banner_post->post_content, "#TEASER START#", "#TEASER END#") ?> </p>
						<?php if($displayReadMore == true) { ?> <button class="btn btn-lg read-more" type="button" onclick="window.location.href='<?php echo get_post_permalink($banner_post->ID) ?>'">READ MORE</button>  <?php } ?>
					</div>
				</div>
				<?php
							break;
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

function specifications_banner_printer($post_type_name, $delimiter1, $delimiter2, $product)
{
    $spec_posts = query_posts('post_type=' . $post_type_name);
    $product_spec_names = explode(',', get_string_between($product->description, $delimiter1, $delimiter2));
?>
   <div class="container-fluid banner">
       <div class="row center-with-flex" id="specification" style>
<?php
    if (!empty($spec_posts) && !empty($product_spec_names)) {
        foreach ($spec_posts as $spec_post) {
            foreach ($product_spec_names as $product_spec_name) {
                if (strcasecmp($product_spec_name, $spec_post->post_title) === 0) {

					
					$categories = [];
					foreach(get_the_terms( $product->ID, 'product_cat' ) as $category) {
						array_push($categories, $category->name); 
					}
					//------------------

					$designers = explode(',', get_string_between($product->description, '¤designers¤', '¤/designers¤'));
					if(empty($designers)) $designers = ["unknown :("];

?>					
					<table style="width: 40%; border-bottom: 0px;">
						<tr>
							<td>Designer:</td>
							<td><?php echo implode(', ', $designers); ?></td>
						</tr>
						<tr>
							<td>Type:</td>
							<td><?php echo implode(", ", $categories); ?></td>
						</tr>
						<tr>
							<td>Model:</td>
							<td><?php echo $product->name; ?></td>
						</tr>
						<tr style="border-bottom: 1px solid #dddddd;">
							<td style="border-bottom: 0px;" valign="top">Measurements:</td>
							<td style="border-bottom: 0px;"> 
								<table style="border-bottom: 0px !important; margin: 0px !important;">
<?php					
					$spec_list = explode(",", $spec_post->post_content);
					$counter = 0;
                    foreach ($spec_list as $spec_item) {
						$counter++;
                        $spec_name = substr($spec_item, 0, strpos($spec_item, ":") + 1);
						$spec_data = substr($spec_item, strpos($spec_item, ":") + 1);
						$lastitem = $counter == count($spec_list);
?>
                        <?php if(strpos($spec_item, ':') !== false) { ?>
									<tr>
										<td <?php if($lastitem == 1) echo 'style="border-bottom: 0px !important;"'; ?>><?php echo $spec_name; ?></td>
										<td <?php if($lastitem == 1) echo 'style="border-bottom: 0px !important;"'; ?>><?php echo $spec_data; ?></td>
									</tr>
									<?php } else { ?>
									<tr>
										<td <?php if($lastitem == 1) echo 'style="border-bottom: 0px !important;"'; ?>><?php echo $spec_item; ?></td>
									</tr>
<?php
						}	
					}	?>
                    			</table> 
							</td>
						</tr>
					</table>
        <?php	}
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

specifications_banner_printer("f_specifications", "¤specifications¤", "¤/specifications¤", $product);
banner_printer("f_designer", 		"¤designers¤", 		"¤/designers¤", 	"designer", 	"text-design", $product);
banner_printer("f_manufacturer", 	"¤manufacturers¤", 	"¤/manufacturers¤", "manufacturer", "text-manufac",	$product, false);
banner_printer("f_distributor", 	"¤distributors¤", 	"¤/distributors¤", 	"distributor", 	"text-distri", $product);


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


