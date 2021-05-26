<?php 
sleep(2);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../private/config/initialize.php');
if(is_ajax_post_request()){
	$args = $_POST;
	$user_email = h(trim($args['contact_info'])) ?? '';
	$message = new messageToDeveloper(['email'=>$user_email, 'message'=>$args['msg']]);
	$message_result = $message->save();

	// If data has been saved in database then send email
	if($message_result == true){
		// prepare for sending email
		$setup_email = new SendMail(['company_name'=>SITE_NAME,'company_email'=>COMPANY_EMAIL]);
		$email_subject = 'User message from save notes';
		$send_mail = $setup_email->send_mail(['email_id'=>COMPANY_EMAIL,'subject'=> $email_subject, 'message'=>message_to_dev_for_email(['email_message'=>nl2br(htmlspecialchars($message->message)), 'sender'=>$message->email])]);
		if($send_mail !== true){
			// logging 
			$logger->get_error_logger('EMAIL-ERROR', 'email not send for user sending message to developer by EMAIL ID ' ."{$message->email} " . date(DATE_COOKIE));
		}
		$send_arr = array('type'=>'message_to_developer','result'=>'true', 'message'=>'Thank you for your message. I will contact to you soon !');
	}else{
		// data doesn't save in DB
		//$logger->get_error_logger('SAVE-ERROR', 'Unable to save subscription email in database'. date(DATE_COOKIE));
		$send_arr = array('type'=>'message_to_developer','result'=>'false','errors'=> $message->errors);
	}
	echo json_encode($send_arr);	
}


 ?>
