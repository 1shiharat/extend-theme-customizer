<?php

/**
 *  Media Uploader For Theme Customizer
 * =====================================================
 * @package    Extend Theme Customizer
 * @author     takashi ishihara
 * @license    GPLv2 or later
 * @link       https://github.com/1shiharaT/extend-theme-customizer
 * =====================================================
 */

if ( ! class_exists( 'WP_Customize_Control' ) ){
	return NULL;
}

class Multi_Image_Custom_Control extends WP_Customize_Control
{

	/**
	 * Control Slug
	 * @var string
	 */
	public $type = 'multi_image';

	/**
	 * Input ID
	 * @var string
	 */
	protected $input_id = '';

	/**
	 * Thumbnail ID
	 * @var string
	 */
	protected $thumbnails_id = '';

	/**
	 * construct
	 */
	public function __construct( $manager, $id, $args = array() )
	{

		parent::__construct( $manager, $id, $args );

		$this->input_id = $this->type . '_control_' . $this->id;
		$this->thumbnails_id = $this->input_id . '_thumbnails';

	}

	/**
	 * js, css enqueue
	 * @return void
	 */
	public function enqueue()
	{

		wp_enqueue_media();

		// js
		$js_path = plugins_url( '/assets/js/customize-media-uploader.js', __FILE__ );

		wp_enqueue_script( 'wp-mutli-image-control', $js_path , array( 'jquery', 'jquery-ui-sortable' ) );

		// css
		$css_path = plugins_url( '/assets/css/customize-media-uploader.css', __FILE__ );

		wp_enqueue_style( 'wp-mutli-image-control', $css_path );

	}

	/**
	 * rendering theme customizer
	 */
	public function render_content()
	{

		$image_srcs = explode( ',' , $this->value() );

		if ( ! is_array( $image_srcs ) ) {
				$image_srcs = array();
		}

		$this->the_title();
		$this->the_buttons();
		$this->the_uploaded_images( $image_srcs );

	}

		/**
		 * return title
		 */
	public function the_title()
	{
		echo '<label><span class="customize-control-title">';
		echo esc_html( $this->label );
		echo '</span>
		</label>';
	}

	/**
	 * Return Images
	 *
	 * @return string imaage path
	 */
	public function get_images(){

		$options = $this->value();

		if ( ! isset( $options['image_sources'] ) ) {
				return '';
		}

		return $options['image_sources'];

	}

	/**
	 * Return Button
	 *
	 * @return void html
	 */
	public function the_buttons() {
	?>
		<div>
				<input type="hidden" value="<?php echo esc_url( $this->value() ); ?>" <?php $this->link(); ?> id="<?php echo esc_attr( $this->input_id ); ?>" data-thumbs-container="#<?php echo esc_attr( $this->thumbnails_id ); ?>" class="multi-images-control-input"/>
				<a href="#" class="button-secondary multi-images-upload" data-store="#<?php echo esc_attr( $this->input_id ); ?>">
						<?php echo __( 'Upload', 'custom_theme_customizer' ); ?>
				</a>
				<a href="#" class="button-secondary multi-images-remove" data-store="#<?php echo esc_attr( $this->input_id ); ?>" data-thumbs-container="#<?php echo esc_attr( $this->thumbnails_id ); ?>">
					 <?php echo __( 'Remove', 'custom_theme_customizer'); ?>
			 </a>
		</div>
	<?php
 }

	/**
	 * uploaded images
	 */
	public function the_uploaded_images( $srcs = array() )
	{
	?>
		<div class="customize-control-content">
		<?php
		if ( is_array( $srcs ) ) :
		?>
			<ul class="thumbnails" data-store="#<?php echo esc_attr( $this->input_id ); ?>" id="<?php echo esc_attr( $this->thumbnails_id ); ?>">
			<?php
			foreach ( $srcs as $src ) :
			?>
				<li class="thumbnail" style="background-image: url(<?php echo esc_url( $src ); ?>);" data-src="<?php echo esc_url( $src ); ?>">
				</li>
			<?php
			endforeach;
			?>
			</ul>
		<?php
		endif;
		?>
	</div>
	<?php
	}
}
