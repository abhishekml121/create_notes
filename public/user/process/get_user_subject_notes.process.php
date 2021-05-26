<?php 
// sleep(1);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_get_request()){
	$args = $_GET;
	// ? we'are only getting those keys which are allowed.
	if(!is_valid_GET_keys(array_keys($args), ['page', 'subject_name'])){
		echo json_encode(array('type'=>'get_user_subject_notes', 'data_valid' => 'false'));
		exit;
	}

	$current_page = $args['page'] ?? 1; // it will be like 1,2,3,4 etc.
	$per_page = 5; // increase this for getting more results
	$note = new UserNote;
	$pagination = new Pagination($current_page, $per_page);
	$args_2 = [];
	$args_2 = ['limit'=>$per_page, 'offset'=>$pagination->offset(), 'user_id'=>(int) $_COOKIE['user_id'], 'subject_name'=> $args['subject_name']];
	$notes_obj = $note->get_user_notes_by_subject_name($args_2, $offset=true);
	if(!empty($notes_obj)){
		if($args['page'] == 1){
			$subject_notes_info = UserSubject::subject_notes_info($note->get_user_notes_by_subject_name($args_2, $offset=false));
		}
		$u_subject_notes = $note->get_note_html($notes_obj);
	}else{
		$u_subject_notes = false;
	}
	
	if($u_subject_notes !== false){
		$send_arr = array('type'=>'get_user_subject_notes','result'=>'true','user_subject_notes_html'=> $u_subject_notes);
		if($args['page'] == 1){
			$send_arr['subject_notes_info'] = $subject_notes_info;
		}
	}elseif($current_page == 1 && $u_subject_notes == false){
		$error_message = 'You do not have any note for the <b>subject: ';
		$error_message .= $args['subject_name'] .'</b>. Try to <a href="'. url_for('/user/create_note?subjectName='. trim($args['subject_name'])) .'">create new note</a>';
		$send_arr = array('type'=>'get_user_subject_notes','result'=>'false','message'=> $error_message);
	}elseif($u_subject_notes === false){
		$send_arr = array('type'=>'get_user_subject_notes','result'=>'false','message'=>'No more notes to show');
	}else{
		$send_arr = array('type'=>'get_user_subject_notes','result'=>'false','error'=> 'Can not load notes', 'server_error'=>'true');
	}

	echo json_encode($send_arr);

}


 ?>
