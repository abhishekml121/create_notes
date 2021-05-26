<?php 
class NoteTag extends DatabaseObject {
	static protected $table_name = "notes_tag";
  static protected $db_columns = ['id', 'user_id', 'note_id', 'tag_name'];

  public $id;
  public $user_id;
  public $note_id;
  public $tag_name;
 
  public function __construct($args=[]) {
    $this->user_id = $args['user_id'] ?? '';
    $this->note_id = $args['note_id'] ?? '';
    $this->tag_name = $args['tag_name'] ?? '';
  }

  protected function create($validation=false){
    $explode_tags = array_unique(explode(',', $this->tag_name));

    $attributes = ['user_id'=>$this->user_id, 'note_id'=>$this->note_id];
    foreach ($explode_tags as $tag_name) {
      // very imp to use trim() here, because tags are like "fruit,[space]mango".
      // So above space after comma will also be store in DB
      $attributes['tag_name'] = strip_tags(self::$database->escape_string(trim($tag_name)));
      if(has_presence($tag_name)){
        $sql = "INSERT INTO " . static::$table_name . " (";
        $sql .= join(', ', array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        // echo $sql;
        $result = self::$database->query($sql);
        if($result) {
          $this->id = self::$database->insert_id;
        }else{
          return false;
        }
      } // if
    } // foreach
    return true;
  }

  //deleting previous tag
  public function delete_tag_for_update(){
    $user_id = (int) $_COOKIE['user_id'];
    $sql = 'SELECT * from ' . static::$table_name . ' where note_id='. "'". h($_SESSION['note_id']). "'".' AND user_id=' . "'". h($user_id)."'";
    //ARRAY (
    //    [0]=> OBJECT,
    //    [1]=> OBJECT
    //    )
    $tags = self::find_by_sql($sql);
    if(empty($tags)){ return false; }
    // deleting all previous stored tag rows from MYSQL DB.
    foreach ($tags as $key => $note_tag) {
      $note_tag->delete();
    }
  }

  public static function get_tags($user_id){
    $sql = 'SELECT T.tag_name, N.self_views,N.topic,T.note_id from notes_tag AS T JOIN notes AS N ON N.note_id=T.note_id where T.user_id ='."'". self::$database->escape_string($user_id) ."' ";
    $sql .= 'ORDER BY tag_name';
    $result = static::find_by_sql_without_object($sql, true);
    return $result;
  }

  public function validate_tags(){
    if(is_blank($this->tag_name)){
      $this->errors['tag'] = "Tag cannot be blank.";
      return;
    }else{

    }
    $explode_tags = array_unique(explode(',', $this->tag_name));
    // if(empty($explode_tags)){
    //   if()
    //   $this->errors['tag'] = "You can only give 2 tags for a single note.";
    //   return;
    // }
    $total_tags = [];
    foreach ($explode_tags as $tag_name) {
      if(has_presence($tag_name)){
        $total_tags[]=$tag_name;
      }
    }
    if(empty($total_tags)){
      $this->errors['tag'] = "Tag cannot be blank.";
    }elseif (count($total_tags) > 10) {
      $this->errors['tag'] = "You can only give 10 tags for a single note.";
    }
  }
  public static function count_total_tags_by_user_id($user_id) {
    $sql = "SELECT COUNT(DISTINCT tag_name) FROM " . static::$table_name;
    $sql .= ' WHERE user_id='. "'".self::$database->escape_string($user_id) ."' ";
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }

  public function validate() {
    $this->errors = [];
    
    $this->validate_tags();

    return $this->errors;
  }

}
 ?>
