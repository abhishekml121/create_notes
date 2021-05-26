<?php 
// sleep(1);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_ajax_post_request()){
	$args = $_POST;
	$userNote = new UserNote($args);
	$userNote->generate_unique_note_id();
	$save_note = $userNote->save();

	if($save_note == true){
		$save_subject_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'subject_name'=>$userNote->subject_name];
		$subject = new NoteSubject($save_subject_args);
		$save_subject = $subject->save();
	if($save_subject == true){
		$save_tags_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'tag_name'=>$userNote->tag_name];
		$tags = new NoteTag($save_tags_args);
		$save_tags = $tags->save();
	}else{
		// note_subject can't save
		// logging
		$logger_message = "ID=>'{$userNote->user_id}' " . 'can not be able to create note_subject of new note at ' . date(DATE_COOKIE);
		$logger->get_error_logger('CREATE NOTE', $logger_message);
		// send response back to browser
		$send_arr = array('type'=>'create_note','result'=>'false','errors'=> 'Can not be able to create your note\'s subject');
		echo json_encode($send_arr);
		exit;
	}
	}else{
		// can't able to save note
		// logging
		$logger_message = "ID=>'{$userNote->user_id}' " . 'can not be able to create new note at ' . date(DATE_COOKIE);
		$logger->get_error_logger('CREATE NOTE', $logger_message);
		// send response back to browser
		$send_arr = array('type'=>'create_note','result'=>'false','errors'=> 'Can not be able to create your note');
		echo json_encode($send_arr);
		exit;
	}
	// all note data save in all tables successfully
	// logging
	$logger_message = "ID=>'{$userNote->user_id}' " . 'has created new note of note-ID => ' . "'{$userNote->note_id}'" . ' at ' . date(DATE_COOKIE);
	$logger->get_activity_logger('LOGIN', $logger_message);
	// send response back to browser
	$send_arr = array('type'=>'create_note','result'=>'true', 'note_id'=> $userNote->note_id);
	echo json_encode($send_arr);

}
 ?>