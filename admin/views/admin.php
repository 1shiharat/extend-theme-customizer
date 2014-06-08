<h2>Extends Theme Customizer</h2>

<p>json ファイルからテーマカスタマイザーの設定を行うことができます。</p>

<form action="" method="POST">
  <input type="text" name="etc_json_file" rows="30" cols="110"><?php echo $option; ?><br>
  <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
  <input type="hidden" name="_wp_nonce" value="<?php echo esc_attr( $create_nonce );?>" class="wp_nonce" />
  <input type="submit" class="button button-primary">
</form>
