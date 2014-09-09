<?php
if ( ! defined( 'WPINC' ) ) exit;

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
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );

		add_action( 'admin_menu', array( $this, 'add_plugin_admin_submenu' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		/**
		 * Register Post Type
		 */
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
		add_action( 'admin_init', array( $this, 'admin_update_option' ) );
		add_action( 'admin_init', array( $this, 'admin_add_option' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
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
			// wp_enqueue_style( $this->plugin_slug . '-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), ETC_Admin::VERSION );
			// wp_enqueue_style( $this->plugin_slug . '-admin-styles-json-editor', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', array(), ETC_Admin::VERSION );
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

		// if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			// wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), ETC_Admin::VERSION );
			// wp_enqueue_script( $this->plugin_slug . '-admin-script-json-editor', plugins_url( '/assets/FlexiJsonEditor/jquery.jsoneditor.js', __FILE__ ), array( 'jquery' ), ETC_Admin::VERSION );
			wp_enqueue_script( $this->plugin_slug . '-admin-script-json2', plugins_url( '/assets/json-editor/dist/jsoneditor.min.js', __FILE__ ), array( 'jquery' ), ETC_Admin::VERSION );
		// }

	}

	public function add_plugin_admin_submenu() {

		$this->plugin_screen_hook_suffix = add_submenu_page(
			'edit.php?post_type=etc-settings',
			__( 'Extends Theme Customizer', $this->plugin_slug ),
			__( 'ETC Settings', $this->plugin_slug ),
			'manage_options',
			'admin.php?page=extend-theme-customizer',
			array( $this, 'display_plugin_admin_page' )
		);

	}

	public function display_plugin_admin_addnew_page(){
		include 'views/add-new.php';
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
	public function admin_update_option()
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
	public function admin_add_option()
	{

		$success = false;
		$json_path = get_option( 'etc_json_settings', false );
		if ( $json_path && $json = file_get_contents( $json_path ) ) {
			set_transient( $this->plugin_slug, $json, (60 * 60 * 24) );
		}
		$tc_width = get_option( 'etc_width_settings', false );
		$tc_column = get_option( 'etc_width_settings', false );
		$default = ETC_BASE_DIR . '/json/theme-customizer-setting.json';

		// Set Default Path
		if ( ! $json_path ) {
			$success = add_option( 'etc_json_settings', $default );
		}
		return $success;

	}

	/**
	* Registers a new post type
	* @uses $wp_post_types Inserts new post type object into the list
	*
	* @param string  Post type key, must not exceed 20 characters
	* @param array|string  See optional args description above.
	* @return object|WP_Error the registered post type object, or an error object
	*/
	public function register_post_type(){

		$labels = array(
			'name'                => __( 'ETC Settings', $this->plugin_slug ),
			'singular_name'       => __( 'ETC Setting', $this->plugin_slug ),
			'add_new'             => _x( 'Add ETC Setting', $this->plugin_slug, $this->plugin_slug ),
			'add_new_item'        => __( 'Add ETC Setting', $this->plugin_slug ),
			'edit_item'           => __( 'Edit ETC Setting', $this->plugin_slug ),
			'new_item'            => __( 'New ETC Setting', $this->plugin_slug ),
			'view_item'           => __( 'View ETC Setting', $this->plugin_slug ),
			'search_items'        => __( 'Search ETC Settings', $this->plugin_slug ),
			'not_found'           => __( 'No ETC Setting found', $this->plugin_slug ),
			'not_found_in_trash'  => __( 'No ETC Setting found in Trash', $this->plugin_slug ),
			'parent_item_colon'   => __( 'Parent ETC Setting:', $this->plugin_slug ),
			'menu_name'           => __( 'Setting Lists', $this->plugin_slug ),
		);

		$args = array(
			'labels'               => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => false,
			'menu_position'       => 100,
			'menu_icon'           => null,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => false,
			'has_archive'         => false,
			'query_var'           => false,
			'can_export'          => true,
			'rewrite'             => false,
			// 'capability_type'     => '',
			'supports'            => array(
				'title',
				)
		);

		register_post_type( 'etc-settings', $args );
	}

	public function add_meta_box( $post_type ){
		$post_types = array( 'etc-settings' );     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'etc_settings_meta_box'
				,__( 'Option Create', 'extend-theme-customizer' )
				,array( $this, 'post_meta_render' )
				,$post_type
				,'advanced'
				,'high'
			);
    }
	}

	public function post_meta_render(){
		include 'views/metaboxes.php';
	}
}
