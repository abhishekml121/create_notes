<?php 
// sleep(1);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_get_request()){
	$current_page = $_GET['page'] ?? 1; // it will be like 1,2,3,4 etc.
	$per_page = 5; // increase this for getting more results
	$subject = new UserSubject;
	$pagination = new Pagination($current_page, $per_page);
	$args = ['limit'=>$per_page, 'offset'=>$pagination->offset()];
	$u_subject = $subject->get_subject_html($args);

	if($u_subject !== false){
		$send_arr = array('type'=>'get_user_subjects','result'=>'true','user_subject_html'=> $u_subject);
		if($current_page == 1){
			$send_arr['top_nav'] = htmlMarkup::nav_bar();
		}
	}elseif($current_page == 1 && $u_subject == false){
		$send_arr = array('type'=>'get_user_subjects','result'=>'false','message'=> htmlMarkup::zero_note_message());
	}elseif($u_subject === false){
		$send_arr = array('type'=>'get_user_subjects','result'=>'false','message'=>'No more subjects to show');
	}else{
		$send_arr = array('type'=>'get_user_subjects','result'=>'false','error'=> 'Can not load subjects');
	}

	echo json_encode($send_arr);

}


 ?>