<?php 
class UserSubject extends DatabaseObject {
	static protected $table_name = "notes_subject";
  static protected $db_columns = ['id', 'user_id', 'note_id','subject_name'];

  public $id;
  public $user_id;
  public $note_id;
  public $subject_name;

  public function __construct($args=[]) {
    $this->user_id =  isset($_COOKIE['user_id']) ?(int) $_COOKIE['user_id'] : '';
    $this->note_id = $args['note_id'] ?? '';
    $this->subject_name = $args['subject_name'] ?? '';
  }

  //used in infinite scrolling to access user notes.
  public function get_user_subjects_by_offset($limit, $offset){
    $user_id = (int) $_COOKIE['user_id']  ?? '';
    // user is not loged in or user session has expired.
    if(!has_presence($user_id)){
      return false;
    }

    $sql = 'SELECT DISTINCT subject_name, COUNT(subject_name) AS count FROM notes_subject ';
    $sql .='WHERE user_id= ' . "'". self::$database->escape_string($user_id) ."' ";
    $sql .='GROUP BY subject_name ';
    $sql .='ORDER BY subject_name ASC ';
    $sql .='LIMIT ' . self::$database->escape_string($limit);
    $sql .=' OFFSET ' . self::$database->escape_string($offset);

    // $sql = 'SELECT DISTINCT subject_name, count(subject_name collate utf8mb4_bin) over (partition by subject_name collate utf8mb4_bin) ';
    // $sql .='AS count from notes_subject ';
    // $sql .='WHERE user_id= ' . "'". self::$database->escape_string($user_id) ."' ";
    // $sql .=' ORDER BY subject_name ASC ';
    // $sql .='LIMIT ' . self::$database->escape_string($limit);
    // $sql .=' OFFSET ' . self::$database->escape_string($offset);
    // echo $sql;
    return static::find_by_sql_without_object($sql, true);
    }    
  public function get_subject_html($args=[]){
    if(empty($args)) return false;
    $subjects_obj = $this->get_user_subjects_by_offset($args['limit'], $args['offset']);
    if(empty($subjects_obj)) return false;

    $html = '';
    $subject_url = '';
    $subject_name = '';
    $h = 'h';
    foreach ($subjects_obj as $key => $subject) {
      $subject_name = h($subject['subject_name']);
      $subject_url = url_for('/user/subjects?subjectName='. $subject_name);
      $html .= <<< HTML
      <div class="subject_info_wrap">
          <div class="subject_head_wrap">
              <p class="subject_head">{$h($subject['subject_name'])}</p>
          </div>
          <div class="subject_total_notes">
              <span class="total_subject_number">{$subject['count']}</span>
              <span><a href="{$subject_url}" class="no_underline">Notes</a></span>
          </div>
      </div><!-- .subjects_info_wrap  -->
      HTML;
    }
    return $html;
  }

  public static function count_subject_notes($user_id, $subject_name){
    $sql = 'SELECT COUNT(*) FROM ' . static::$table_name;
    $sql .= ' WHERE user_id='."'". self::$database->escape_string($user_id) ."' ";
    $sql .= ' AND BINARY subject_name='. "'". self::$database->escape_string($subject_name) ."'";
    $row = static::find_by_sql_without_object($sql, false);
    return array_shift($row);
  }

  public static function count_total_subjects_by_userID($user_id, $case_sensitive=true){
    if(!has_presence($user_id)) return false;

    if(!$case_sensitive){
    $sql = 'SELECT COUNT(DISTINCT subject_name) FROM ' . static::$table_name;
    $sql .= ' WHERE user_id='. "'".self::$database->escape_string($user_id) ."' ";
    $sql .= 'ORDER BY subject_name';
  }else{
    $sql = 'SELECT COUNT(DISTINCT (CAST(';
    $sql .= 'subject_name AS CHAR CHARACTER SET utf8)';
    $sql .= 'COLLATE utf8_bin))';
    $sql .= ' AS subject_name FROM ' . static::$table_name;
    $sql .= ' WHERE user_id='. "'".self::$database->escape_string($user_id) ."' ";
  }
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }
  public static function subject_notes_info($obj =[])
  {
    $first_element = array_shift($obj);

    // fa($first_element);
    $h = 'h';
    $user_id = (int) $_COOKIE['user_id'];
    $total_notes =self::count_subject_notes($user_id, $first_element->subject_name);
    $date_time_format = humanTiming("{$first_element->date} {$first_element->time}");
    $html = <<<HTML
    <div class="subject_notes_info_wrap">
        <div class="name_of_subject_wrap">
            <span class="name_of_subject_head">Subject :</span>
            <span class="name_of_subject info">{$h($first_element->subject_name)}</span>
        </div>
        <div class="total_notes_wrap">
            <span class="total_notes_head">Total notes :</span>
            <span class="total_notes info">{$total_notes}</span>
        </div>
        <div class="last_written_notes_wrap" title="For subject {$h($first_element->subject_name)}">
            <span class="last_written_notes_head">Last written note :</span>
            <span class="last_written_notes_date_time info">{$date_time_format}</span>
        </div>
    </div><!-- .subject_notes_info_wrap  -->
    HTML;
    
    return $html;
  }

  public static function get_top_info_html($args=['count_all_notes'=>true, 'count_all_subjects'=>true, 'count_all_watch_later_notes'=>false, 'count_all_imp_notes'=>false])
  {
    $user_id = (int) $_COOKIE['user_id'];

    if($args['count_all_notes'] == true){
      $total_notes = UserNote::count_all_notes_by_user_id($user_id);
      if($total_notes == 0) return false;
      $html ='<div><span>Total notes: </span><span><big class="tt_big">'.$total_notes.'</big></span></div>';
    }
    if($args['count_all_subjects'] == true){
      $total_subjects = self::count_total_subjects_by_userID($user_id, $case_sensitive=true);
      $html .='<div><span>Total subjects: </span><span><big class="tt_big">'.$total_subjects.'</big></span></div>';
    }
    if($args['count_all_watch_later_notes'] == true){
      $total_watch_later_notes = UserNote::count_watch_later_notes_by_user_id($user_id);
      $html .='<div><span>Total watch later notes: </span><span><big class="tt_big">'.$total_watch_later_notes.'</big></span></div>';
    }
    if($args['count_all_imp_notes'] == true){
      $total_imp_notes = UserNote::count_imp_notes_by_user_id($user_id);
      $html .='<div><span>Total important notes: </span><span><big class="tt_big">'.$total_imp_notes.'</big></span></div>';
    }
   
    return $html;
  }

  
}
 ?>
