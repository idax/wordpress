<?php
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_scripts', PHP_INT_MAX);
function enqueue_child_theme_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}
function enqueue_child_theme_scripts() {
  wp_enqueue_script( 'signup-lp', get_template_directory_uri().'/js/signup-lp.js', array ( 'jquery' ), 1.12, true);
}

add_filter('woocommerce_breadcrumb_defaults','wcc_change_breadcrumb_home_text');
function wcc_change_breadcrumb_home_text($defaults) {
  $defaults['home'] = 'Home';
  return $defaults; 
}

$EXTRA_IMAGES_AMOUNT = 10;

for($i = 0; $i < $EXTRA_IMAGES_AMOUNT; $i++) {
  addImageField('multi_image_'.$i, 'Image'.$i, 'shop-isle', 'f_sketches');
}

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

/*Steven and Ida was here :)*/
?>



