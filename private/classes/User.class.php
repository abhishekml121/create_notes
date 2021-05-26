<?php 
class User extends DatabaseObject {
	static protected $table_name = "users";
  static protected $db_columns = ['id', 'username', 'email', 'hashed_password','user_avator', 'avator_type', 'date', 'time'];

  public $id;
  public $username;
  public $user_avator;
  public $avator_type = 'monsterid'; //default is 'monsterid'
  public $email;
  public $username_or_email;
  protected $hashed_password;
  public $password;
  public $confirm_password;
  public $date;
  public $time;
  protected $password_required = true;

  public function __construct($args=[]) {
    $this->username = $args['username'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
    $this->username_or_email = $args['username_or_email'] ?? '';
    $this->date = date('Y-m-j');
    $this->time = date('H:i:s');
  }

  protected function set_hashed_password() {
    $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function save_user_avator($user_id){
    $username = (has_presence($this->username)) ? $this->username : $this->email;
    $gravator_url = get_gravatar(($username . $this->id),$s = 60, $d = 'monsterid', $r = 'g');
    $sql = 'UPDATE ' . static::$table_name;
    $sql .=" SET user_avator='". self::$database->escape_string($gravator_url) . "'";
    $sql .= ' WHERE id='. $user_id;
    $result = self::$database->query($sql);
    return $result;
  }

  public static function get_avator($user_id = ''){
    $user_id = ($user_id == '') ? (int) $_COOKIE['user_id'] : $user_id;
    $sql = 'SELECT user_avator FROM ' . static::$table_name;
    $sql .= " WHERE id='". self::$database->escape_string($user_id). "'";
    return static::find_by_sql_without_object($sql);
  }
  public static function get_avator_type($user_id){
    $user_id = $user_id ?? (int) $_COOKIE['user_id'];
    $sql = 'SELECT avator_type FROM ' . static::$table_name;
    $sql .= " WHERE id='". self::$database->escape_string($user_id). "'";
    return static::find_by_sql_without_object($sql);
  }

  private static function check_avator_type($avator_type){
    if(!has_presence($avator_type)){
      return false;
    }else if($avator_type != 'monsterid' && $avator_type != 'identicon' && $avator_type != 'wavatar'){
      return false;
    }
    return true;
  }
  public static function chage_user_profile_pic($user_id = '', $avator_type='monsterid'){
    if(static::check_avator_type($avator_type) === false){
      return false;
    }
    $previous_avator_type = self::get_avator_type($user_id)['avator_type'];
    $previous_avator_url = self::get_avator($user_id)['user_avator'];
    // var_dump($previous_avator_type);
    // var_dump($previous_avator_url);
    if(strpos($previous_avator_url, $previous_avator_type)){
      $update_avator_url = str_replace($previous_avator_type, $avator_type, $previous_avator_url);
    }else{
      $avator_type = 'monsterid';
      $update_avator_url = str_replace($previous_avator_type, $avator_type, $previous_avator_url);
      // var_dump($update_avator_url);
    }

    $sql = 'UPDATE ' . static::$table_name;
    $sql .=" SET avator_type= '". self::$database->escape_string($avator_type). "',";
    $sql .=" user_avator='". self::$database->escape_string($update_avator_url). "'";
    $sql .= " WHERE id='". self::$database->escape_string($user_id). "'";
    return self::$database->query($sql);
  }

  public function verify_password($password) {
    return password_verify($password, $this->hashed_password);
  }

  protected function create($validation = true) {
    $this->set_hashed_password();
    return parent::create();
  }

  protected function update() {
    if($this->password != '') {
      $this->set_hashed_password();
      // validate password
    } else {
      // password not being updated, skip hashing and validation
      $this->password_required = false;
    }
    return parent::update();
  }

  public function find_by_username_or_email() {
      if(is_blank($this->username_or_email)){
        return;
      }
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE email='" . self::$database->escape_string($this->username_or_email) . "'";
      $sql .= " OR username='" . self::$database->escape_string($this->username_or_email) . "'";
    
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

public function validate() {
  $this->errors = [];
  if(is_blank($this->email) &&  is_blank($this->username)) {
    $this->errors['username'] = "Username cannot be blank.";
  }elseif (has_valid_email_format($this->username)) {
    $this->email=$this->username;
    $this->username = '';
    if (!$this->has_unique_username($this->id ?? 0)) {
        $this->errors['username'] = "Entered email has already registered. Try another.";
      }
  }elseif ($this->username != '' && !has_length($this->username, array('min' => 4, 'max' => 150))) {
    $this->errors['username'] = "Username must be between 4 and 30 characters.";
  }elseif (!$this->has_unique_username($this->id ?? 0)) {
    $this->errors['username'] = "Entered username has already registered. Try another.";
  }

  if($this->password_required) {
    if(is_blank($this->password)) {
      $this->errors['password'] = "Password cannot be blank.";
    } elseif (!has_length($this->password, array('min' => 4))) {
      $this->errors['password'] = "Password must contain 4 or more characters";
    } elseif(is_blank($this->id) && !is_blank($this->password) && !is_valid_paswd($this->password)){
      $this->errors['password'] = 'Password must contains only word characters [<b>0-9A-Za-z_</b>]';
    }


    if(is_blank($this->confirm_password)) {
      $this->errors['confirm_password'] = "Confirm password cannot be blank.";
    } elseif ($this->password !== $this->confirm_password) {
      $this->errors['confirm_password'] = "Password and confirm password must match.";
    }
  }

  return $this->errors;
}

public function has_unique_username($current_id="0") {
  $username = is_blank($this->username) ? $this->email : $this->username;
  
    $user = self::find_by_username($username);
    if($user === false || $user->id == $current_id) {
      // is unique
      return true;
    } else {
      // not unique
      return false;
    }
  }

public static function find_by_username($username='') {
  $sql = "SELECT * FROM " . static::$table_name . " ";
  if(!is_blank($username)){
    $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
    $sql .= " OR email='" . self::$database->escape_string($username) . "'";
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
