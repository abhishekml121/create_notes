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
	// check for hacking attempt
	if($note_id == 'null' || !has_presence($note_id)){
		$message = '<div style="color:#000000;font-size:1.3em"><span>Something went wrong. Your note could not delete at this time.</span><div><b>Tip: </b>Try to refresh this page and try again.</div></div>';
		$send_arr = array('type'=>'delete_note','result'=>'false','errors'=> $message, 'popup_error'=> 'true');
		echo json_encode($send_arr);
		exit;
	}
	$user_id = isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : '';
	if($user_id == ''){
		$message = 'Your session has expired. Please login again !';
		$send_arr = array('type'=>'delete_note','result'=>'false','errors'=> $message, 'login'=>'false');
		echo json_encode($send_arr);
		exit;
	}
	$note = UserNote::delete_note($user_id, $note_id); // true/false
	if($note === true){
		$send_arr = array('type'=>'delete_note','result'=>'true', 'message'=>'Note has deleted');
	}else{
		$message = '<div class="ajax_error_popup"><span class="message1_break">Server error. Your note can not delete</span>';
		$message .= '<span class="solution_tip_popup"><b>Tip: </b>Try to refresh this page and try again.</span></div>';
		$send_arr = array('type'=>'delete_note','result'=>'false','errors'=> $message, 'popup_error'=> 'true', 'note_id'=> $note_id);

		// logging 
		$logger->get_error_logger('DELETE NOTE', 'can not delete note of ID:'. $note_id. ' at ' . date(DATE_COOKIE));
}
	echo json_encode($send_arr);
}


 ?>
