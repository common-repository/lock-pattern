<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$table_name = $wpdb->prefix . 'pattern_lock';	
$current_user = wp_get_current_user();
$uid = $current_user->ID;
$savePattern = 	$wpdb->update($table_name, array('request' => '1'), array('uid' => $uid), array('%d'), array('%d'));
if($savePattern)
{
	echo '1';
}
else
{
	echo '0';
}
die;