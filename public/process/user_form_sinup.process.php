<?php 
// sleep(1);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../private/config/initialize.php');
if(is_ajax_post_request()){
	$args = $_POST;
	// ? we'are only getting those keys which are allowed.
	if(!is_valid_GET_keys(array_keys($args), ['username', 'password', 'confirm_password'])){
		echo json_encode(array('type'=>'user_reg', 'data_valid' => 'false'));
		exit;
	}

	$user = new User($args);
	$result = $user->save();

	if($result === true){
		//saving avator url
		$user->save_user_avator($user->id);
		// Mark admin as logged in
		$usernameORemail = $user->username ?? $user->email;
		$logger_message = "'{$usernameORemail}' " . 'has registered by ID = ' . $user->id . ' at ' . date(DATE_COOKIE);
		$logger->get_activity_logger('SINUP', $logger_message);
		$session->login($user);
		$redirect_url = url_for('/user/notes');
		$send_arr = array('type'=>'user_reg','result'=>'true', 'redirect_url'=>$redirect_url);
		echo json_encode($send_arr);
	}else{
		$send_arr = array('type'=>'user_reg','result'=>'false','errors'=> $user->errors);
		echo json_encode($send_arr);
	}
}


 ?>
