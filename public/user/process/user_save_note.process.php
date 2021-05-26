<?php 
// sleep(2);
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
		$send_arr = array('type'=>'create_note','result'=>'false', 'login'=>'false');
		echo json_encode($send_arr);
		exit;
	}

	$args = $_POST;
	
	// Validate note, subject, tags. If no error found then save data in those three tables;
	$userNote = new UserNote($args);
	$userNote->generate_unique_note_id();
	$save_note = $userNote->validate();

	$save_subject_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'subject_name'=>$userNote->subject_name];
	$subject = new NoteSubject($save_subject_args);
	$save_subject = $subject->validate();
	
	$save_tags_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'tag_name'=>$userNote->tag_name];
	$tags = new NoteTag($save_tags_args);
	$save_tags = $tags->validate();

	$errors_array = array_merge($save_note, $save_subject, $save_tags);

	if(empty($errors_array)){
		$flag_db_error = 0;
		$save_note = $userNote->save($validation=false);
		if($save_note == true){
			$save_subject = $subject->save($validation=false);
			if($save_subject == true){
				$save_tags = $tags->save($validation=false);
				if($save_tags != true){
					$flag_db_error = 1;
				}
			}else{
				$flag_db_error = 1;
			}
			if($flag_db_error == 0){
				// all note data save in all tables successfully
				// logging
				$logger_message = "ID=>'{$userNote->user_id}' " . 'has created new note of note-ID => ' . "'{$userNote->note_id}'" . ' at ' . date(DATE_COOKIE);
				$logger->get_activity_logger('CREATE NOTE', $logger_message);
				// send response back to browser
				$send_arr = array('type'=>'create_note','result'=>'true', 'note_id'=> $userNote->note_id);
				echo json_encode($send_arr);
				exit;
			}
		}else{
		// note couldn't save
		// logging
		$logger_message = "ID=>'{$userNote->user_id}' " . 'can not be able to create note at ' . date(DATE_COOKIE);
		$logger->get_error_logger('CREATE NOTE', $logger_message);
		// send response back to browser
		$send_arr = array('type'=>'create_note','result'=>'false','errors'=> 'Can not be able to create your note');
		echo json_encode($send_arr);
		exit;
	}}else{
		// There are form data errors in notes.
		$send_arr = array('type'=>'create_note','result'=>'false','errors'=> $errors_array, 'form_error'=>true);
		echo json_encode($send_arr);
		exit;
	}
	
	

}
 ?>