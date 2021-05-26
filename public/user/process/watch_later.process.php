<?php 
// sleep(2);
// this file will help to increase or decrease the watch later boolean in DB.
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_ajax_post_request()){
	$note_id = h($_GET['note_id']);
	// Stores true or false
	$user_id = isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : null;
	if($user_id == null){
	$send_arr = array('type'=>'watch_later','result'=>'false','errors'=> 'Your session has expired. Please login !');
	}else{
	$note = UserNote::update_watch_later($user_id, $note_id);
	if($note['update'] === true){
		if($note['current_watch_later_value'] == 1){
			$message = 'Added to watch later';
		}else{
			$message = 'Removed from watch later';
		}
	$send_arr = array('type'=>'watch_later','result'=>'true', 'current_watch_later_value'=>$note['current_watch_later_value'], 'message'=>$message);
}else{
	$send_arr = array('type'=>'watch_later','result'=>'false','errors'=> 'Can not be able to update watch later');
	// logging 
	$logger->get_error_logger('UPDATED WATCH LATER', $send_arr['errors']);
}
}
	echo json_encode($send_arr);
}


 ?>
