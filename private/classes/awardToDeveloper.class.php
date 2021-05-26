<?php
class awardToDeveloper extends DatabaseObject
{
  protected static $table_name = "award_to_developer";
  protected static $db_columns = ['id', 'award_id', 'number_of_time', 'ip_address', 'date', 'time'];

  public $id;
  public $award_id;
  public $number_of_time;
  public $ip_address;
  public $date;
  public $time;

  public function __construct($args = [])
  {
    $this->award_id = $args['award_id'] ?? '';
    $this->ip_address = $_SERVER['REMOTE_ADDR'];
    $this->date = date('Y-m-j');
    $this->time = date('H:i:s');
  }

  public function validate()
  {
    $this->errors = [];

    if (is_blank($this->award_id)) {
      $this->errors['award'] = "Please choose one of these award";
    }
    return $this->errors;
  }

  public function find_by_email($email = '')
  {
    if (!is_blank($email)) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE email='" . self::$database->escape_string($email) . "'";
    }
    $obj_array = static::find_by_sql($sql);
    if (!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }
}
