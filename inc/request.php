<?php 
	function request(){
	global $wpdb;
	if($_GET['id']){
			$id=$_GET['id'];
			$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."pricing_detail WHERE pid = %s",$id));
	}
	
	global $wpdb;
	if($_GET['table_id']){
			$id=$_GET['table_id'];
			$sql=$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."pricing_table WHERE id = %s",$id));
	}}?>
