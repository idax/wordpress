<?php
/*
*Plugin Name: My Plugin
*/

$penus = true;

defined('ABSPATH') || die('No script kiddies please!');

require_once(plugin_dir_path(__FILE__).'/admin_pages/admintestpage.php');
require_once(plugin_dir_path(__FILE__).'/widgets/mytestwidget.php');

// initialize plugin
if (class_exists('MyPluginJep')) {
    $myplugin = new MyPluginJep();
    $myplugin->register_shortcode();
}



class MyPluginJep {


    function register_shortcode() {
        add_shortcode( 'some_random_shortcode_jep', array( $this, 'some_random_shortcode_jep') );
    }
    
    function some_random_shortcode_jep() {
        echo 'Output of my random shortcode LOL';
    }

}