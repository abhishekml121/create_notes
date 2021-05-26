<?php 
// sleep(1);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_ajax_post_request()){
	//check if user is loggedin --
	$check_user_login = ajax_require_login(); // true/false
	if($check_user_login == false){
		$send_arr = array('type'=>'edit_note','result'=>'false', 'errors'=>['login'=>false]);
		echo json_encode($send_arr);
		exit;
	}

	$args = $_POST;

	//validating note.
	$sql = 'SELECT * from notes where note_id='. "'". h($_SESSION['note_id']). "'".' AND user_id=' . "'". h($_SESSION['user_id'])."'";
	$userNote_array = UserNote::find_by_sql($sql);
	$userNote = array_shift($userNote_array);
	$userNote->merge_attributes($args);
	$save_note = $userNote->validate();

	//validating subject.
	


	//validating tags.


	//print_r($save_note);


	// saving note_subject
	if($save_note == true){
		$sql = 'SELECT * from notes_subject where note_id='. "'". h($_SESSION['note_id']). "'".' AND user_id=' . "'". h($_SESSION['user_id'])."'";
		$save_subject_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'subject_name'=>$userNote->subject_name];
		$subject_array = NoteSubject::find_by_sql($sql);
		$subject = array_shift($subject_array);
		$subject->merge_attributes($save_subject_args);
		$save_subject = $subject->save();
		//print_r($subject);
	if($save_subject == true){
		$save_tags_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'tag_name'=>$userNote->tag_name];
		$tag = new NoteTag($save_tags_args);
		$tag->delete_tag_for_update();
		$save_tag = $tag->save();
		}else{
			// note_subject can't save
			// logging
			$logger_message = "ID=>'{$userNote->user_id}' " . 'can not be able to save note_subject after edit of note by note-ID => ' . "'{$userNote->note_id}'" . ' at ' . date(DATE_COOKIE);
			$logger->get_error_logger('EDITED NOTE', $logger_message);
			$send_arr = array('type'=>'edit_note','result'=>'false','errors'=> 'Can not be able to save your subject');
			echo json_encode($send_arr);
			exit;
		}
	}else{
		// note can't save
		// logging
		$logger_message = "ID=>'{$userNote->user_id}' " . 'can not be able to save note after edit by note-ID => ' . "'{$userNote->note_id}'" . ' at ' . date(DATE_COOKIE);
		$logger->get_error_logger('EDITED NOTE', $logger_message);
		$send_arr = array('type'=>'edit_note','result'=>'false','errors'=> 'Can not be able to save your note');
		echo json_encode($send_arr);
		exit;
	}
	// all note data save in all tables successfully
	// logging
	$logger_message = "ID=>'{$userNote->user_id}' " . 'has edited their note of note-ID => ' . "'{$userNote->note_id}'" . ' at ' . date(DATE_COOKIE);
	$logger->get_activity_logger('EDITED NOTE', $logger_message);

	// send response back to browser
	$send_arr = array('type'=>'edit_note','result'=>'true');
	echo json_encode($send_arr);
}
 ?>