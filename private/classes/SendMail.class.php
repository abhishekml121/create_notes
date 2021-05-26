<?php
class SendMail
{
	protected $header;
	public  $company_name;
	public  $company_email;

	public function __construct($args=[]){
		$this->company_name = $args['company_name'];
		$this->company_email = $args['company_email'];
	}

	protected function set_content_header(){
	// Set content-type header for sending HTML email 
	$headers = "MIME-Version: 1.0" . "\r\n"; 
	$headers .= "Content-type:text/html; charset=utf-8" . "\r\n"; 
	 
	// Additional headers 
	// $headers .= 'From: '. $this->company_name .'<'. $this->company_email .'>' . "\r\n";
	$headers .= 'From: ' . $this->company_email . "\r\n" .
			    'Reply-To:' . $this->company_email . "\r\n" .
			    'X-Mailer: PHP/' . phpversion();
	// print_r()
	// $headers .= 'Cc: bbcarljohnson@gmail.com' . "\r\n"; 
	// $headers .= 'Bcc: bbcarljohnson@gmail.com' . "\r\n";
	return $headers;
}

public function send_mail($args=[]){
	// global $logger;

    $header = $this->set_content_header();
    // $header = static::set_content_header($args2=['from_name' => 'AITH', 'from'=>'bbcarljohnson@gmail.com']);
     $send = mail($args['email_id'], $args['subject'], $args['message'],$header);

            if($send != true ){
            	//$logger->get_error_logger(extract_short_path(__FILE__), 'Mail NOT sent due to : '. error_get_last()['message'] .' on '.date("j F Y, g:i:s A") . ' on line '. __LINE__);
                return false;
            }
            return true;    
  }

}
