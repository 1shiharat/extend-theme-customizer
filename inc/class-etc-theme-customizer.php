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
		$support_fields = array(
			'date' => array(
				'date-picker'
			),
			'image' => array(
				'multi-image'
			),
			'layout' => array(
				'layout-picker'
      ),
			'select' => array(
				'category-dropdown',
				'google-font-dropdown',
				'menu-dropdown',
				'post-dropdown',
				'post-type-dropdown',
				'tags-dropdown',
				'taxonomy-dropdown',
				'user-dropdown',
			),
			'text' => array(
				'text-editor',
				'textarea'
			),
		);
		$support_fields = apply_filters( 'etc_support_files', $support_fields );

		foreach ( $support_fields as $dir => $field_slugs ) {
			foreach ( $field_slugs as $slug ) {
				require_once ( ETC_BASE_DIR . '/fields/' . $dir . '/' . 'class-' . $slug . '-custom-control.php' );
			}
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

}

