<?php 
/*
* Ajax Action
*/

if(!function_exists('chSearch')){
	function chSearch(){
		global $spDB;
		$status 			= $spDB->get_ch_shipping($_POST['sVal']);
		$allStatus 			= $spDB->get_shipping_status($_POST['sVal']);
		$status->lastStatus = $spDB->last_status($_POST['sVal']); 
		$status->allstatus 	= json_encode($allStatus);
		echo json_encode($status);
		die();
	}
	add_action( 'wp_ajax_chSearch', 'chSearch' );
	add_action( 'wp_ajax_nopriv_chSearch', 'chSearch' );
}
?>