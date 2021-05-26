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
	$user_email = h(trim($args['user_email_id'])) ?? '';
	$subscribe = new subscribed_User(['email'=>$user_email]);
	$subscribe_result = $subscribe->save();

	// If data has been saved in database then send email
	if($subscribe_result == true){
		// prepare for sending email
		$setup_email = new SendMail(['company_name'=>SITE_NAME,'company_email'=>COMPANY_EMAIL]);
		$email_subject = 'User subscription in save notes';
		$email_HTML = new EmailHTML;
		$send_mail = $setup_email->send_mail(['email_id'=>$user_email,'subject'=> $email_subject, 'message'=>$email_HTML->email_user_subscription()]);
		if($send_mail !== true){
			// logging 
			$logger->get_error_logger('EMAIL-ERROR', 'email not send for user subscription '. date(DATE_COOKIE));
		}
		$send_arr = array('type'=>'user_subscription','result'=>'true', 'message'=>'Thank you for subscription. You will get notifications from now.');
	}else{
		// data doesn't save in DB
		//$logger->get_error_logger('SAVE-ERROR', 'Unable to save subscription email in database'. date(DATE_COOKIE));
		$send_arr = array('type'=>'user_subscription','result'=>'false','errors'=> $subscribe->errors);
	}
	echo json_encode($send_arr);	
}


 ?>
