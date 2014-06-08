<?php

/**
 *  Extends Theme Customizer Settings Init
 * =====================================================
 * @package    Extend Theme Customizer
 * @author     takashi ishihara
 * @license    GPLv2 or later
 * @link       https://github.com/1shiharaT/extend-theme-customizer
 * =====================================================
 */

class ETC_Theme_Customizer
{

	/**
	 * Plugin Slug
	 * @var string
	 */
	private $plugin_slug = 'extend-theme-customizer';

	/**
	 * Theme Customizer Setting ID
	 * @var array
	 */
	private $setting_id = array();

	/**
	 * Instance
	 * @var [type]
	 */
	private static $instance;

	/**
	 * construct
	 * @param string : $json_path
	 */
	public function __construct()
	{

		// require class file
		foreach ( glob( ETC_BASE_DIR . '/**/**/class-*.php' ) as $key => $filename) {
			require_once( $filename );
		}

		$this->json_path = $json_path;
		$this->setting_id = $this->intialize_customize_setting_id();
		add_action( 'init', array( $this, 'intialize_customize_setting_id' ) );

	}

	/**
	 * Get Instance
	 *
	 * @return object
	 */

	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {

			self::$instance = new self;

		}

		return self::$instance;
	}

	/**
	 * Get Plugin Slug
	 *
	 * @return string
	 */
	public function get_plugin_slug(){

		return $this->plugin_slug;

	}

	/**
	 * Get Customize Setting ID
	 * @return array $setting_id :
	 */

	public function intialize_customize_setting_id(){

		$setting_id     = array();
		$json_data      = new WP_Theme_Customizer_Import_Json();
		$this->settings = $json_data->register_json();

		foreach ( $this->settings->sections as $section_key => $section ) {

			foreach ( $section->setting as $setting_key => $setting ) {
				$setting_id[]  = $setting_key;
			}

		}

		return $setting_id;

	}

	/**
	 * customize preview js enqueue
	 * @return void
	 */
	public function customize_preview() {

		// $preview_js_uri = get_template_directory_uri() . '/inc/plugins/theme-customizer/assets/js/customizer-preview.js';
		/**
		 * action filter "gc_theme_customizer_preview_js_uri"
		 */
		// wp_enqueue_script( 'gc_customize_preview', apply_filters( 'gc_theme_customizer_preview_js_uri', $preview_js_uri ), array( 'customize-preview' ), '3.9', false );

	}

}

