<style>
table.widefat{
	margin-bottom: 20px;
}
</style>
<h1><?php _e( 'Extends Theme Customizer', 'extend-theme-customizer' );?></h1>

<p><?php _e( 'You can make the setting of the theme customizer from json file.', 'extend-theme-customizer' );?></p>

<form action="" method="POST">
	<h3><?php _e( 'Please enter the URL or Path of the json file.', 'extend-theme-customizer' );?></h3>
	<p><?php _e( 'can also use the Gist <a href="https://gist.github.com/">Gist</a> ', 'extend-theme-customizer' );?></p>
	<input type="text" name="etc_json_file" rows="30" value="<?php echo esc_attr( $json_path ); ?>" class="regular-text"><br>
	<h3><?php _e( 'Enter the width of the theme customizer. (px)', 'extend-theme-customizer' ); ?></h3>
	<input type="number" name="etc_width_file" rows="30" value="<?php echo esc_attr( $tc_width ); ?>" class="regular-text"><br>
	<br>
	<input type="hidden" name="_wp_nonce" value="<?php echo esc_attr( $create_nonce );?>" class="wp_nonce" />
	<input type="submit" class="button button-primary" value="<?php _e( 'Save this setting', 'extend-theme-customizer' ); ?>">
</form>

<?php if ( $setting_object ): ?>

	<h2><?php _e( 'Setting item list', 'extend-theme-customizer' ); ?></h2>

	<table class=" widefat">
		<tbody>
			<tr>
				<th><?php _e( 'Privileges available', 'extend-theme-customizer' ); ?></th>
				<td><?php echo esc_html( $setting_object->setting->capability ); ?></td>
			</tr>
		</tbody>
	</table>
	<?php
	foreach ( $setting_object->sections as $settings_key => $settings ) : ?>
	<table class="widefat">
			<tr class="alternate">
				<th width="26%"><?php _e( 'Section ID', 'extend-theme-customizer' ); ?></th>
				<td><?php echo esc_html( $settings_key );  ?></td>
			</tr>
			<tr>
				<th><?php _e( 'Section title', 'extend-theme-customizer' ); ?></th>
				<td><?php echo esc_html( $settings->title );  ?></td>
			</tr>
			<tr class="alternate">
				<th><?php _e( 'Order', 'extend-theme-customizer' ); ?></th>
				<td><?php echo esc_html( $settings->priority );  ?></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php foreach ( $settings->setting as $setting_key => $setting ): ?>
					<table class="wp-list-table widefat" style="margin-bottom: 10px">
						<thead>
							<tr class="alternate">
								<th width="25%"><?php  _e( 'Title', 'extend-theme-customizer' ); ?></th>
								<th><?php echo esc_html( $setting->label );  ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?php _e( 'ID', 'extend-theme-customizer' ); ?></th>
								<th><code><?php echo esc_html( $setting_key );  ?></code></th>
							</tr>
							<tr class="alternate">
								<th><?php _e( 'Type', 'extend-theme-customizer' ); ?></th>
								<td><?php echo esc_html( $setting->type );  ?></td>
							</tr>
							<tr>
								<th><?php _e( 'Output PHP Tag', 'extend-theme-customizer' ); ?></th>
								<td>
								<code>&lt;?php echo esc_html( get_theme_mod( '<?php echo esc_html( $setting_key );  ?>', '<?php echo esc_html( $setting->default );  ?>' ) ); ?&gt;</code></td>
							</tr>
						</tbody>
					</table>
					<?php
					endforeach ?>
				</td>
		</tr>
		</tbody>
	</table>
	<?php
	endforeach;?>

<?php
endif ?>
