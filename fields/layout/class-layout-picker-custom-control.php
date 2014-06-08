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

		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul>
				<li><img src="<?php echo plugins_url( '/img/1col.png', __FILE__ ); ?>" alt="Full Width" /><input type="radio" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>[full_width]" value="1" /></li>
				<li><img src="<?php echo plugins_url( '/img/2cl.png', __FILE__ ); ?>" alt="Left Sidebar" /><input type="radio" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>[left_sidebar]" value="1" /></li>
				<li><img src="<?php echo plugins_url( '/img/2cr.png', __FILE__ ); ?>" alt="Right Sidebar" /><input type="radio" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>[right_sidebar]" value="1" /></li>
			</ul>
		</label>
		<?php
	}
}
