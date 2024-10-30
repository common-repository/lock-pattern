<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$table_name = $wpdb->prefix . 'pattern_lock';	
$current_user = wp_get_current_user();
$uid = $current_user->ID;
$getLockValue = $wpdb->get_row('select * from '.$table_name.' where uid = "'.$uid.'"');
$opt = get_option('pattern_lock_options');
?>
<div class="wrap">
<h2><?php _e('Please Draw a Pattern Lock', 'pl');?></h2>
<table class="form-table">
<tbody><tr>
<th scope="row"><label for="blogname"><?php _e('Please Draw a Pattern For Lock Screen', 'pl');?></label></th>
<td><?php if($opt['enable_pattern_lock'] != 'Yes'){ _e('<span class="hightlight">Please enable pattern lock first from Pattern Lock <a href="admin.php?page=pattern_lock_settings" title="Click to go to settings page.">Settings</a></span>', 'pl'); } else { ?><div id="gesturepwd2"></div> <?php } ?>
<p id="tagline-description" class="description"><?php _e('Please Draw a Pattern Structure Here.', 'pl');?></p></td>
</tr>
<tr>
<th scope="row"><label for="blogdescription"><?php _e('Output Pattern Numbers', 'pl');?></label></th>
<td><input type="text" readonly="readonly" id="pwdval" value="<?php echo $getLockValue->lock_password; ?>"/>
<p id="tagline-description" class="description"><?php _e('These generated numbers will help you remember the pattern series.', 'pl');?></p>
</td>
</tr>
</tbody></table>
</div>
<?php if($opt['enable_pattern_lock'] == 'Yes'){?>
<script>
  jQuery("#gesturepwd2").GesturePasswd({
		backgroundColor: "#<?php echo !empty($opt['backgroundColor']) ? $opt['backgroundColor'] : '2980B9';?>",
		color:"#<?php echo !empty($opt['color']) ? $opt['color'] : 'FFFFFF';?>",
		roundRadii:<?php echo !empty($opt['roundRadii']) ? $opt['roundRadii'] : '20';?>,
		pointRadii:<?php echo !empty($opt['pointRadii']) ? $opt['pointRadii'] : '12';?>,
		space:<?php echo !empty($opt['space']) ? $opt['space'] : '20';?>,
		width:<?php echo !empty($opt['width']) ? $opt['width'] : '180';?>,
		height:<?php echo !empty($opt['height']) ? $opt['height'] : '180';?>,
		lineColor:"#<?php echo !empty($opt['lineColor']) ? $opt['lineColor'] : 'ECF0F1';?>",
		zindex :<?php echo !empty($opt['zindex']) ? $opt['zindex'] : '100';?>
});
  jQuery("#gesturepwd2").on("hasPasswd",function(e,passwd){
	  var returnit = false;
	  if(passwd == '')
	  {
		 alert('Please Draw a Pattern!');  
		returnit = false;  
	  }
	  else
	  {
		 returnit = true;
	  }
	if(returnit)
	{  
		jQuery('#pwdval').val(passwd);
		  var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
/* Ajax - Start */ 	
		   var data = {
				'action': 'pattern_save',
				'lock_number': passwd  
			   };
			 jQuery.post(ajax_url, data, function(response) {
			 if(response == '1')
			 {	 
			 jQuery("#gesturepwd2").trigger("passwdRight");
			 alert('Pattern Saved! Please remember Pattern.');
			 }
			 else
			 {
			 jQuery("#gesturepwd2").trigger("passwdWrong");	
			 alert('Pattern Not Saved!'); 
			 }
			});	
	}
/* Ajax - End */
  });

</script>
<?php } ?>