<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$table_name = $wpdb->prefix . 'pattern_lock';	
$current_user = wp_get_current_user();
$uid = $current_user->ID;
$lockValue = $_POST['lock_number'];
$getLockValue = $wpdb->get_row('select * from '.$table_name.' where uid = "'.$uid.'" AND request = "1" AND lock_password = "'.$lockValue.'"');
if(count($getLockValue)>0 && count($getLockValue) == 1)
{
 $updatePattern = $wpdb->update($table_name, array('request' => '0'), array('uid' => $uid), array('%d'), array('%d'));
 if($updatePattern)
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