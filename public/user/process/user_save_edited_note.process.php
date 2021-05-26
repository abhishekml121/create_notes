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
		$send_arr = array('type'=>'edit_note','result'=>'false','login'=>'false');
		echo json_encode($send_arr);
		exit;
	}

	$args = $_POST;
	$user_id = h((int) $_COOKIE['user_id']);
	//validating note.
	$sql = 'SELECT * from notes where note_id='. "'". h($_SESSION['note_id']). "'".' AND user_id=' . "'". $user_id ."'";
	$userNote_array = UserNote::find_by_sql($sql);
	$userNote = array_shift($userNote_array);
	$userNote->merge_attributes($args);
	$save_note = $userNote->validate();

	//validating subject.
	$sql = 'SELECT * from notes_subject where note_id='. "'". h($_SESSION['note_id']). "'".' AND user_id=' . "'". $user_id ."'";
	$save_subject_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'subject_name'=>$userNote->subject_name];
	$subject_array = NoteSubject::find_by_sql($sql);
	$subject = array_shift($subject_array);
	$subject->merge_attributes($save_subject_args);
	$save_subject = $subject->validate();

	//validating tags.
	$save_tags_args = ['user_id'=>$userNote->user_id,'note_id'=>$userNote->note_id, 'tag_name'=>$userNote->tag_name];
	$tag = new NoteTag($save_tags_args);
	$save_tags = $tag->validate();
	$errors_array = array_merge($save_note, $save_subject, $save_tags);

	if(empty($errors_array)){
		$flag_db_error = 0;
		$save_note = $userNote->save($validation=false);
		if($save_note == true){
			$save_subject = $subject->save($validation=false);
			if($save_subject == true){
				/***
				 * TODO --
				 * we're directly deleting tags on edit note request.
				 * but this is note good because "on every edited note there will create a new row with the new SR NO.".
				 * So to stop this we have to just update those rows of tags instead of creating new rows after deleting previous rows.
				 */
				$tag->delete_tag_for_update();
				$save_tags = $tag->save($validation=false);
				if($save_tags != true){
					$flag_db_error = 1;
				}
			}else{
				$flag_db_error = 1;
			}
			if($flag_db_error == 0){
				// all note data save in all tables successfully
				// logging
				$logger_message = "ID=>'{$userNote->user_id}' " . 'has edited note of note-ID => ' . "'{$userNote->note_id}'" . ' at ' . date(DATE_COOKIE);
				$logger->get_activity_logger('EDITED NOTE', $logger_message);
				// send response back to browser
				$send_arr = array('type'=>'edit_note','result'=>'true', 'note_id'=> $userNote->note_id);
				echo json_encode($send_arr);
				exit;
			}
		}else{
		// note couldn't save
		// logging
		$logger_message = "ID=>'{$userNote->user_id}' " . 'could not be able to save note after edit by note-ID => ' . "'{$userNote->note_id}'" . ' at ' . date(DATE_COOKIE);
		$logger->get_error_logger('EDITED NOTE', $logger_message);
		$send_arr = array('type'=>'edit_note','result'=>'false','errors'=> 'Could not be able to save your note');
		echo json_encode($send_arr);
		exit;
	}}else{
		// There are form data errors in notes.
		$send_arr = array('type'=>'edit_note','result'=>'false','errors'=> $errors_array, 'form_error'=>true);
		echo json_encode($send_arr);
		exit;
	}

}
 ?>
