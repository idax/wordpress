<?php
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

add_filter('woocommerce_breadcrumb_defaults','wcc_change_breadcrumb_home_text');
function wcc_change_breadcrumb_home_text($defaults) {
  $defaults['home'] = 'Home';
  return $defaults;
}
//Our custom post type function
function create_post_type(){
  register_post_type('designer',
    array(
      'labels' => array(
        'name' => __ ('Designer'),
        'singular_name' => __ ('Designer')
      ),
      'public' => true,
      'has_archive' => true,
    )
    );
}
add_action('init', 'create_post_type');

?>