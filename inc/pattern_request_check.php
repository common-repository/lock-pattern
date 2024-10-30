<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$table_name = $wpdb->prefix . 'pattern_lock';	
$current_user = wp_get_current_user();
$uid = $current_user->ID;
$getLockValue = $wpdb->get_row('select * from '.$table_name.' where uid = "'.$uid.'" AND request = "1"');
if(count($getLockValue) == 1 && count($getLockValue) > 0)
{
 echo '1';
}
else
{
 echo '0';
}
die;