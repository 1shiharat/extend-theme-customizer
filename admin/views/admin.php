<h2>Extends Theme Customizer</h2>

<p>json ファイルからテーマカスタマイザーの設定を行うことができます。</p>

<form action="" method="POST">
  <p> json ファイルのURL を入力してください。( <a href="https://gist.github.com/">Gist</a> なども使用できます。 )</p>
  <input type="text" name="etc_json_file" rows="30" value="<?php echo $option; ?>" class="regular-text"><br>
  <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
  <input type="hidden" name="_wp_nonce" value="<?php echo esc_attr( $create_nonce );?>" class="wp_nonce" />
  <input type="submit" class="button button-primary" value="<?php echo __( '送信', 'extend-theme-customizer' ); ?>">
</form>
