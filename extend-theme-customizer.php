<?php
/*
Plugin Name: Extend Json Theme Customizer
Plugin URI: https://github.com/paulund/wordpress-theme-customizer-custom-controls
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

// Load Class File
require_once( dirname( __FILE__ ) . '/inc/class-etc-theme-customizer.php' );
require_once( dirname( __FILE__ ) . '/inc/class-wp-theme-customizer-import-json.php' );

// Plugin Load File
add_action( 'plugins_loaded', array( 'ETC_Theme_Customizer', 'get_instance' ) );

/**
 * Load Admin Class
 */

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

  require_once( plugin_dir_path( __FILE__ ) . 'admin/extend-theme-customizer-admin.php' );
  add_action( 'plugins_loaded', array( 'ETC_Admin', 'get_instance' ) );

}
