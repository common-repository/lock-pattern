<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$table_name = $wpdb->prefix .'pattern_lock';	
$current_user = wp_get_current_user();
$uid = $current_user->ID;
$urMail = $current_user->user_email;
$display_name = $current_user->display_name;
$currenturl = get_bloginfo('url');
$getLockValue = $wpdb->get_row('select * from '.$table_name.' where uid = "'.$uid.'" AND request = "1"');
if(count($getLockValue) == 1 && count($getLockValue) > 0)
{
    $patternLock = $getLockValue->lock_password;
    $to = $urMail;
	$subject = 'Pattern Lock Forgot Request';
	$body = 'Hello, '.$display_name.' Your Pattern Code number is '.$patternLock.' for '.$currenturl.' . Please Fill this code in text field under forgot password link or you can draw pattern according to these numbers. Thanks';
	$headers = array('Content-Type: text/html; charset=UTF-8');	
	$sentMail = wp_mail( $to, $subject, $body, $headers );
	if($sentMail)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}
else
{
 echo '0';
}
die;