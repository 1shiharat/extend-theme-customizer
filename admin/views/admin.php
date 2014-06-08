<style>
table.widefat{
  margin-bottom: 20px;
}
</style>
<h1>Extends Theme Customizer</h1>

<p>json ファイルからテーマカスタマイザーの設定を行うことができます。</p>

<form action="" method="POST">
  <h3> json ファイルのURL を入力してください。</h3>
  <p><a href="https://gist.github.com/">Gist</a> なども使用できます。</p>
  <input type="text" name="etc_json_file" rows="30" value="<?php echo esc_attr( $json_path ); ?>" class="regular-text"><br>
  <h3><?php echo __( "テーマカスタマイザーの幅を入力してください。 (px)", "extend-theme-customizer" ); ?></h3>
  <input type="number" name="etc_width_file" rows="30" value="<?php echo esc_attr( $tc_width ); ?>" class="regular-text"><br>
  <br>
  <input type="hidden" name="_wp_nonce" value="<?php echo esc_attr( $create_nonce );?>" class="wp_nonce" />
  <input type="submit" class="button button-primary" value="<?php echo __( 'この設定で保存', 'extend-theme-customizer' ); ?>">
</form>

<h2>設定項目リスト</h2>

<table class=" widefat">
  <tbody>
    <tr>
      <th>利用可能な権限</th>
      <td><?php echo esc_html( $setting_object->setting->capability ); ?></td>
    </tr>
  </tbody>
</table>
<?php
foreach ( $setting_object->sections as $settings_key => $settings ) : ?>
<table class=" widefat">
    <tr class="alternate">
      <th width="26%"><?php echo __( "セクションID", 'extend-theme-customizer' ); ?></th>
      <td><?php echo esc_html( $settings_key );  ?></td>
    </tr>
    <tr>
      <th><?php echo __( "セクションタイトル", 'extend-theme-customizer' ); ?></th>
      <td><?php echo esc_html( $settings->title );  ?></td>
    </tr>
    <tr class="alternate">
      <th><?php echo __( "順番", 'extend-theme-customizer' ); ?></th>
      <td><?php echo esc_html( $settings->priority );  ?></td>
    </tr>
    <tr>
      <td colspan="2">
        <?php foreach ( $settings->setting as $setting_key => $setting ): ?>
        <table class="wp-list-table widefat" style="margin-bottom: 10px">
          <thead>
            <tr class="alternate">
              <th width="25%"><?php echo __( "タイトル", 'extend-theme-customizer' ); ?></th>
              <th><?php echo esc_html( $setting->label );  ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><?php echo __( "ID", 'extend-theme-customizer' ); ?></th>
              <th><code><?php echo esc_html( $setting_key );  ?></code></th>
            </tr>
            <tr class="alternate">
              <th><?php echo __( "タイプ", 'extend-theme-customizer' ); ?></th>
              <td><?php echo esc_html( $setting->type );  ?></td>
            </tr>
            <tr>
              <th><?php echo __( "出力タグ", 'extend-theme-customizer' ); ?></th>
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
<?php endforeach;?>


</p>
