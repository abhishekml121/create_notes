<?php 
// sleep(2);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../private/config/initialize.php');
//var_dump($_SERVER['REQUEST_METHOD']);
if(is_ajax_post_request()){
	$args = $_POST;

	if(is_valid_GET_keys(array_keys($args), ['email'])){
	$user_email = h(trim($args['email'])) ?? '';
	$forget_paswd = new ForgetPassword(['email'=>$user_email]);
	$result = $forget_paswd->save();

	// If data has been saved in database then send email
	if($result == true){
		// prepare for sending email
		$setup_email = new SendMail(['company_name'=>SITE_NAME,'company_email'=>COMPANY_EMAIL]);
		$email_subject = 'OTP for changing account password in save notes';
		$email_HTML = new EmailHTML;
		$send_mail = $setup_email->send_mail(['email_id'=>$user_email,'subject'=> $email_subject, 'message'=>$email_HTML->email_user_otp($forget_paswd->otp, $user_email)]);
		if($send_mail !== true){
			// logging 
			$logger->get_error_logger('EMAIL-ERROR', 'email not send for OTP in action of changing user password '. date(DATE_COOKIE));
		}else{
			// storing the OTP id of database in session.
			// so whenever a user write OTP which is sent to their email It will first grab the $_SESSION['otp_id'] and match with the OTP id stored in database.
			$_SESSION['otp_id'] = $forget_paswd->id;
		}
		$send_arr = array('type'=>'user_changning_paswd','result'=>'true', 'message'=>'6 digits OTP has sent in '. $user_email, 'otp_form'=>htmlMarkup::otp_form($user_email));
	}else{
		// show errors
		$send_arr = array('type'=>'user_changning_paswd','result'=>'false','errors'=> $forget_paswd->errors);
	}
	echo json_encode($send_arr);
	exit; // write exit is must.
	// if block __ENDS for sending otp in email
}elseif (is_valid_GET_keys(array_keys($args), ['otp'])) {
	if(isset($_SESSION['otp_id'])){
		$otp = ForgetPassword::find_by_id(h($_SESSION['otp_id']));
		if($otp != false){
			$checking_equality_in_otp = (int)$args['otp'] === (int)$otp->otp;
			if($checking_equality_in_otp === true){
				$send_arr = array('type'=>'user_otp_for_changning_paswd','result'=>'true','new_paswd_form'=>htmlMarkup::new_paswd_form());
			}else{
				$send_arr = array('type'=>'user_otp_for_changning_paswd','result'=>'false','errors'=>['otp'=>'OTP is not correct.']);
			}
		}else{
			$send_arr = array('type'=>'user_otp_for_changning_paswd','result'=>'false','errors'=>['err'=>'Something went wrong. Try to refresh this page !']);
		}
	}else{
		// OTP ID not found in session.
		$send_arr = array('type'=>'user_otp_for_changning_paswd','result'=>'false','errors'=> ['err'=>'Your session has expired. Try to refresh this page !']);
		
	}
	echo json_encode($send_arr);
	exit; //  write exit is must
	//elseif block __ENDS for checking inputed OTP by user
} elseif (is_valid_GET_keys(array_keys($args), ['password', 'confirm_password'])) {
	if(isset($_SESSION['otp_id'])){
		$otp = ForgetPassword::find_by_id(h($_SESSION['otp_id']));
		if($otp){
			$user_email = h(trim($otp->email));
			$user = User::find_by_username($user_email);
			if($user){
				$user->merge_attributes($args);
				$result = $user->save();
				if($result == true) {
					// prepare for sending email
					$setup_email = new SendMail(['company_name'=>SITE_NAME,'company_email'=>COMPANY_EMAIL]);
					$email_subject = 'Password changed successfully in save notes';
					$email_HTML = new EmailHTML;
					$send_mail = $setup_email->send_mail(['email_id'=>$user_email,'subject'=> $email_subject, 'message'=>$email_HTML->paswd_changed_successfully($user_email)]);
					if($send_mail !== true){
						// logging 
						$logger->get_error_logger('EMAIL-ERROR', 'email did not send for informing the message of changed account password successfuly to ' . $user_email .' '. date(DATE_COOKIE));
					}
					$send_arr = array('type'=>'user_account_paswd_change','result'=>'true', 'message'=>'Password has changed successfuly for '. $user_email, 'redirect_to'=>url_for('/'));
				}else{
					// show errors
					$send_arr = array('type'=>'user_account_paswd_change','result'=>'false','errors'=> $user->errors);
				}
			}else{
				// user not found in `users` database.
				$send_arr = array('type'=>'user_account_paswd_change','result'=>'false','errors'=>['err'=> 'Something went wrong. Try to refresh this page !']);
			}
		}else{
			// OTP ID not found in database.
			$send_arr = array('type'=>'user_account_paswd_change','result'=>'false','errors'=> ['err'=>'Something went wrong. Try to refresh this page !']);
		}
	}else{
		// OTP ID not found in session.
		$send_arr = array('type'=>'user_account_paswd_change','result'=>'false','errors'=> ['err'=>'Your session has expired. Try to refresh this page !']);
	}
}else{
	// hacking attempt
	$send_arr = array('type'=>'user_account_paswd_change','result'=>'false','errors'=> ['err'=>'Something went wrong. Try to refresh this page !'], 'site_location'=>url_for('/'));
}
echo json_encode($send_arr); // for account password changing
exit;
}elseif(is_get_request()) { // run only when it is GET request.
	// code for resend OTP
	if(isset($_SESSION['otp_id'])){
		$otp = ForgetPassword::find_by_id(h($_SESSION['otp_id']));
		if($otp != false){
			//saving new generating
			$user_email = h(trim($otp->email));
			$new_otp = n_digit_OTP(6);
			$otp->merge_attributes(['otp'=>$new_otp]);
			$result = $otp->save();
			if($result ==true) {
				// prepare for sending email
				$setup_email = new SendMail(['company_name'=>SITE_NAME,'company_email'=>COMPANY_EMAIL]);
				$email_subject = 'OTP for changing account password in save notes';
				$email_HTML = new EmailHTML;
				$send_mail = $setup_email->send_mail(['email_id'=>$user_email,'subject'=> $email_subject, 'message'=>$email_HTML->email_user_otp($new_otp, $user_email)]);
			if($send_mail !== true){
				// logging 
				$logger->get_error_logger('EMAIL-ERROR', 'email not send for OTP in action of changing user password '. date(DATE_COOKIE));
			}
			$send_arr = array('type'=>'user_resend_otp_for_changning_paswd','result'=>'true', 'message'=>'OPT sent successfuly to '. $user_email);
			}else{
				// show errors
				$send_arr = array('type'=>'user_resend_otp_for_changning_paswd','result'=>'false','errors'=> $otp->errors);
			}
		}else{
			// OTP ID row not found in DB
			$send_arr = array('type'=>'user_resend_otp_for_changning_paswd','result'=>'false','errors'=> ['err'=>'Something went wrong. Try to refresh this page !']);
		}
}else{
	// OTP ID not found in session.
	$send_arr = array('type'=>'user_resend_otp_for_changning_paswd','result'=>'false','errors'=> ['err'=>'Your session has expired. Try to refresh this page !']);
}
echo json_encode($send_arr);
exit;
}
