<?php 
class messageToDeveloper extends DatabaseObject {
	static protected $table_name = "message_from_users";
  static protected $db_columns = ['id', 'email','message', 'date', 'time'];

  public $id;
  public $email;
  public $message;
  public $date;
  public $time;

  public function __construct($args=[]) {
    $this->email = $args['email'] ?? '';
    $this->message = $args['message'] ?? '';
    $this->date = date('Y-m-j');
    $this->time = date('H:i:s');
  }

public function validate() {
  $this->errors = [];
  
  if(is_blank($this->email)) {
    $this->errors['email'] = "Email or mobile number cannot be blank.";
  }/*elseif(!has_valid_email_format($this->email)) {
    $this->errors['email'] = "Email is not correct.";
  }*/

  if(is_blank($this->message)) {
    $this->errors['message'] = "message cannot be blank.";
  }elseif(!has_length($this->message, ['min' => 10, 'max'=>26000])) {
    $this->errors['message'] = "Message must have minimum 10 and maximum 26000 characters.";
  }
  return $this->errors;
}
}
 ?>