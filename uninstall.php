<?php
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();
	
// Uninstall code goes here

delete_option('unistall_easy_pricing_table');
if (is_multisite()) 
{
    global $wpdb;
	$wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."pricing_table" );
	$wpdb->query( "DROP TABLE IF EXISTS ".$wpdb->prefix."pricing_detail" );
}

?>
