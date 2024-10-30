<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$table_name = $wpdb->prefix . 'pattern_lock';	
$current_user = wp_get_current_user();
$uid = $current_user->ID;
$lockValue = $_POST['lock_number'];
$getLockValue = $wpdb->get_row('select * from '.$table_name.' where uid = "'.$uid.'"');
if(count($getLockValue) == 0)
{
$savePattern = $wpdb->insert($table_name, array('uid' => $uid, 'lock_password' => $lockValue, 'request' => '0'), array('%d','%d','%d'));
}
else
{
$savePattern = 	$wpdb->update($table_name, array('lock_password' => $lockValue, 'request' => '0'), array('uid' => $uid), array('%d','%d'), array('%d'));
}
if($savePattern)
{
	echo '1';
}
else
{
	echo '0';
}
die;