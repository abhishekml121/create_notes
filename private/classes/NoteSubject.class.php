<?php 
class NoteSubject extends DatabaseObject {
	static protected $table_name = "notes_subject";
  static protected $db_columns = ['id', 'user_id', 'note_id', 'subject_name'];

  public $id;
  public $user_id;
  public $note_id;
  public $subject_name;
 
  public function __construct($args=[]) {
    $this->user_id = $args['user_id'] ?? '';
    $this->note_id = $args['note_id'] ?? '';
    $this->subject_name = $args['subject_name'] ?? '';
  }

  public static function search_subject_name($input=''){
    if(!has_presence($input)){
      return false;
    }
    $sql = 'SELECT DISTINCT subject_name from '.static::$table_name;
    $sql .= ' WHERE subject_name like '. "'%".self::$database->escape_string($input) ."%'";

    $result = static::find_by_sql_without_object($sql, true);

    return $result;
  }

  public static function get_html_for_s_sugg_subject($input=''){
    if(!has_presence($input)){
      return false;
    }
    $result = self::search_subject_name($input); // array
    if(!empty($result)){
      $html = '<span class="subject_suggestion">';
      foreach ($result as ['subject_name'=>$subject_name]) {
        $html .= '<span class="s_s_result">'.h($subject_name).'</span>';
      }
      $html .='</span>';
      return $html;
    }else{
      return false;
    }
  }

  public function validate() {
    $this->errors = [];
    if(is_blank($this->subject_name)) {
      $this->errors['subject'] = "Subject name cannot be blank.";
    } elseif (!has_length(trim($this->subject_name), array('min' => 2, 'max' => 500))) {
      $this->errors['subject'] = "Subject name must be between 2 and 500 characters.";
    }
    return $this->errors;
  }
}
 ?>