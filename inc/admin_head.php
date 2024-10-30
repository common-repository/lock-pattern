<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<script src="<?php echo plugins_url( 'js/jquery.gesture.password.js', __FILE__ );?>"></script>
<script>
jQuery(document).ready(function(e) {
	 var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
    jQuery('.lock_screen a').click(function(e) {
		var data = {
				'action': 'pattern_request_send',
			    };
			 jQuery.post(ajax_url, data, function(response) {
			 if(response == '1')
			 {	 
		       jQuery('#lock_screen_mk').show();
			 }
			 else
			 {
			   jQuery('#lock_screen_mk').hide();	
			 }
			});
    });
/* Checking If Request exits */
		/* Ajax - Start */ 	
		   var data = {
				'action': 'pattern_request_check',
			   };
			 jQuery.post(ajax_url, data, function(response) {
			 if(response == '1')
			 {	 
		      jQuery('#lock_screen_mk').show();
			 }
			 else
			 {
			   jQuery('#lock_screen_mk').hide();	
			 }
			});	
/* Forgot Password ? */
	jQuery('#forget_Password_request').click(function(e) {
          var data = {
				'action': 'pattern_forgot',
			   };
			 jQuery.post(ajax_url, data, function(response) {
			 if(response == '1')
			 {	 
		       jQuery('#forgetNumber').show();
			 }
			 else
			 {
			   alert('Email not sent!');
			 }
       });	
	});	
/* End Forgot */
/* Forgot Password Submit */
jQuery('#forgot_pattern').click(function(e) {
 var passwd = jQuery('#pattern_number').val();
 var goahead = false;
 if(passwd != '')
 {
	 goahead = true;
 }
 else
 {
	 goahead = false;
 }
 if(goahead == true)
 {
   var data = {
				'action': 'pattern_confirmed',
				'lock_number': passwd  
			   };
			 jQuery.post(ajax_url, data, function(response) {
			 if(response == '1')
			 {	 
				 jQuery('#lock_screen_mk').hide();
			 }
			 else
			 {
			     jQuery('#lock_screen_mk').show();
			 }
			});
 }
  });	
/* End Forgot Password Submit */  	
});
</script>
<?php $opt = get_option('pattern_lock_options');?>
<div tabindex="0" id="lock_screen_mk" style="position: relative; display: none;" class="supports-drag-drop">
		<div class="media-modal wp-core-ui">
			<div class="media-modal-content"><div class="media-frame mode-select wp-core-ui" id="__wp-uploader-id-0">

		<div class="media-frame-title mk-media-frame-title"><h1 style="color:#<?php echo !empty($opt['pattern_lock_text_color']) ? $opt['pattern_lock_text_color'] : '000000';?>"><?php echo !empty($opt['pattern_lock_text']) ? $opt['pattern_lock_text'] : "Please Draw Pattern to Unlock Screen"; ?><span class="dashicons dashicons-arrow-down"></span></h1></div>
        
		<div class="media-frame-content mk-content"><div class="uploader-inline">
		
		
		<div class="uploader-inline-content no-upload-message mk-cust-class">
		
			<div id="gesturepwd"></div>
              
              <a href="#" id="forget_Password_request"><?php _e("Forgot Pattern?", 'pl') ?></a>
			  <div id="forgetNumber" style="display:none;">
              <p class="hightlight"><?php _e("A code is sent on your email. Please enter that code below in field or Draw Pattern according to that code .", 'pl') ?></p>
              <table>
              <tr>
              <th><?php _e("Enter Code Here", 'pl') ?></th>
              <td><input type="text" value="" id="pattern_number" name="pattern_number"/></td>
              <td><button id="forgot_pattern" class="button button-primary"><?php _e("Submit", 'pl') ?></button></td>
              </tr>
              </table>
              </div>
				</div>
	</div></div>
		
		
	</div></div>
		</div>
		<div class="media-modal-backdrop"></div>
	</div>
<script>
var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
  jQuery("#gesturepwd").GesturePasswd({
		backgroundColor: "#<?php echo !empty($opt['backgroundColor']) ? $opt['backgroundColor'] : '2980B9';?>",
		color:"#<?php echo !empty($opt['color']) ? $opt['color'] : '000000';?>",
		roundRadii:<?php echo !empty($opt['roundRadii']) ? $opt['roundRadii'] : '20';?>,
		pointRadii:<?php echo !empty($opt['pointRadii']) ? $opt['pointRadii'] : '12';?>,
		space:<?php echo !empty($opt['space']) ? $opt['space'] : '20';?>,
		width:<?php echo !empty($opt['width']) ? $opt['width'] : '180';?>,
		height:<?php echo !empty($opt['height']) ? $opt['height'] : '180';?>,
		lineColor:"#<?php echo !empty($opt['lineColor']) ? $opt['lineColor'] : 'ECF0F1';?>",
		zindex :<?php echo !empty($opt['zindex']) ? $opt['zindex'] : '100';?>
});
  jQuery("#gesturepwd").on("hasPasswd",function(e,passwd){
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
		/* Ajax - Start */ 	
		   var data = {
				'action': 'pattern_confirmed',
				'lock_number': passwd      // We pass php values differently!
			   };
			 jQuery.post(ajax_url, data, function(response) {
			 if(response == '1')
			 {	 
			 jQuery("#gesturepwd").trigger("passwdRight");
			 jQuery('#lock_screen_mk').hide();
			 }
			 else
			 {
			 jQuery("#gesturepwd").trigger("passwdWrong");
			 }
			});	
	
	}
/* Ajax - End */
  });
</script>