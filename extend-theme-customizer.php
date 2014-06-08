<?php
/*
Plugin Name: Extend Json Theme Customizer
Plugin URI: http://web-layman.com/
Description: Extend Json Theme Customizer
Version: 0.1
Author: Takashi Ishihara
Author URI: http://web-layman.com/
*/

// defined Base Dir
define( 'ETC_BASE_DIR', __DIR__ );

// defined Base URI
define( 'ETC_BASE_URL', plugins_url( __FILE__ ) );

$file_names = array_merge(
  glob(
    ETC_BASE_DIR . '/inc/class-*.php'
  )
);

foreach ( $file_names as $key => $filename) {
  require_once( $filename );
}

add_action( 'plugins_loaded', array( 'ETC_Theme_Customizer', 'get_instance' ) );

/**
 * Admin Include
 */
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

  require_once( plugin_dir_path( __FILE__ ) . 'admin/extend-theme-customizer-admin.php' );
  add_action( 'plugins_loaded', array( 'ETC_Admin', 'get_instance' ) );

}
