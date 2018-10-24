<?php
/**
 * The template for displaying collaborators(Copy of Full-Width).
 *
 * Template Name: Collaborators
 *
 * @package WordPress
 * @subpackage Shop Isle
 */

get_header(); ?>

<!-- Wrapper start -->
	<div class="main">
		<!-- Header section start -->
		<?php
		$shop_isle_header_image = get_the_post_thumbnail_url();
		if ( empty( $shop_isle_header_image ) ) {
			$shop_isle_header_image = get_header_image();
		}
		if ( ! empty( $shop_isle_header_image ) ) {
			echo '<section class="page-header-module module bg-dark" data-background="' . esc_url( $shop_isle_header_image ) . '">';
		} else {
			echo '<section class="page-header-module module bg-dark">';
		}
		?>
			<div class="container">

				<div class="row">

					<div class="col-sm-10 col-sm-offset-1">
						<h1 class="module-title font-alt"><?php the_title(); ?></h1>
						<?php
						/* Header description */

						$shop_isle_shop_id = get_the_ID();

						if ( ! empty( $shop_isle_shop_id ) ) :

							$shop_isle_page_description = get_post_meta( $shop_isle_shop_id, 'shop_isle_page_description' );

							if ( ! empty( $shop_isle_page_description[0] ) ) :
								echo '<div class="module-subtitle font-serif mb-0">' . wp_kses_post( $shop_isle_page_description[0] ) . '</div>';
							endif;

						endif;
						?>
					</div>

				</div><!-- .row -->

			</div>
		</section>
		<!-- Header section end -->

		<!-- Pricing start -->
		<section class="module">
			<div class="container">
				<div class="row">

					<!-- Content column start -->
					<div class="col-sm-12">
					<?php
					/**
					 * Top of the content hook.
					 *
					 * @hooked woocommerce_breadcrumb - 10
					 */
					//do_action( 'shop_isle_content_top' );




					$post_type = 'f_'.basename(get_permalink());
					$coll_text_block = get_theme_mod( basename(get_permalink()).'_text_block');
					$is_designer = ($post_type == 'f_designer');
					$posts = get_posts([
						'post_type' => $post_type,
						'post_status' => 'publish',
						'numberposts' => -1,
						'order'    => 'ASC',
						'orderby'=>'menu_order'
					  ]);
					  echo '<p id="into-text">'.$coll_text_block.'</p>';
					  echo '<div class="col-sm-12 collaborators-grid">';
					  foreach($posts as $a_post) {
						  $image = get_post(get_post_thumbnail_id($a_post));
						  $image_url = $image->guid;
						  $image_title = $image->post_title;
						?>
					
						<div <?php if($is_designer) echo 'style="flex-direction: column;"' ?>>
							<img class="images-pointer" src= <?php echo $image_url; ?> onclick="window.location.href='<?php echo get_post_permalink($a_post->ID) ?>'">

							 <?php if($post_type == 'f_designer') { echo '<p>'.$image_title.'</p>'; } ?>
					  	</div>
					
						  <?php
					  };
					  echo '</div>'





					
					?>
					</div>
				</div> <!-- .row -->	

			</div>
		</section>
		<!-- Pricing end -->


<?php get_footer(); ?>
