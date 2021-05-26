<?php 
// sleep(2);
function is_ajax_request() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}
// If this is not AJAX request then stop executing.
if(!is_ajax_request()) { exit; }
require_once('../../private/config/initialize.php');
if(is_get_request()){
	$args = $_GET;
	function award_image(){
		global $args;
		switch ($args['award_id']) {
			case '0':
				return '<i class="material-icons md-36 gold-trophy">emoji_events</i>';
				break;
			case '1':
				return '<i class="material-icons md-36 silver-trophy">emoji_events</i>';
				break;
			case '2':
				return '<i class="material-icons md-36 bronze-trophy">emoji_events</i>';
				break;			
			default:
				break;
		}
	}
	$award = new awardToDeveloper($args);
	$result = $award->save();

	// If data has been saved in database then send email
	if($result == true){
		// prepare for sending email
		$send_arr = array('type'=>'send_award_to_dev','result'=>'true', 'message'=>'Thank you for giving me the award '. award_image() .  'God bless you !');
	}else{
		$send_arr = array('type'=>'send_award_to_dev','result'=>'false','errors'=> $award->errors);
	}
	echo json_encode($send_arr);	
}


 ?>