<?php 
class EmailHTML{
	public $site_name;
	public $site_address;
	private $header_html;
	private $footer_html;
	private $today_date;
	public function __construct(){
		$this->site_address = url_for('/');
		$this->site_name = SITE_NAME;
		$this->today_date = date(DATE_COOKIE);
		$this->header_html = <<<HEADER_HTML
		<html>
			<body style="font-size: 1rem;">
				<main style="max-width: 450px;">
				<header>
					<div style="text-align: right;">
						<a href="{$this->site_address}"><img src="https://i.ibb.co/LdWffPH/logo.png" style="width: 40px;"></a>
					</div>
				</header>
		HEADER_HTML;

		$this->footer_html = <<<FOOTER_HTML
				</main>
			</body>
		</html>
		FOOTER_HTML;
	}
	public function email_user_subscription(){
		$html = <<<HTML
		{$this->header_html}
				<h1>Thankyou for subscription</h1>
				<div style="font-size: 1.3em;">Now you will get notifications about new features in future.</div>

				<div style="font-size: 1em;margin-top: 5px">
					<span>Note : </span><span>If you did not subscribe us then it means someone (IP: {$_SERVER['REMOTE_ADDR']}) has given your email-ID by mistake.</span>
				</div>
				<div style="margin-top: 20px; font-size: 1.2em;">
					<i>{$this->today_date}</i><br>
					<i>Thankyou !</i><br>
					<i><a href="{$this->site_address}" style="display: inline-block;padding: 3px; color: #000000;background-color: #FFC107; text-decoration: none;">{$this->site_name}</a></i>
				</div>
				{$this->footer_html}
		HTML;
		return $html;
	}

	public function email_user_otp($otp, $email_ID){
		$html = <<<OTP_HTML
		{$this->header_html}
		<h2>Your OTP for email verification in action of changing password is :</h2>
		<div style="font-size: 2em;">{$otp}</div>
		<div style="font-size: 1em;margin-top: 15px">
			<span>Note : </span><span>If you did not give the email-ID {$email_ID} in <a href="{$this->site_address}">{$this->site_name}</a> then it means someone (IP address: {$_SERVER['REMOTE_ADDR']}) has given your email-ID by mistake.</span>
		</div>
		<div style="margin-top: 20px; font-size: 1.2em;">
			<i>{$this->today_date}</i><br>
			<i>Thankyou !</i><br>
			<i><a href="{$this->site_address}" style="display: inline-block;padding: 3px; color: #000000;background-color: #FFC107; text-decoration: none;">{$this->site_name}</a></i>
		</div>
		{$this->footer_html}
		OTP_HTML;
		return $html;
	}

	/* whenever a user changed their account password suucessfully
	* we will send him/her a message to the registered email-ID.
	*/
	
	public function paswd_changed_successfully($email_ID){
		$html = <<<HTML
		{$this->header_html}
		<h2>Your account password has changed successfully.</h2>
		<div style="font-size: 1em; border:1px solid #000000;padding:5px;">
			<h3 style="margin:0;margin-bottom:0.5em;">Account details of changed password:</h3>
			<table style="border: 1px solid #000000;border-collapse: collapse;">
				<tbody>
					<tr>
						<td style="border: 1px solid #000000;padding: 2px 5px;"><b>Email ID</b></td>
						<td style="border: 1px solid #000000;padding: 2px 5px;">{$email_ID}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="font-size: 0.9em;margin-top: 15px">
			<span>Note : </span><span>If you did not change the password in <a href="{$this->site_address}">{$this->site_name}</a> then it means someone (IP address: {$_SERVER['REMOTE_ADDR']}) has changed your password.</span>
			<p>To secure your account you must change your password of your gmail account whose email ID is {$email_ID} and then logout that gmail account from all devices and last step is to <a href="{$this->site_address}/forget_password">change the password</a> in <a href="{$this->site_address}">{$this->site_name}</a>.</p>
		</div>
		<div style="margin-top: 20px; font-size: 1.2em;">
			<i>{$this->today_date}</i><br>
			<i>Thankyou !</i><br>
			<i><a href="{$this->site_address}" style="display: inline-block;padding: 3px; color: #000000;background-color: #FFC107; text-decoration: none;">{$this->site_name}</a></i>
		</div>
		{$this->footer_html}
		HTML;
		return $html;
	}
	
}

?>
