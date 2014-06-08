<?php

/**
 *  Theme Customizer Setting Import By Json
 * =====================================================
 * @package    Extend Theme Customizer
 * @author     takashi ishihara
 * @license    GPLv2 or later
 * @link       https://github.com/1shiharaT/extend-theme-customizer
 * =====================================================
 */

if ( ! defined( 'WPINC' ) ) exit; // Exit if accessed directly

/**
 * class WP_Theme_Customizer_Import_Json
 *
 * Example :
 */

class WP_Theme_Customizer_Import_Json
{

	/**
	 * Theme Customizer Instance
	 * @var object
	 */

	private $wp_customize;

	/**
	 * theme slug name
	 *
	 * @var string
	 */

	private $theme_name = '';

	/**
	 * editor capability
	 *
	 * @var string
	 */

	private $capability = '';

	/**
	 * Set Json File Path
	 *
	 * @var string
	 */

	private $json_path = '';



	/**
	 * set settings object
	 *
	 * @var objecct
	 */

	private $settings;

	/**
	 * construct
	 *
	 * @param string $json_path
	 *
	 * @return void
	 */

	public function __construct( $json_path = '' )
	{

		$json_path = get_option( 'etc_json_settings' );

		if ( ! $json_path ) {
			$json_path = ETC_BASE_DIR . '/json/theme-customizer-setting.json';
		}

		// json path
		$this->json_path = $json_path;

		// theme slug
		$this->theme_name = $this->get_theme_name();

		// register json
		$this->settings = $this->register_json( apply_filters( 'set_theme_customizer_json_file', $json_path ) );

		// editor capability
		$this->capability = $this->set_capability();

		/**
		 * Register action hook
		 *
		 * @see wp-includes/class-wp-theme-customizer-manager.php
		 */

		add_action( 'customize_preview_init', array( $this, 'customize_preview' ) );

		add_action( 'customize_register', array( $this, 'register_customizer' ), 99, 1 );

	}

	/**
	 * Register Json File
	 *
	 * @param  string $json_path
	 * @return object
	 */

	public function register_json()
	{

		$this->settings = json_decode( file_get_contents( $this->json_path ) );

		return $this->settings;

	}

	public static function get_theme_customizer_object(){
		$instance = new self;
		return $instance->settings;
	}
	/**
	 * Set Theme Customizer Editor Capability
	 *
	 * @return string
	 */

	private function set_capability()
	{

		return $this->settings->setting->capability;

	}


	/**
	 * Register Theme Customizer
	 *
	 * @return void
	 */

	public function register_customizer( $wp_customize )
	{


		$this->wp_customize = $wp_customize;

		$this->wp_customize->remove_section( 'background_image' );
		$this->wp_customize->remove_section( 'static_front_page' );
		$this->wp_customize->remove_section( 'colors' );

		do_action( 'gc_theme_customizer_before', $this->wp_customize );

		if ( !$this->settings->setting->theme_slug ) {
			$this->theme_slug = 'theme_mods_' . $this->theme_name;
		} else {
			$this->theme_slug = 'theme_mods_' . $this->settings->setting->theme_slug;
		}

		foreach ( $this->settings->sections as $section_name => $section ) :

			// register section
			$this->add_section( $section_name, $section->title, $section->priority );

			foreach ( $section->setting as $setting_name => $settings ) :

				// register setting
				$this->add_setting( $setting_name, $settings );

				// register control
				$this->add_control( $section_name, $setting_name, $settings );

			endforeach;

		endforeach;

		do_action( 'gc_theme_customizer_after', $this->wp_customize );

	}

	/**
	 * Enhanced Theme Slug
	 *
	 * @return string template name
	 */

	private function get_theme_name()
	{

		$theme_name = get_template();

		return apply_filters( 'customizer_theme_name', $theme_name );

	}


	/**
	 * Set Section Value
	 *
	 * @param string $title
	 * @param int    $priority
	 * @return array
	 */

	private function set_section( $title = '', $priority )
	{

		if ( ! $priority )
			$priority = 0;

		return array(
			'title' => $title,
			'priority' => $priority,
		);

	}

	/**
	 * Set Setting Value
	 *
	 * @param array $settings
	 *
	 * @return array setting argment
	 */

	private function set_setting( $settings )
	{

		$setting_arg = array();
		$setting_arg['capability'] = $this->capability;
		$setting_arg = $this->deploy_settings( $setting_arg, $settings, array( 'label', 'choices' ) );

		if ( 'select' === $setting_arg['type'] || 'radio' === $setting_arg['type'] || 'text' === $setting_arg['type'] ) {

			$setting_arg['type'] = 'option';

		} else if ( 'color' === $setting_arg['type'] ){
			$setting_arg['type'] = 'option';
			$setting_arg['sanitize_callback'] = 'sanitize_hex_color';
		}

		return $setting_arg;

	}

