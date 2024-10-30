<?php if ( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly ?>
<?php $opt = get_option('pattern_lock_options');
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<div class="wrap">
<h1><?php _e("Pattern Lock Settings", 'pl') ?></h1>
<?php if(isset($_POST['pattern_lock_submit']) && wp_verify_nonce( $_POST['pattern_lock_nonce_field'], 'pattern_lock_action' )):
	_e("<strong>Saving Please wait...</strong>", 'pl');
	$needToUnset = array('pattern_lock_submit');
	foreach($needToUnset as $noneed):
	  unset($_POST[$noneed]);
	endforeach;
		foreach($_POST as $key => $val):
		$pattern_lock_options[$key] = $val;
		endforeach;
		 $saveSettings = update_option('pattern_lock_options', $pattern_lock_options );
		if($saveSettings)
		{
			pattern_lock::pl_redirect('admin.php?page=pattern_lock_settings&msg=1');
		}
		else
		{
			pattern_lock::pl_redirect('admin.php?page=pattern_lock_settings&msg=2');
		}
endif;
if(!empty($msg) && $msg == 1):
  _e( '<div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong>Settings saved.</strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', 'pl');	
elseif(!empty($msg) && $msg == 2):
  _e( '<div class="error settings-error notice is-dismissible" id="setting-error-settings_updated"> 
<p><strong>Settings not saved.</strong></p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>', 'pl');
endif;
?>
<form action="" method="post" name="pattern_lock_form">
<?php wp_nonce_field( 'pattern_lock_action', 'pattern_lock_nonce_field' ); ?>
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="enable_pattern_lock"><?php _e("Enable Pattern Lock", 'pl') ?></label></th>
<td>
<p id="tagline-description" class="description"><input type="checkbox" value="Yes" name="enable_pattern_lock" id="enable_pattern_lock" <?php echo ($opt['enable_pattern_lock'] == 'Yes') ? 'checked="checked"' : '';?>/><?php _e("Check to enable Pattern Lock", 'pl') ?></p></td>
</tr>
<tr>
<th scope="row"><label for="backgroundColor"><?php _e("Background Color", 'pl') ?></label></th>
<td><input type="text" class="regular-text jscolor" value="<?php echo $opt['backgroundColor'];?>" id="backgroundColor" name="backgroundColor">
<p id="tagline-description" class="description"><?php _e("Pattern Lock Background Color", 'pl') ?></p></td>
</tr>
<tr>
<th scope="row"><label for="color"><?php _e("Color", 'pl') ?></label></th>
<td><input type="text" class="regular-text jscolor" value="<?php echo $opt['color'];?>" id="color" name="color">
<p id="tagline-description" class="description"><?php _e("Pattern Lock Circle Color", 'pl') ?></p></td>
</tr>
<tr>
<th scope="row"><label for="lineColor"><?php _e("Line Color", 'pl') ?></label></th>
<td><input type="text" class="regular-text code jscolor" value="<?php echo $opt['lineColor'];?>" id="lineColor" name="lineColor">
<p id="tagline-description" class="description"><?php _e("Pattern Lock Line Color", 'pl') ?></p>
</td>
</tr>
<tr>
<th scope="row"><label for="roundRadii"><?php _e("Round Radii", 'pl') ?></label></th>
<td><input type="number" class="regular-text code" value="<?php echo $opt['roundRadii'];?>" id="roundRadii" name="roundRadii">
</td>
</tr>
<tr>
<th scope="row"><label for="pointRadii"><?php _e("Point Radii", 'pl') ?></label></th>
<td><input type="number" class="regular-text code" value="<?php echo $opt['pointRadii'];?>" id="pointRadii" name="pointRadii"></td>
</tr>
<tr>
<th scope="row"><label for="space"><?php _e("Space", 'pl') ?></label></th>
<td><input type="number" class="regular-text code" value="<?php echo $opt['space'];?>" id="space" name="space"></td>
</tr>
<tr>
<th scope="row"><label for="width"><?php _e("Width", 'pl') ?></label></th>
<td><input type="number" class="regular-text code" value="<?php echo $opt['width'];?>" id="width" name="width">
<p id="tagline-description" class="description"><?php _e("Width of Pattern Lock", 'pl') ?></p>
</td>
</tr>
<tr>
<th scope="row"><label for="height"><?php _e("Height", 'pl') ?></label></th>
<td><input type="number" class="regular-text code" value="<?php echo $opt['height'];?>" id="height" name="height">
<p id="tagline-description" class="description"><?php _e("Height of Pattern Lock", 'pl') ?></p>
</td>
</tr>
<tr>
<th scope="row"><label for="zindex"><?php _e("z-index", 'pl') ?></label></th>
<td><input type="number" class="regular-text code" value="<?php echo $opt['zindex'];?>" id="zindex" name="zindex">
<p id="tagline-description" class="description"><?php _e("z-index for Pattern Lock", 'pl') ?></p>
</td>
</tr>
<tr>
<th scope="row"><label for="pattern_lock_text"><?php _e("Pattern Lock Text", 'pl') ?></label></th>
<td><input type="text" class="regular-text" value="<?php echo $opt['pattern_lock_text'];?>" id="pattern_lock_text" name="pattern_lock_text">
<p id="tagline-description" class="description"><?php _e("Pattern Lock Text will appear on Lock Screen", 'pl') ?></p></td>
</tr>
<tr>
<th scope="row"><label for="pattern_lock_text_color"><?php _e("Pattern Lock Text Color", 'pl') ?></label></th>
<td><input type="text" class="regular-text code jscolor" value="<?php echo $opt['pattern_lock_text_color'];?>" id="pattern_lock_text_color" name="pattern_lock_text_color">
<p id="tagline-description" class="description"><?php _e("Pattern Lock Text Color", 'pl') ?></p></td>
</tr>
</tbody></table>

<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="pattern_lock_submit"></p></form>

</div>