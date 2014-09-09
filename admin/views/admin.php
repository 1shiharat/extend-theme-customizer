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
	<input id="etc_json_path" type="text" name="etc_json_file" rows="30" value="<?php echo esc_attr( $json_path ); ?>" class="regular-text"><br>
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
				<td><input type="text" value="<?php echo esc_html( $settings_key );  ?>" class="form-control"></td>
			</tr>
			<tr>
				<th><?php _e( 'Section title', 'extend-theme-customizer' ); ?></th>
				<td><input type="text" value="<?php echo esc_html( $settings->title );  ?>" class="form-control"></td>
			</tr>
			<tr class="alternate">
				<th><?php _e( 'Order', 'extend-theme-customizer' ); ?></th>
				<td><input type="text" value="<?php echo esc_html( $settings->priority );  ?>" class="form-control"></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php foreach ( $settings->setting as $setting_key => $setting ): ?>
					<table class="wp-list-table widefat" style="margin-bottom: 10px">
						<thead>
							<tr class="alternate">
								<th width="25%"><?php  _e( 'Title', 'extend-theme-customizer' ); ?></th>
								<th><input type="text" value="<?php echo esc_html( $setting->label );?>" class="form-control"></th>
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


  <div id='editor_holder'></div>
  <div id="json-editor" class="json-editor"></div>
  <script type="text/javascript">
  var $ = jQuery;
  // $(function () {
    //   var ETC_Customizer_Settings = <?php echo file_get_contents( get_option( 'etc_json_settings', false ) ); ?>
    //   // This is the starting value for the editor
    //   // We will use this to seed the initial editor
    //   // and to provide a "Restore to Default" button.
    //   var starting_value = ETC_Customizer_Settings;
    //   console.log(starting_value);
    //   // Initialize the editor
    //   var editor = new JSONEditor(document.getElementById('editor_holder'),{
    //     // Enable fetching schemas via ajax
    //     ajax: false,
    //     theme: 'bootstrap3',
    //     // The schema for the editor
    //     schema: {
				//   "title": "Theme Customizer",
				//   "type": "object",
				//   "properties": {
				//     "setting": {
				//       "type": "string",
				//       "description": "set capability",
				//       "minLength": 12,
				//       "default": "edit_theme_options"
				//     },
				//     "sections": {
				//       "type": "object",
				//       "format": "table",
				//       "title": "セクション",
				//       "uniqueItems": true,
				//       "items": {
				//       	"type": "object",
				//       	"title": "settings",
				//       	"properties": {
				// 	        "title": {
				// 	          "type": "string",
				// 	          "default": "text"
				// 	        },
				// 	        "priority": {
				// 	          "type": "integer",
				// 	          "default": "10"
				// 	        },
				// 	        "setting": {
				// 	          "type": "object",
				// 	          "description": "settings",
				// 	          "uniqueItems": true,
				// 	          "format": "table",
				// 			      "properties": {
				// 			        "transport": {
				// 			          "type": "string",
				// 			          "default": "postMessage"
				// 			        },
				// 			        "default": {
				// 			          "type": "string",
				// 			          "default": ""
				// 			        },
				// 			        "label": {
				// 			          "type": "string",
				// 			          "description": "label",
				// 			          "default": ""
				// 			        },
				// 			        "type": {
				// 			          "type": "string",
				// 			          "description": "textarea",
				// 			          "default": "textarea"
				// 			        }
				// 			      }
				// 			    }
				//         }
				//       }
				//     }
				//   }
				// },

    //     // Seed the form with a starting value
    //     startval: ETC_Customizer_Settings,

    //     // Disable additional properties
    //     no_additional_properties: true,

    //     // Require all properties by default
    //     required_by_default: true
    //   });

  // });

  </script>
<?php
endif ?>
