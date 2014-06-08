<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
		return NULL;

/**
 * Class to create a custom layout control
 */
class Layout_Picker_Custom_Control extends WP_Customize_Control
{
	/**
	* Render the content on the theme customizer page
	*/
	public function render_content()
	{

		$image_directory =  ETC_BASE_URL . '/fields/layout/img' ;
		?>
		<label>
			<span class="customize-layout-control"><?php echo esc_html( $this->label ); ?></span>
			<ul>
				<li><img src="<?php echo $image_directory; ?>/1col.png" alt="Full Width" /><input type="radio" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>[full_width]" value="1" /></li>
				<li><img src="<?php echo $image_directory; ?>/2cl.png" alt="Left Sidebar" /><input type="radio" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>[left_sidebar]" value="1" /></li>
				<li><img src="<?php echo $image_directory; ?>/2cr.png" alt="Right Sidebar" /><input type="radio" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>[right_sidebar]" value="1" /></li>
			</ul>
		</label>
		<?php
	}
}

// add_filter( 'ejt_register_conrtol_type', '' , $priority = 10, $accepted_args = 1 )

// function register_control_type
