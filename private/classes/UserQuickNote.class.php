<?php 
class UserQuickNote extends DatabaseObject {
	static protected $table_name = "quick_note";
  static protected $db_columns = ['id', 'note_id','is_private', 'is_editable', 'note_html', 'note_markdown','note_html_others', 'note_markdown_others','hashed_password','views','ip_address', 'date_others', 'time_others', 'date', 'time'];
  public $id;
  public $note_id;
  public $is_private;
  public $is_editable;
  public $note_html;
  public $note_markdown;
  public $note_html_others;
  public $note_markdown_others;
  public $views;
  public $ip_address;
  public $current_note_ip_address;
  public $date_others;
  public $time_others;
  public $date;
  public $time;
  public $is_admin = false;
  protected $hashed_password;
  public $password;
  protected $password_required = false;

  public function __construct($args=[]) {
    $this->note_id = $args['note_id'] ?? '';
    $this->note_html = $args['note_html'] ?? '';
    $this->note_markdown = $args['note_markdown'] ?? '';
    $this->password = $args['is_paswd'] ?? '';
    $this->is_private = $args['is_private'] ?? 0;
    $this->is_editable = $args['is_editable'] ?? 0;
    $this->ip_address = $_SERVER['REMOTE_ADDR'];
    $this->current_note_ip_address = NULL;
    $this->date = date('Y-m-j');
    $this->time = date('H:i:s');
  }

  public function get_hashed_paswd(){
    return $this->hashed_password;
  }

  protected function set_hashed_password() {
    $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
  }
  public function verify_password($password) {
    return password_verify($password, $this->hashed_password);
  }
  protected function create($validation = true) {
    if(isset($this->password) && $this->password != ''){
      $this->set_hashed_password();
    }
    return parent::create();
  }

  public function generate_unique_note_id(){
    $this->note_id = self::filter_quick_note_id(generate_random_id());
  }

  public static function delete_note($user_id, $note_id){
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE user_id='" . self::$database->escape_string($user_id) . "' ";
    $sql .= "AND note_id='" . self::$database->escape_string($note_id) . "' ";
    $sql .= "LIMIT 1";
  
    $result = self::$database->query($sql);
    return $result;
  }

  //increase the self_view note of a specific note
  public static function increase_self_view_note($user_id, $noteID){
    $count_previous_views = self::count_by_attr(['db_attr'=>'self_views', 'user_id'=>$user_id, 'noteID'=>$noteID]);
    if($count_previous_views == null){
      return false;
    }
      $sql ='UPDATE '. static::$table_name;
      $sql .=' SET self_views='. self::$database->escape_string(++$count_previous_views['self_views']);
      $sql .=' WHERE user_id ='. "'".self::$database->escape_string($user_id) ."'";
      $sql .=' AND note_id ='. "'".self::$database->escape_string($noteID) ."'";
      return self::$database->query($sql); // true or false
  }

  public function get_note_by_note_id($note_id){
    $sql = 'SELECT * FROM '. static::$table_name;
    $sql .= ' WHERE note_id = '. "'". self::$database->escape_string($note_id) ."'";
    return static::find_by_sql($sql);
  }
  public function is_note_id_exists($note_id){
    $sql = 'SELECT id, ip_address FROM '. static::$table_name;
    $sql .= ' WHERE note_id = '. "'". self::$database->escape_string($note_id) ."'";
    $result = static::find_by_sql_without_object($sql);
    if(!empty($result)){
      $this->current_note_ip_address = $result['ip_address'];
      return true;
    }else{
      return false;
    }
  }

  public function get_views($id){
    $sql = 'SELECT views FROM ' .static::$table_name;
    $sql .= ' WHERE id=' . "'".self::$database->escape_string($id) ."'";
    return static::find_by_sql_without_object($sql);
  }

  public static function filter_quick_note_id($note_id){
    $pattern = '/[\w]+/';
    preg_match_all($pattern, $note_id, $matched);
		return implode(array_shift($matched));
  }

  private function increase_views($id){
    $get_previous_views = (int) $this->get_views($id)['views'];
    $sql = 'UPDATE '. static::$table_name;
    $sql .= ' SET views='. self::$database->escape_string(++$get_previous_views);
    return self::$database->query($sql); // true or false
  }

