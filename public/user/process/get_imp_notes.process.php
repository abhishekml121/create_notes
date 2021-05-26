<?php 
// sleep(2);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_get_request()){
	$current_page = $_GET['page'] ?? 1; // it will be like 1,2,3,4 etc.
	$per_page = 5; // increase this for getting more results
	$note = new UserNote;
	$pagination = new Pagination($current_page, $per_page);
	$args = ['limit'=>$per_page, 'offset'=>$pagination->offset()];
	// getting notes objects
	$notes_obj = $note->get_user_imp_notes_by_offset($args['limit'], $args['offset']);
	if(!empty($notes_obj)){
		$u_note = $note->get_note_topic_html($notes_obj, $_GET['count']);
	}else{
		$u_note = false;
	}

	if($u_note !== false){
		$send_arr = array('type'=>'get_imp_notes_title','result'=>'true','user_notes_html'=> $u_note);
		if($current_page == 1){
			$send_arr['top_nav'] = htmlMarkup::nav_bar();
		}
	}elseif($current_page == 1 && $u_note == false){
		$send_arr = array('type'=>'get_imp_notes_title','result'=>'false','message'=> htmlMarkup::no_imp_note_message());
	}elseif($u_note === false){
		$send_arr = array('type'=>'get_imp_notes_title','result'=>'false','message'=>'No more notes to show');
	}else{
		$send_arr = array('type'=>'get_imp_notes_title','result'=>'false','error'=> 'Can not load notes');
	}

	echo json_encode($send_arr);

}


 ?>