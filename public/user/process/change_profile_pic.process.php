<?php 
//sleep(2);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../../private/config/initialize.php');
if(is_get_request()){
	$avator_type = h($_GET['d']);
	$user_id = isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : null;
	$update_profile = User::chage_user_profile_pic($user_id, $avator_type);
	if($update_profile === true){
	$send_arr = array('type'=>'change_profile_pic','result'=>'true');
}else{
	$send_arr = array('type'=>'change_profile_pic','result'=>'false','errors'=> 'something wnet wrong. Please try again later!.');
}
	echo json_encode($send_arr);
}


 ?>
