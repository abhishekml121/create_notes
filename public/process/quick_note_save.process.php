<?php 
// sleep(2);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../private/config/initialize.php');
if(is_ajax_post_request()){
	$args = $_POST;
	$is_note_id_present = NULL;
	if(isset($args['is_private'])){
		$args['is_editable'] = 0;
		$args['is_private'] = 1;
		$args['is_paswd_check'] = 0;
	}else{
		$args['is_private'] = 0;
		if(isset($args['is_paswd_check'])){
			$args['is_paswd_check'] = 1;
		}else{
			$args['is_paswd'] = '';
		}
	}
	if(!array_key_exists('is_editable', $args)){
		$args['is_editable'] = 0;
	}

	// fa($args, true);//
	if(isset($args['note_id']) && has_presence($args['note_id'])){
		$args['note_id'] = UserQuickNote::filter_quick_note_id($args['note_id']);
		$is_note_id_present = true;
	}else{
		$args['note_id'] = '';
	}
	$quick_note = new UserQuickNote($args);
	$message = 'Note created successfuly';
	// Do update if current user is the admin of current accesed note. 
	if($is_note_id_present){
		$is_admin = $quick_note->is_admin($args['note_id']);
		if($is_admin === true){
			$result = $quick_note->need_update_for_note($args['note_id'], $args);
			// [ IMP ] strict checking must be on (i.e; === or !==)
			if($result !== true){
				$quick_note = $result; // user has errors in form data.
			}else{
				// note has updated
				$message = 'Note updated successfuly';
			}
		}else if($is_admin === false){ // must check strict comparison
			
			// if above is false. It means note_id is found in DB but current user +
			// is not admin. So check DB attribute `is_private` and `is_editable`.
			// If is_editable == 1 then do not create new note, just update the current note by using + 
			// `note_html_others` and `note_markdown_others`.
			$result = $quick_note->update_current_note_by_other($args);
			if($result === true){ // must be strict type checking on
				// note has updated
				$message = 'Note updated successfuly';
			}else if($result === NULL){
				// create new note with new ID because is_editable == 0 for current note.
				$result = $quick_note->save();
			}else if(is_array($result)){
				// form can not update due to form errors.
			}
		}else{
			$result = $quick_note->save();
		}
	}else{
		$result = $quick_note->save();
	}

	if($result === true){
		$send_arr = array('type'=>'quick_note','result'=>'true', 'message'=>$message, 'note_data'=>$quick_note);
	}else{
		$send_arr = array('type'=>'quick_note','result'=>'false','errors'=> $quick_note->errors);
	}
	echo json_encode($send_arr);	
}
 ?>
