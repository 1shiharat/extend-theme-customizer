<?php

/**
 *  Plugin Admin Panel
 * =====================================================
 * @package    Extend Theme Customizer
 * @author     takashi ishihara
 * @license    GPLv2 or later
 * @link       https://github.com/1shiharaT/extend-theme-customizer
 * =====================================================
 */

class ETC_Admin {

	const VERSION = '0.1';

	/**
	 * Instance of this class.
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize
	 */
	private function __construct() {

		$plugin = ETC_Theme_Customizer::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		add_action( 'admin_init', array( $this, 'etc_admin_update_option' ) );
		add_action( 'admin_init', array( $this, 'etc_admin_add_option' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @return    null    Return early if no settings page is registered.
	 */

	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug . '-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), ETC_Admin::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), ETC_Admin::VERSION );
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Extends Theme Customizer', $this->plugin_slug ),
			__( 'ETC Settings', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page()
	{

		$create_nonce =  wp_create_nonce( plugin_basename( __file__ ) );
		$json_path = get_option( 'etc_json_settings' );
		$width = get_option( 'etc_width_settings' );
		$setting_object = WP_Theme_Customizer_Import_Json::get_theme_customizer_object();

		// include /admin/views/admin.php
		include_once( 'views/admin.php' );

	}

	/**
	 * Add Settings Link
	 *
	 * @param array $links
	 * @return array
	 */
	public function add_action_links( $links )
	{

		return array_merge(
			 array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'ETC Settings', $this->plugin_slug ) . '</a>'
			 ),
			 $links
		);

	}

	/**
	 * Update Option
	 *
	 * @return boolean
	 */
	public function etc_admin_update_option()
	{

		$json_file_path = $_POST['etc_json_file'];
		$nonce = $_POST['_wp_nonce'];

		if ( wp_verify_nonce( $nonce , plugin_basename( __file__ ) ) !== 1 ) {
			return false;
		}

		$json_contents = $json_file_path;

		$success = update_option( 'etc_json_settings', $json_contents );
		return $success;

	}

	/**
	 * Add Option
	 *
	 * @return boolean
	 */
	public function etc_admin_add_option()
	{

		$success = false;
		$json_path = get_option( 'etc_json_settings', false );
		$tc_width = get_option( 'etc_width_settings', false );
		$tc_column = get_option( 'etc_width_settings', false );
		$default = ETC_BASE_DIR . '/json/theme-customizer-setting.json';

		if ( ! $json_path ) {
			$success = add_option( 'etc_json_settings', $default );
		}
		return $success;
	}
}
