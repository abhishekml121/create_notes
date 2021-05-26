<?php 
class ForgetPassword extends DatabaseObject {
	static protected $table_name = "forget_password_otp";
  static protected $db_columns = ['id', 'otp', 'email', 'ip_address', 'date', 'time'];

  public $id;
  public $email;  
  public $otp;  
  public $ip_address; 
  public $date;
  public $time;

  public function __construct($args=[]) {
    $this->email = $args['email'] ?? '';
    $this->otp = n_digit_OTP(6);
    $this->ip_address = $_SERVER['REMOTE_ADDR'];
    $this->date = date('Y-m-j');
    $this->time = date('H:i:s');

  }

public function validate() {
  $this->errors = [];
  
  if(is_blank($this->email)) {
    $this->errors['email'] = "Email cannot be blank.";
  }elseif(!has_valid_email_format($this->email)) {
    $this->errors['email'] = "Email is not correct.";
  }elseif($this->find_by_email($this->email) === false) {
    $this->errors['email'] = "No account is registered with {$this->email}";
  }elseif ($checking = $this->is_email_present_in_otp_table($this->email)) {
    if($checking !== false && $this->id == null){
      array_shift($checking)->delete();
    }
  }
  return $this->errors;
}

public function find_by_email($email='') {
  if(!is_blank($email)){
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . self::$database->escape_string($email) . "'";
  }
  $obj_array = static::find_by_sql($sql);
  if(!empty($obj_array)) {
    return true;
  } else {
    return false;
  }
}

public function is_email_present_in_otp_table($email='') {
  if(!is_blank($email)){
    $sql = "SELECT * FROM " . static::$table_name . ' ';
    $sql .= "WHERE email='" . self::$database->escape_string($email) . "'";
  }
  $obj_array = static::find_by_sql($sql);
  if(!empty($obj_array)) {
    return $obj_array;
  } else {
    return false;
  }
}


}
 ?>
