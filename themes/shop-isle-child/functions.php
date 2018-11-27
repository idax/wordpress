<?php
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_scripts', PHP_INT_MAX);
function enqueue_child_theme_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
function enqueue_child_theme_scripts() {
  wp_enqueue_script( 'signup-lp', get_template_directory_uri().'/js/signup-lp.js', array ( 'jquery' ), 1.12, true);
}

function woocommerce_breadcrumb() {}

$EXTRA_IMAGES_AMOUNT = 10;

//For loop som kalder addImageField 10 gange. Vi giver hvert billede samme navn, med forskellig nummer til sidst, så vi let kan få fat på dem alle igen. (Altså 'multi_image_' + tal).
for($i = 0; $i < $EXTRA_IMAGES_AMOUNT; $i++) {
  addImageField('multi_image_'.$i, 'Image'.$i, 'shop-isle', 'f_sketches');
}


//Denne function tilføjer et "Image" felt på en post type. 
// - $fieldID : Det plugin som gør det muligt at tilføje flere billeder på en post, kræver at du giver de nye billedefelter et id, så vi kan få fat på billede vha. deres funktion 'get_post_thumbnail_id($id)'
// - $fieldName : Navnet på billedefeltet'
// - $themeTextDomain : Navn på dit theme, eller parent theme
// - $post_type : den post_type som skal have det nye billedefelt.
function addImageField($fieldID, $fieldName, $themeTextDomain, $post_type) {
  if (class_exists('MultiPostThumbnails')) {
  new MultiPostThumbnails(
    array(
      'label' => __( $fieldName, $themeTextDomain),
      'id' => $fieldID,
      'post_type' => $post_type
    )
  );
 }
}

function shop_isle_footer_copyright_and_socials() {
	?>
	<!-- Footer start -->
	<footer class="footer bg-dark">
		<!-- Divider -->
		<hr class="divider-d">
		<!-- Divider -->
		<div class="container">

			<div class="row">

				<?php
				/* Copyright */
				$shop_isle_copyright = apply_filters( 'shop_isle_footer_copyright_filter', get_theme_mod( 'shop_isle_copyright' ) );
				echo '<div class="col-sm-6">';
				if ( ! empty( $shop_isle_copyright ) ) :
					echo '<p class="copyright font-alt">' . $shop_isle_copyright . '</p>';
					endif;

					$shop_isle_site_info_hide = apply_filters( 'shop_isle_footer_socials_filter', get_theme_mod( 'shop_isle_site_info_hide' ) );
				if ( isset( $shop_isle_site_info_hide ) && $shop_isle_site_info_hide != 1 ) {
					echo apply_filters( 'shop_isle_site_info', '' );
				}
				echo '</div>';

				/* Socials icons */
				echo '<div class="col-sm-6">';
				shop_isle_footer_display_socials();
				echo '</div>';
				?>
			</div><!-- .row -->

		</div>
	</footer>
	<!-- Footer end -->
	<?php
}



function mls_settings($wp_customize){

	$wp_customize->add_section('michael-kvist-settings', array(
			'title'    => __('Michael Kvist Settings', 'txt_blocks'),
			'description' => 'General Settings',
			'priority' => 30,
	));

	//  =============================
	//  = Designer                  =
	//  =============================
	$wp_customize->add_setting('designer_text_block', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',

	));

	$wp_customize->add_control('designer_text', array(
			'label'      => __('Designer Text', 'txt_blocks'),
			'section'    => 'michael-kvist-settings',
			'settings'   => 'designer_text_block',
			'type' => 'textarea',
	));

			//  =============================
	//  = Distributor                =
	//  =============================
	$wp_customize->add_setting('distributor_text_block', array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'type'           => 'theme_mod',

	));

	$wp_customize->add_control('distributor_text', array(
			'label'      => __('Distributor Text', 'txt_blocks'),
			'section'    => 'michael-kvist-settings',
			'settings'   => 'distributor_text_block',
			'type' => 'textarea',
	));


	//  =============================
	//  = Manufacturer                  =
	//  =============================
	$wp_customize->add_setting('manufacturer_text_block', array(
		'default'        => '',
		'capability'     => 'edit_theme_options',
		'type'           => 'theme_mod',

));

$wp_customize->add_control('manufacturer_text', array(
		'label'      => __('Manufacturer Text', 'txt_blocks'),
		'section'    => 'michael-kvist-settings',
		'settings'   => 'manufacturer_text_block',
		'type' => 'textarea',
));

	

}


//add
add_action( 'customize_register', 'mls_settings' );
?>