	/**
	 * Set Control Value
	 *
	 * @param string $section_name
	 * @param object $settings
	 *
	 * @return array formated array value
	 */

	public function set_control( $section_name, $setting_name, $settings )
	{

		$setting_arg = array();
		$setting_arg['section'] = $section_name;
		$setting_arg['settings'] = $this->theme_slug . '['. $setting_name . ']';

		$setting_arg = $this->deploy_settings( $setting_arg, $settings, array( 'transport', 'capability', 'default', 'type', 'target' ) );

		if ( 'select' == $settings->type
				 || 'radio' == $settings->type ) {

			$setting_arg['type'] = $settings->type;

		}

		return $setting_arg;

	}

	/**
	 * Control & Setting Value formater
	 *
	 * @param  object $setting_arg
	 * @param  object $settings
	 * @param  array  $exclude_keys
	 *
	 * @return array / formated  array value
	 */

	private function deploy_settings( $setting_arg, $settings, $exclude_keys = array() )
	{

		foreach ( $settings as $setting_key => $setting ) {

			if ( 'choices' == $setting_key ) {

				foreach ( $setting as $choise_key => $choise ) {

					$setting_arg['choices'][$choise_key] = $choise;

				};

			} elseif ( in_array( $setting_key, $exclude_keys ) ) {

				unset( $setting_arg[$setting_key] );

				continue;

			} else {

				$setting_arg[$setting_key] = $setting;

			};

		};

		return $setting_arg;

	}

	/**
	 * Add Section to WP Theme Customizer
	 *
	 * @param string  $section_name
	 * @param string  $title
	 * @param integer $priority
	 *
	 * @return void
	 */

	private function add_section( $section_name, $title, $priority = 0 )
	{

		$this->wp_customize->
			add_section(
				$section_name,
				$this->set_section(
					$title,
					$priority
				)
			);

	}

	/**
	 * Add Setting to WP Theme Customizer
	 *
	 * @param string $setting_name
	 * @param object $settings
	 *
	 * @return void
	 */

	private function add_setting( $setting_name, $settings )
	{

		$this->wp_customize->
			add_setting(
				$this->theme_slug . '['. $setting_name . ']',
				$this->set_setting( $settings )
			);

	}


	/**
	 * Add Control to WP Theme Customizer
	 *
	 * @param string $section_name
	 * @param string $setting_name
	 * @param object $settings
	 *
	 * @return void
	 */

	private function add_control( $section_name, $setting_name, $settings )
	{

		switch ( $settings->type ) {

			case 'color':

				$this->wp_customize->
					add_control(
						new WP_Customize_Color_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);
				break;

			case 'image':
				$this->wp_customize->
					add_control(
						new WP_Multi_Image_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);
				break;

			case 'date-picker':
				$this->wp_customize->
					add_control(
						new Date_Picker_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);
				break;

			case 'layout-picker':

				$this->wp_customize->
					add_control(
						new Layout_Picker_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'category-dropdown':

				$this->wp_customize->
					add_control(
						new Category_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'google-font':

				$this->wp_customize->
					add_control(
						new Google_Font_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'menu-dropdown':

				$this->wp_customize->
					add_control(
						new Menu_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'post-dropdown':

				$this->wp_customize->
					add_control(
						new Post_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'post-type-dropdown':

				$this->wp_customize->
					add_control(
						new Post_Type_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'tags-dropdown':

				$this->wp_customize->
					add_control(
						new Tags_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'taxonomy-dropdown':

				$this->wp_customize->
					add_control(
						new Taxonomy_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'user-dropdown':

				$this->wp_customize->
					add_control(
						new User_Dropdown_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;


			case 'text-editor':

				$this->wp_customize->
					add_control(
						new Text_Editor_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'textarea':

				$this->wp_customize->
					add_control(
						new Textarea_Custom_Control(
							$this->wp_customize,
							$setting_name,
							$this->set_control( $section_name, $setting_name, $settings )
						)
					);

				break;

			case 'text':
			case 'select':
			case 'radio':
			case 'option':

				$this->wp_customize->
					add_control(
						$setting_name,
						$this->set_control( $section_name, $setting_name, $settings )
					);

					break;
		}

		do_action( 'ejt_register_conrtol_type', $section_name, $setting_name, $settings );

	}

}
