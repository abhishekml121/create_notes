<?php 
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_get_request()){
	$args = $_GET;
	if(array_key_exists('suggestion_for', $args)){
		// This if block using in create_note.php and edit_note.php for input field in subject_name.
		if($args['suggestion_for'] == 'subject_name'){
			$search_subjects = NoteSubject::get_html_for_s_sugg_subject(h(trim($args['input']))); // array
			if($search_subjects != false){
				$send_arr = array('type'=>'search_suggestion_subject','result'=>'true', 'html_data'=>$search_subjects);
			}else{
				$send_arr = array('type'=>'search_suggestion_subject','result'=>'false');
			}// for subject_name ends
		}elseif ($args['suggestion_for'] == 'notes') {
			$user_id = isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : null;
			$access_type = $args['access_type'] ?? 'Public';
			$access_for = $args['access_for'] ?? null;
			if(($access_for != null) && ($access_for != 'your post' &&  $access_for != 'global')){
				$access_for = 'your post';
			}
			$notes = UserNote::get_note_suggestion_html(['access_type'=>$access_type,'user_id'=>$user_id,'topic'=>h($args['input']),'access_for'=>h($access_for)]);
			if($notes != false){
				$send_arr = array('type'=>'search_suggestion_notes','result'=>'true', 'html_data'=>$notes);
			}else{
				$send_arr = array('type'=>'search_suggestion_notes','result'=>'false');
			}
		}// for notes ends
	}

	echo json_encode($send_arr);
}

 ?>
