<?php
/*
Plugin Name: Extend Json Theme Customizer
Plugin URI: http://web-layman.com/
Description: Extend Json Theme Customizer
Version: 0.0.1
Author: Takashi Ishihara
Author URI: http://web-layman.com/
GitHub Plugin URI: 1shiharaT/extend-theme-customizer
GitHub Branch: master
*/

/**
 *  Theme Customizer Setting Import By Json
 * =====================================================
 * @package    Extend Theme Customizer
 * @author     takashi ishihara
 * @license    GPLv2 or later
 * @link       https://github.com/1shiharaT/extend-theme-customizer
 * =====================================================
 */

// defined Base Dir
define( 'ETC_BASE_DIR', dirname( __FILE__ ) );
// defined Base URI
// define( 'ETC_BASE_URL', plugin_dir_url() );

$file_names = glob( ETC_BASE_DIR . '/inc/class-*.php' );

foreach ( $file_names as $key => $filename) {
  require_once( $filename ); // require files
}

// Plugin Loaded File
add_action( 'plugins_loaded', array( 'ETC_Theme_Customizer', 'get_instance' ) );

/**
 * Admin
 */

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

  require_once( plugin_dir_path( __FILE__ ) . 'admin/extend-theme-customizer-admin.php' );
  add_action( 'plugins_loaded', array( 'ETC_Admin', 'get_instance' ) );

}
