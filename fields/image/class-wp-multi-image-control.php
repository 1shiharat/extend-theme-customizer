<?php

if ( ! class_exists( 'WP_Customize_Control' ) ){
	return NULL;
}

/**
 * =====================================================
 * @package    Grow Creater
 * @subpackage WP Multi Image Control
 * @author     Grow Group
 * @license    http://creativecommons.org/licenses/by/2.1/jp/
 * @link       http://grow-group.jp
 * @copyright  2014 Drema Style
 * =====================================================
 */


class WP_Multi_Image_Control extends \WP_Customize_Control
{

	public $type = 'multi_image';

	protected $inputId = '';

	protected $thumbnailsId = '';

	/**
	 * construct
	 */
	public function __construct( $manager, $id, $args = array() )
	{

		parent::__construct( $manager, $id, $args );

		$this->inputId = $this->type . '_control_' . $this->id;
		$this->thumbnailsId = $this->inputId . '_thumbnails';

	}

	/**
	 * js, css enqueue
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

		$imageSrcs = explode( ',' , $this->value() );

		if ( ! is_array( $imageSrcs ) ) {
				$imageSrcs = array();
		}

		$this->the_title();
		$this->the_buttons();
		$this->the_uploaded_images( $imageSrcs );

	}

		/**
		 * return title
		 */
	protected function the_title()
	{
		echo '<label><span class="customize-control-title">';
		echo esc_html( $this->label );
		echo '</span>
		</label>';
	}

	/**
	 * return images
	 */
	protected function get_images(){

		$options = $this->value();

		if ( ! isset( $options['image_sources'] ) ) {
				return '';
		}

		return $options['image_sources'];

	}

	/**
	 * return button
	 */
	public function the_buttons() {
	?>
		<div>
				<input type="hidden" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> id="<?php echo esc_attr( $this->inputId ); ?>" data-thumbs-container="#<?php echo esc_attr( $this->thumbnailsId ); ?>" class="multi-images-control-input"/>
				<a href="#" class="button-secondary multi-images-upload" data-store="#<?php echo esc_attr( $this->inputId ); ?>">
						<?php echo __( 'Upload', 'custom_theme_customizer' ); ?>
				</a>
				<a href="#" class="button-secondary multi-images-remove" data-store="#<?php echo esc_attr( $this->inputId ); ?>" data-thumbs-container="#<?php echo esc_attr( $this->thumbnailsId ); ?>">
					 <?php echo __( 'Remove', 'custom_theme_customizer'); ?>
			 </a>
		</div>
	<?php
 }

	/**
	 * uploaded images
	 */
	public function the_uploaded_images( $srcs = array() ){
	?>
	<div class="customize-control-content">
		<?php
		if ( is_array( $srcs ) ): ?>
			<ul class="thumbnails" data-store="#<?php echo esc_attr( $this->inputId ); ?>" id="<?php echo esc_attr( $this->thumbnailsId ); ?>">
			<?php foreach ( $srcs as $src ): ?>
				<li class="thumbnail" style="background-image: url(<?php echo esc_url( $src ); ?>);" data-src="<?php echo esc_url( $src ); ?>">
				</li>
			<?php endforeach; ?>
			</ul>
		<?php
		endif; ?>
	</div>
	<?php
	}
}