  public function check_note_ip_address(){
    if(has_presence($this->ip_address)){
      $check = $_SERVER['REMOTE_ADDR'] === $this->current_note_ip_address;

      if($check){
        return true;
      }
      return false;
  }
  return false;
}

// if is_editable == 1 in DB then update the current note.
public function update_current_note_by_other($args){
  if(isset($args['note_id'])){
    $sql = 'SELECT is_private ,is_editable, hashed_password FROM ' .static::$table_name;
    $sql .= ' WHERE note_id=' . "'".self::$database->escape_string($args['note_id']) ."'";
    $result = static::find_by_sql_without_object($sql);
    if(!empty($result) && $result['is_editable'] == 1 && $result['is_private'] == 0){
      // do update in 'note_html_others' and 'note_markdown_others'
      $this->note_markdown_others = $args['note_markdown'];
      $this->note_html_others = $args['note_html'];

      if(is_blank($this->note_markdown_others)) {
        $this->errors['note_markdown'] = "Note cannot be blank.";
      }elseif (!has_length($this->note_markdown, array('min' => 2))) {
        $this->errors['note_markdown'] = "Note must have minimum 2 characters.";
      }
      if(is_blank($this->note_html_others)) {
        $this->errors['note_html'] = "Preview cannot be blank.";
      }elseif (!has_length($this->note_markdown, array('min' => 2))) {
        $this->errors['note_preview'] = "Preview must have minimum 2 characters.";
      }

      if(empty($this->errors)){
        $this->date_others = date('Y-m-j');
        $this->time_others = date('H:i:s');
        $sql = 'UPDATE '. static::$table_name;
        $sql .= ' SET note_markdown_others =' . "'".self::$database->escape_string($this->note_markdown_others) ."'";
        $sql .= ', note_html_others = '. "'".self::$database->escape_string($this->note_html_others) ."'";
        $sql .= ', date_others = '. "'".self::$database->escape_string($this->date_others) ."'";
        $sql .= ', time_others = '. "'".self::$database->escape_string($this->time_others) ."'";
        $sql .= ' WHERE note_id ='. "'".self::$database->escape_string($args['note_id']) ."'";
        return self::$database->query($sql); // true or false
      }else{
        return $this->errors;
      }
    }else{
      return NULL; // here is_editable == 0 then create new note with new ID
    }
  }
}
 
  public function is_admin($note_id){
    // check note_id is stored in DB.
    if($this->is_note_id_exists($note_id)){
      // Match client ip-address with stored ip-address in DB.
      // if true then current user is owner of current note.
      // then do update for existing note instead of creating a new note.
      $is_admin = $this->check_note_ip_address();
      if($is_admin){
        $this->is_admin = true;
        return true;
      }else{
        $this->is_admin = false;
        return false;
      }
    }
    return NULL; // must send NULL
  }

  public function need_update_for_note($note_id, $args){
    // echo '---------'. PHP_EOL;
    // fa($args, true);
    $sql = 'SELECT * from '. static::$table_name;
    $sql .=' WHERE note_id='. "'". self::$database->escape_string($note_id) ."'";
    $userNote_array = static::find_by_sql($sql);
    $userNote = array_shift($userNote_array);

    // if(is_blank($this->note_markdown)) {
    //   $userNote->errors['note_markdown'] = "Note cannot be blank.";
    // }elseif (!has_length($this->note_markdown, array('min' => 2))) {
    //   $userNote->errors['note_markdown'] = "Note must have minimum 2 characters.";
    // }
    // if(is_blank($this->note_html)) {
    //   $userNote->errors['note_html'] = "Preview cannot be blank.";
    // }elseif (!has_length($this->note_markdown, array('min' => 2))) {
    //   $userNote->errors['note_html'] = "Preview must have minimum 2 characters.";
    // }

    $userNote->merge_attributes($args);
    $result = $userNote->save();
    if($result === true){
      return true;
    }else{
      // sending whole objcet because it has now some errors that's why it doesn't save in DB.
      return $userNote;
    }
  }

public function validate() {
  $this->errors = [];
  
  if(is_blank($this->note_id)) {
    $this->generate_unique_note_id();
  }
  if(strlen($this->note_id) > 15){
    $this->errors['note_id'] = "Note ID can not more than 15 charcters.";
  }
  if(is_blank($this->id)) {
    $this->is_admin = true;
  }
  if(is_blank($this->id) && !empty($this->is_note_id_exists($this->note_id))){
    $this->generate_unique_note_id();
  }

  if($this->is_private == 1){
    $this->is_private = (int) $this->is_private;
    $this->is_editable = 0;
  }
 
  if($this->is_editable == 1 && $this->is_private == 0){
    $this->is_editable = (int) $this->is_editable;
    $this->is_private = 0;
  }

  if(is_blank($this->note_markdown)) {
    $this->errors['note_markdown'] = "Note cannot be blank.";
  }elseif (!has_length($this->note_markdown, array('min' => 2))) {
    $this->errors['note_markdown'] = "Note must have minimum 2 characters.";
  }
  if(is_blank($this->note_html)) {
    $this->errors['note_html'] = "Preview cannot be blank.";
  }elseif (!has_length($this->note_markdown, array('min' => 2))) {
    $this->errors['note_html'] = "Preview must have minimum 2 characters.";
  }

  if(is_blank($this->id) && !is_blank($this->password) && !is_valid_paswd($this->password)){
    $this->errors['password'] = 'Password must contains only word characters [<b>0-9A-Za-z_</b>]';
  }
  
  return $this->errors;
}

}
 ?>
