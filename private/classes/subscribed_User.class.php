<?php 
class subscribed_User extends DatabaseObject {
	static protected $table_name = "subscribed_users";
  static protected $db_columns = ['id', 'email', 'date', 'time'];

  public $id;
  public $email;  
  public $date;
  public $time;

  public function __construct($args=[]) {
    $this->email = $args['email'] ?? '';
    $this->date = date('Y-m-j');
    $this->time = date('H:i:s');
  }

public function validate() {
  $this->errors = [];
  
  if(is_blank($this->email)) {
    $this->errors['email'] = "Email cannot be blank.";
  }elseif(!has_valid_email_format($this->email)) {
    $this->errors['email'] = "Email is not correct.";
  }elseif($this->find_by_email($this->email) !== false) {
    $this->errors['email'] = "Entered email ID has already registered. Try another.";
  }
  return $this->errors;
}

public function find_by_email($email='') {
  if(!is_blank($email)){
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE email='" . self::$database->escape_string($email) . "'";
  }
  $obj_array = static::find_by_sql($sql);
  if(!empty($obj_array)) {
    return array_shift($obj_array);
  } else {
    return false;
  }
}


}
 ?>
