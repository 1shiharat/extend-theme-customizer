<?php
/**
 * =====================================================
 * @package    Grow Creater
 * @subpackage Theme Customizer Settings
 * @author     Grow Group
 * @license    http://creativecommons.org/licenses/by/2.1/jp/
 * @link       http://grow-group.jp
 * @copyright  2014 Drema Style
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

    // if ( ! $json_path ) {
    //   $json_path = ETC_BASE_DIR . '/json/theme-customizer-setting.json';
    // }

    // require
    foreach ( glob( ETC_BASE_DIR . '/**/**/class-*.php' ) as $key => $filename) {
      require_once( $filename );
    }

		$this->json_path = $json_path;
		$this->setting_id = $this->intialize_customize_setting_id();
		add_action( 'init', array( $this, 'intialize_customize_setting_id' ) );

	}

  /**
   * Get Instance
   * @return [type] [description]
   */
  public static function get_instance() {
    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  public function get_plugin_slug(){
    return $this->plugin_slug;
  }

	/**
	 *
	 * @return [type] [description]
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

