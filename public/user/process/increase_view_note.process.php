<?php 
// sleep(2);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_get_request()){
	$note_id = h($_GET['note_id']);
	// Stores true or false
	$user_id = isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : null;
	$note = UserNote::increase_self_view_note($user_id, $note_id);
	if($note === true){
	$send_arr = array('type'=>'inc_self_view_note','result'=>'true');
}else{
	$send_arr = array('type'=>'inc_self_view_note','result'=>'false','errors'=> 'Can not be able to increase self view note');
	// logging 
	$logger->get_error_logger('INCREASES VIEW NOTE', $send_arr['errors']);
}
	echo json_encode($send_arr);
}


 ?>
