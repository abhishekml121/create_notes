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
	if(!is_valid_GET_keys(array_keys($args), ['username_or_email', 'password'])){
		echo json_encode(array('type'=>'user_login', 'data_valid' => 'false'));
		exit;
	}

	$username = $args['username_or_email'] ?? '';
  	$password = $_POST['password'] ?? '';
  	$errors = [];

	// Validations
	if(is_blank($username)) {
	  $errors['username_email'] = "Email/Username cannot be blank.";
	}
	if(is_blank($password)) {
	  $errors['password'] = "Password cannot be blank.";
	}

	// if there were no errors, try to login
	if(empty($errors)) {
		$user = new User($args);
	  	$finding = $user->find_by_username_or_email();
	  	if($finding != false && $finding->verify_password($args['password'])) {
	  		// Mark admin as logged in
			$session->login($finding);
				
	  		// logging activity
	  		$usernameORemail = $user->username ?? $user->email;
	  		$logger_message = "'{$usernameORemail}' " . 'has loggedin by ID = ' . $finding->id . ' at ' . date(DATE_COOKIE);
	  		$logger->get_activity_logger('LOGIN', $logger_message);
	  		$redirect_url = url_for('/user/notes');
	  		$send_arr = array('type'=>'user_login','result'=>'true', 'redirect_url'=>$redirect_url);
	  		echo json_encode($send_arr);
	  	}else{
	  		// username not found or password does not match
	  		$errors['username_email_wrong'] = "Username or password is not correct.";
	  		$send_arr = array('type'=>'user_login','result'=>'false','errors'=> $errors);
	  		$logger_message = 'Entered username/email => '."'{$args['username_or_email']}'" . ' isn\'t correct' . ' at ' . date(DATE_COOKIE);
	  		// logging 
	  		$logger->get_error_logger('LOGIN-ERROR', $logger_message);
	  		echo json_encode($send_arr);
	  	}
	}else{
		$send_arr = array('type'=>'user_login','result'=>'false','errors'=> $errors);
		echo json_encode($send_arr);
	}
}


 ?>
