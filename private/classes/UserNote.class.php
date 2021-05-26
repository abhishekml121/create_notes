<?php 
class UserNote extends DatabaseObject {
	static protected $table_name = "notes";
  static protected $db_columns = ['id', 'user_id', 'note_id','topic', 'note_html', 'note_markdown', 'access_type','date', 'time', 'self_views', 'watch_later','imp_note'];

  public $id;
  public $user_id;
  public $note_id;
  public $topic;
  public $note_html;
  public $note_markdown;
  public $subject_name;
  public $user_avatar_url;
  public $tag_name;
  public $date;
  public $time;
  public $username;
  public $self_views =0;
  public $watch_later =0;
  public $imp_note =0;
  protected $password_required = true;  

  public function __construct($args=[]) {
    $this->user_id = $_COOKIE['user_id'] ?? '';
    $this->note_html = $args['note_html'] ?? '';
    $this->note_markdown = $args['note_markdown'] ?? '';
    $this->subject_name = $args['subject_name'] ?? '';
    $this->topic = $args['topic'] ?? '';
    $this->tag_name = $args['tag_name'] ?? '';
    $this->access_type = $args['access_type'] ?? '';
    $this->date = date('Y-m-j');
    $this->time = date('H:i:s');
  }

  public function generate_unique_note_id(){
    $this->note_id = generate_random_id();
  }

  public static function search_notes_for_suggestionby_access_type($args=[]){
    if(empty($args)) return [];
    $access_type = $args['access_type'] ?? null;
    $user_id = $args['user_id'] ?? null;
    $access_for = $args['access_for'] ?? null;
    if($access_type == null && $user_id == null){
      return false;
    }
    $sql = 'SELECT note_id, topic, access_type, user_avator from '. static::$table_name;
    $sql .= ' JOIN users ON users.id= notes.user_id';

    if($user_id!=null && $access_for!= null){
      if($access_for == 'global'){
      $sql .=' WHERE access_type='."'". self::$database->escape_string($access_type) ."' ";
    }else{
      $sql .=' WHERE user_id='. "'". self::$database->escape_string($user_id) ."' ";
    }
}elseif ($user_id == null) {
      $sql .=' WHERE access_type='."'". self::$database->escape_string($access_type) ."' ";
    }
    $sql .= ' AND topic like'. "'%".$args['topic']."%'";
  //echo $sql;
    $result = static::find_by_sql_without_object($sql, true);
    return $result;
  }

  public static function get_note_suggestion_html($args=[]){
    $notes = self::search_notes_for_suggestionby_access_type($args);

    if(empty($notes)) return false;
    $html ='<span class="search_sugg_notes">';
    foreach ($notes as ['note_id'=>$note_id, 'topic'=>$topic, 'user_avator'=> $profile_pic]) {
          $html .= '<a href="'.url_for('/user/view_note?noteID='.$note_id) .'" class="no_underline s_s_result">';
          $html .= '<span>'.h($topic).'</span>';
          $html .= '<img src="'.$profile_pic .'" class='. '"s_notes_img">';
          $html .='</a>';
    }

    $html .='</span>';
    return $html;

  }

public static function count_all_notes_by_user_id($user_id) {
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $sql .= ' WHERE user_id='. "'".self::$database->escape_string($user_id) ."' ";
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }

public static function count_watch_later_notes_by_user_id($user_id) {
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $sql .= ' WHERE user_id='. "'".self::$database->escape_string($user_id) ."' ";
    $sql .= ' AND watch_later=1';
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }
  public static function count_imp_notes_by_user_id($user_id) {
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $sql .= ' WHERE user_id='. "'".self::$database->escape_string($user_id) ."' ";
    $sql .= ' AND imp_note=1';
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }

  public static function get_self_most_viwed_N_notesID($limit, $user_id){
    $sql ='SELECT note_id, topic,self_views from '. static::$table_name;
    $sql .=' WHERE user_id ='. "'". self::$database->escape_string($user_id) ."'";
    //converting string to integer
    $sql .=' ORDER BY cast(self_views AS unsigned) DESC LIMIT ' . self::$database->escape_string($limit);

    return static::find_by_sql_without_object($sql, true);
  }
  public static function get_last_N_notesID($limit, $user_id){
    $sql ='SELECT id,user_id,note_id, topic from '. static::$table_name;
    $sql .=' WHERE user_id ='. "'". self::$database->escape_string($user_id) ."'";
    $sql .=' ORDER BY date DESC,time DESC LIMIT ' . self::$database->escape_string($limit);

    return static::find_by_sql_without_object($sql, true);
  }

  public static function delete_note($user_id, $note_id){
    // var_dump($user_id, $note_id);
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE user_id='" . self::$database->escape_string($user_id) . "' ";
    $sql .= "AND note_id='" . self::$database->escape_string($note_id) . "' ";
    $sql .= "LIMIT 1";
  
    $result = self::$database->query($sql);
    return $result;
  }

  public function get_note_wrap_start_html(){
    return '<article class="note_wrap">';
  }
  public function barCode_wrap_for_note($note_id){
    $html = '<div class="bar_code_wrap"><span>Bar Code</span>';
    $html .= '<img src="'. url_for('/phpqrcode/temp.php?noteID='. $note_id) . '">';
    $html .= '</div>';
    return $html;
  }
  public function get_note_wrap_end_html(){
    return '</article> <!-- .note_wrap  -->';
  }

  public function get_note_title_html($title, $note_id){

    $html = '<div class="note_head_wrap">';
    $html .='<a href="'.url_for('/user/view_note?noteID='. $note_id).'" class="no_underline">';
    $html .='<h3 class="note_head" title="title of note">'.h($title).'</h3>';
    $html .='</a></div><!-- .note_head_wrap  -->';

    return $html;
  }

  public function get_note_tag_wrap_start_html(){
    $html = '<div class="tags_wrap" title="tags">';
    $html .= '<span class="tag_icon_wrap">';
    $html .= '<span class="material-icons tag_label notes_icons">label</span>';
    $html .= '</span>';
    return $html;
  }

  public function get_note_tag_html($tag_name){
    $html = '<span class="tag">'. h($tag_name) .'</span>';
    return $html;
  }
  public function get_note_tag_wrap_end_html(){
    return '</div>';
  }

  public function extract_tags_html($notes_obj, $noteID){
    $html = $this->get_note_tag_wrap_start_html();
    $html .='<span class="only_note_tag_name_spans">';
    foreach ($notes_obj as $note) {
      if($note->note_id == $noteID){
        $html .= $this->get_note_tag_html($note->tag_name);
      }
    }
    $html .='</span>';
    $html .= $this->get_note_tag_wrap_end_html();
    return $html;
  }

  public function extract_tags_as_array($notes_obj, $noteID){
    $tag_array = [];
    foreach ($notes_obj as $note) {
      if($note->note_id == $noteID){
        array_push($tag_array, $note->tag_name);
      }
    }
    return $tag_array;
  }

  public function get_note_access_type_html($access_type){
    $html = '<div class="accessiblity_wrap">';
    if(strtolower($access_type) == 'public'){
      $html .= '<span class="material-icons notes_icons public_label">public</span>';
    }else{
      $html .= '<span class="material-icons notes_icons private_label">public_off</span>';
    }
    $html .= '<span class="accessiblity_name">'.h($access_type).'</span>';
    $html .= '</div><!-- .accessiblity_wrap  -->';

    return $html;
  }

  public function get_note_text_html($note){
    if(!is_object($note)){
      return;
    }
    if(!has_presence($this->username)){
      $this->username = User::find_by_id($note->user_id);
      $this->user_avatar_url = $this->username->user_avator;
      $this->username = (has_presence($this->username->email)) ? $this->username->email : $this->username->username;
    }
    $user_profile_page = url_for('/user/profile') . '#profile_section';
    $h = 'h';
    $date_format = humanTiming("{$note->date} {$note->time}");
    $html = <<< NOTE
    <section class="note_sec_wrap">
      <div class="note_user_info_wrap">
        <a href="{$user_profile_page}" class="user_page_link no_underline">
          <figure class="note_user_info_figure">
            <div class="note_user_info_img_wrap">
              <img src="{$h($this->user_avatar_url)}" alt="user profile image" class="note_user_info_img">
            </div>
            <figcaption class="note_user_info_img_figc" title="username">
              {$h($this->username)}
            </figcaption>
          </figure>
        </a><!-- .user_page_link  -->
        <span class="date_time_note">
          {$date_format}
        </span>
      </div><!-- .note_user_info_wrap  -->

      <div class="parsed_md_wrap ">
        <aside class="show_more_note_wrap note_small_preview" data-src="{$note->note_id}"><div class="show_more_text">{$note->note_html}</div></aside>
        <div class="parsed_md_text">
        {$note->note_html}
        </div><!-- .parsed_md_text  -->
      </div><!-- .parsed_md_wrap  -->
    </section><!-- .note_sec_wrap  -->
    NOTE;

    return $html;
  }

  public function note_action_html($action){
    if(!is_object($action)){
      return;
    }
    $is_owner = false;
    $user_id = isset($_COOKIE['user_id']) ?(int) $_COOKIE['user_id'] : null;
    if($action->user_id == $user_id){
      $is_owner = true;
    }

    $html = '<section class="action_wrap_sec">
              <div class="action_wrap_div">';

        // watch_later html
        if($user_id && $action->watch_later == 1){
          $image_location ='<span class="material-icons user_note_action_success save_to_pocket_img notes_icons">watch_later</span>';
        }else{
          $image_location ='<span class="material-icons save_to_pocket_img notes_icons">watch_later</span>';
        }
        $html .='<div class="save_to_pocket_wrap" data-src="'.$action->note_id.'">
          <div class="save_to_pocket_img_wrap">'.$image_location.'</div>
          <div class="save_to_pocket_btn_wrap">
            <span class="save_to_pocket_btn" title="Watch later for quickly access in future">Watch later</span>
          </div>
        </div><!-- .save_to_pocket_wrap  -->';

        // mark as important html
        if($user_id && $action->imp_note == 1){
          $image_location ='<span class="material-icons user_note_action_success mark_as_imp_img notes_icons">favorite</span>';
        }else{
          $image_location ='<span class="material-icons mark_as_imp_img notes_icons">favorite</span>';
        }
        $html .='<div class="mark_as_imp_wrap" data-src="'.$action->note_id.'">
          <div class="mark_as_imp_img_wrap">'.$image_location.'</div>
          <div class="mark_as_imp_btn_wrap">
            <span class="mark_as_imp_btn">Mark as Important</span>
          </div>
        </div><!-- .mark_as_imp_wrap  -->';

    if($is_owner){
      $html .='<div class="note_delete_wrap" data-src="'.$action->note_id.'">
      <div class="delete_note_btn_image_wrap">
      <span class="material-icons delete_note_btn_image notes_icons">delete</span>
      </div>
      <div class="note_trash_btn_wrap">
        <span class="note_delete_btn" data-src="'.$action->note_id.'">Delete</span>      
      </div>
    </div><!-- .note_delete_wrap  -->';
    }

    if($is_owner){
      $html .= '<div class="note_edit_wrap" data-src="'.$action->note_id.'">
      <a class="note_edit_btn_wrap no_underline" href="./edit_note?noteID='. $action->note_id .'">
      <div class="edit_note_btn_image_wrap">
      <span class="material-icons notes_icons edit_note_btn_image">edit</span>
      </div>
      <div class="note_edit_btn_wrap">
        <span class="note_edit_btn">Edit</span>
      </a>
      </div>
      </a>
    </div><!-- .note_edit_wrap  -->';
  }

    $html .='</div><!-- .action_wrap_div  -->
    </section><!-- .action_wrap_sec  -->';

    return $html;
  }

  public function get_note_html($notes_obj){
    if(empty($notes_obj)) return false;

    $noteIDs = array();
    $html = '';
    foreach ($notes_obj as $key => $note) {
      if(has_inclusion_of($note->note_id, $noteIDs)){
        continue;
      }else{
        array_push($noteIDs, $note->note_id);
        $html .= $this->get_note_wrap_start_html();
        $html .= $this->barCode_wrap_for_note($note->note_id);
        $html .= $this->get_note_title_html(ucfirst($note->topic), $note->note_id);
        $html .= $this->extract_tags_html($notes_obj, $note->note_id);
        $html .= $this->get_note_access_type_html($note->access_type);
        $html .= $this->get_note_text_html($note);
        $html .= $this->note_action_html($note);
      }
      $html .= $this->get_note_wrap_end_html();
      }
    return $html;
  }


  // $sql = 'SELECT DISTINCT(subject_name) AS subject_name, user_id from notes_subject where user_id=2 ORDER BY subject_name ASC';
 
  // used in user/topic.php
  public function get_note_topic_html($notes_obj, $count_note){
    if(empty($notes_obj)) return false;
    $count = $count_note;
    $noteIDs = array();
    $h = 'h';
    $html = '';
    foreach ($notes_obj as $key => $note) {
      if(has_inclusion_of($note->note_id, $noteIDs)){
        continue;
      }else{
        array_push($noteIDs, $note->note_id);
        $note_url = url_for('/user/view_note?noteID=' . $note->note_id);
        $formated_date_time = humanTiming("{$note->date} {$note->time}");
        ++$count;
        $html .= <<< HTML
              <article class="sinlge_note_title">
              <span class="count_note_title">{$count}</span>
              <div class="note_title">
                  <a href="{$note_url}" class="no_underline">{$h($note->topic)}</a>
              </div>
              HTML;
        $html .= $this->extract_tags_html($notes_obj, $note->note_id);
        $html .= <<<HTML
            <div class="note_subject_name">
            <a href="" class="no_underline">{$h($note->subject_name)}</a>
            </div>
            <div class="date_time_note_title">{$formated_date_time}</div>
        </article>
        HTML;
      }
      }
    return $html;
  }

  //fetching all notes of a specific user
  public function get_user_notes(){
    $user_id = (int) $_COOKIE['user_id'];
    $sql = 'SELECT * from '. static::$table_name .' AS N JOIN notes_subject AS S';
    $sql .=' ON N.user_id =' ."'". self::$database->escape_string($user_id) ."'";
    $sql .= ' AND N.user_id = S.user_id AND N.note_id = S.note_id JOIN notes_tag AS T ON N.user_id = T.user_id AND N.note_id = T.note_id';

      return static::find_by_sql($sql);
  }
  public static function get_topic_name_by_noteID($note_id){
    $sql = 'SELECT topic from '. static::$table_name;
    $sql .= ' WHERE note_id='. "'". self::$database->escape_string($note_id) ."'";
    return static::find_by_sql_without_object($sql);
  }
  public function get_user_notes_by_subject_name($args=[], $offset=true){
    if(!has_presence($args['user_id']) && !has_presence($args['subject_name'])){
      return false;
    }

    $sql = 'SELECT N.id,N.user_id,N.note_id ,S.subject_name, N.access_type, N.note_html, N.note_markdown, S.subject_name, T.tag_name, N.topic,N.date, N.time from( ';
    $sql .= 'SELECT N.* FROM notes N WHERE user_id='."'". self::$database->escape_string($args['user_id']) ."' ";
    $sql .= ' ORDER by N.date DESC';
    $sql .= ' ) N ';
    $sql .='JOIN notes_subject AS S ON BINARY S.subject_name='. "'". self::$database->escape_string($args['subject_name']) ."' ";
    $sql .=' AND N.note_id = S.note_id ';
    $sql .=' JOIN notes_tag AS T ON  N.note_id = T.note_id ';
    $sql .= 'ORDER BY N.date DESC, N.time DESC';
    if($offset==true){
      $sql .= ' LIMIT ' . self::$database->escape_string($args['limit']);
      $sql .= ' OFFSET ' . self::$database->escape_string($args['offset']);
    }
    return static::find_by_sql($sql);
    // return static::find_by_sql_without_object($sql, true);
  }
  
  
  //used in infinite scrolling to access user notes.
  public function get_user_notes_by_offset($limit, $offset){
    $user_id =  isset($_COOKIE['user_id']) ?(int) $_COOKIE['user_id'] : '';
    // user is not loged in or user session has expired.
    if(!has_presence($user_id)){
      return false;
    }

    $sql = 'SELECT N.id, N.user_id, N.note_id,N.watch_later,N.imp_note, N.topic,N.note_html, N.note_markdown, N.access_type, S.subject_name, T.tag_name, N.date, N.time from(';
    $sql .= ' SELECT N.* from notes N';
    $sql .= ' WHERE N.user_id = ' ."'". self::$database->escape_string($user_id) ."'";
    $sql .= ' ORDER by N.date DESC, N.time DESC LIMIT ' . self::$database->escape_string($limit);
    $sql .= ' OFFSET ' . self::$database->escape_string($offset) .') N';
    $sql .= ' JOIN notes_subject S on N.user_id = S.user_id';
    $sql .= ' AND N.note_id = S.note_id';
    $sql .= ' JOIN notes_tag T';
    $sql .= ' ON N.user_id = T.user_id AND N.note_id = T.note_id';
    $sql .= ' ORDER by N.date DESC, N.time DESC';
    return static::find_by_sql($sql);

    /*SELECT N.id,N.user_id,N.note_id ,S.subject_name, N.access_type, N.note_html, N.note_markdown, S.subject_name, T.tag_name, N.topic,N.date, N.time from(
      SELECT N.* from notes N WHERE N.user_id=2 ORDER BY N.date DESC, N.time DESC LIMIT 1 OFFSET 0
    ) N JOIN notes_subject AS S ON N.note_id = S.note_id JOIN notes_tag AS T ON  N.note_id = T.note_id WHERE BINARY S.subject_name='DLD' ORDER BY N.date DESC, N.time DESC */
  }

  public function get_user_watch_later_notes_by_offset($limit, $offset){
    $user_id =  isset($_COOKIE['user_id']) ?(int) $_COOKIE['user_id'] : '';
    // user is not loged in or user session has expired.
    if(!has_presence($user_id)){
      return false;
    }

    $sql = 'SELECT N.id, N.user_id, N.note_id,N.watch_later,N.imp_note, N.topic,N.note_html, N.note_markdown, N.access_type, S.subject_name, T.tag_name, N.date, N.time from(';
    $sql .= ' SELECT N.* from notes N';
    $sql .= ' WHERE N.user_id = ' ."'". self::$database->escape_string($user_id) ."'";
    $sql .= ' AND N.watch_later = 1';
    $sql .= ' ORDER by N.date DESC, N.time DESC LIMIT ' . self::$database->escape_string($limit);
    $sql .= ' OFFSET ' . self::$database->escape_string($offset) .') N';
    $sql .= ' JOIN notes_subject S on N.user_id = S.user_id';
    $sql .= ' AND N.note_id = S.note_id';
    $sql .= ' JOIN notes_tag T';
    $sql .= ' ON N.user_id = T.user_id AND N.note_id = T.note_id';
    $sql .= ' ORDER by N.date DESC, N.time DESC';
    return static::find_by_sql($sql);
  }

  public function get_user_imp_notes_by_offset($limit, $offset){
    $user_id = isset($_COOKIE['user_id']) ? (int) $_COOKIE['user_id'] : '';
    // user is not loged in or user session has expired.
    if(!has_presence($user_id)){
      return false;
    }

    $sql = 'SELECT N.id, N.user_id, N.note_id,N.watch_later,N.imp_note, N.topic,N.note_html, N.note_markdown, N.access_type, S.subject_name, T.tag_name, N.date, N.time from(';
    $sql .= ' SELECT N.* from notes N';
    $sql .= ' WHERE N.user_id = ' ."'". self::$database->escape_string($user_id) ."'";
    $sql .= ' AND N.imp_note = 1';
    $sql .= ' ORDER by N.date DESC, N.time DESC LIMIT ' . self::$database->escape_string($limit);
    $sql .= ' OFFSET ' . self::$database->escape_string($offset) .') N';
    $sql .= ' JOIN notes_subject S on N.user_id = S.user_id';
    $sql .= ' AND N.note_id = S.note_id';
    $sql .= ' JOIN notes_tag T';
    $sql .= ' ON N.user_id = T.user_id AND N.note_id = T.note_id';
    $sql .= ' ORDER by N.date DESC, N.time DESC';
    return static::find_by_sql($sql);
  }

  //without noteID.
  // used in view_note.php
  public function get_user_note_by_only_noteID($note_id,$user_id, $validate=true){
    $sql = 'select * from notes AS N';
    $sql .=' JOIN notes_subject AS S';
    $sql .=' ON S.note_id =' ."'".self::$database->escape_string($note_id) ."'";
    $sql .=' AND N.note_id = S.note_id JOIN notes_tag AS T ON T.note_id = '."'". self::$database->escape_string($note_id) ."' ";
    // login user can not access notes of other users
    if($validate){
      $sql .='WHERE N.access_type =' . "'Public' ";
      $sql .='OR N.user_id =' . "'".h($user_id)."'";
    }
    // echo $sql;
      return static::find_by_sql($sql);
}

public function get_view_note_html($notes_obj)
{
  $noteIDs = array();
  $html = '';
  foreach ($notes_obj as $key => $note) {
    if(has_inclusion_of($note->note_id, $noteIDs)){
      continue;
    }else{
      array_push($noteIDs, $note->note_id);
      $html .= $this->get_note_title_html(ucfirst($note->topic),$note->note_id);
      $html .= $this->extract_tags_html($notes_obj, $note->note_id);
      $html .= $this->get_note_access_type_html($note->access_type);
      $html .= $this->get_note_text_html($note);
      $html .= $this->note_action_html($note);
    }
    }
  return $html;
}
  public function get_user_note_by_noteID($user_id, $note_id){
    $sql = 'select * from notes AS N';
    $sql .=' JOIN notes_subject AS S';
    $sql .=' ON N.user_id =' ."'".self::$database->escape_string($user_id) ."'";
    $sql .=' AND N.user_id = S.user_id AND';
    $sql .=' N.note_id = '."'" .self::$database->escape_string($note_id) . "'";
    $sql .=' AND N.note_id = S.note_id  JOIN notes_tag AS T ON N.user_id = T.user_id AND N.note_id = T.note_id';

      return static::find_by_sql($sql);
  }


  public function get_note_deatils_for_edit($user_id, $note_id){
    $noteIDs = array();
    $note_array = array();
    $notes_obj = $this->get_user_note_by_noteID($user_id, $note_id);

    foreach ($notes_obj as $key => $note) {
      if($note->user_id != $user_id){
        return false;
      }
      if(has_inclusion_of($note->note_id, $noteIDs)){
        continue;
      }else{
        array_push($noteIDs, $note->note_id);
        $tags_array = $this->extract_tags_as_array($notes_obj, $note->note_id);
        $tags_as_string = implode(',' ,$tags_array);
      }

      foreach ($note as $note_key => $note_value) {
        $note_array[$note_key] = $note_value;
      }
      // reinitialise tag_name for multiple tags.
      $note_array['tag_name'] = $tags_as_string;
      }

    return $note_array;
  }

  //count the self_view note of a specific note
  public static function count_by_attr($args=[]){
    if(!empty($args)){
      $sql ='SELECT '. $args['db_attr'] .' FROM '. static::$table_name;
      $sql .=' WHERE user_id ='. "'".self::$database->escape_string($args['user_id']) ."'";
      $sql .=' AND note_id ='. "'".self::$database->escape_string($args['noteID']) ."'";
      return static::find_by_sql_without_object($sql);
    }
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

  public static function update_watch_later($user_id, $noteID){
    // fetchinig previous watch_later
    $sql ='SELECT watch_later FROM '. static::$table_name;
    $sql .=' WHERE user_id ='. "'".self::$database->escape_string($user_id) ."'";
    $sql .=' AND note_id ='. "'".self::$database->escape_string($noteID) ."'";
    
    $previous_watch_later = static::find_by_sql_without_object($sql);
    if($previous_watch_later == null){
      return array('update'=>false);
    }elseif ($previous_watch_later['watch_later'] == 0) {
      $boolean = 1;
    }else{
      $boolean = 0;
    }
      // updating watch later
      $sql ='UPDATE '. static::$table_name;
      $sql .=' SET watch_later='. self::$database->escape_string($boolean);
      $sql .=' WHERE user_id ='. "'".self::$database->escape_string($user_id) ."'";
      $sql .=' AND note_id ='. "'".self::$database->escape_string($noteID) ."'";

      return array('update'=>self::$database->query($sql), 'current_watch_later_value'=>$boolean);

  }

  public static function update_imp_note($user_id, $noteID){
    // fetchinig previous watch_later
    $sql ='SELECT imp_note FROM '. static::$table_name;
    $sql .=' WHERE user_id ='. "'".self::$database->escape_string($user_id) ."'";
    $sql .=' AND note_id ='. "'".self::$database->escape_string($noteID) ."'";
    
    $previous_imp_note = static::find_by_sql_without_object($sql);
    if($previous_imp_note == null){
      return array('update'=>false);
    }elseif ($previous_imp_note['imp_note'] == 0) {
      $boolean = 1;
    }else{
      $boolean = 0;
    }
      // updating watch later
      $sql ='UPDATE '. static::$table_name;
      $sql .=' SET imp_note='. self::$database->escape_string($boolean);
      $sql .=' WHERE user_id ='. "'".self::$database->escape_string($user_id) ."'";
      $sql .=' AND note_id ='. "'".self::$database->escape_string($noteID) ."'";

      return array('update'=>self::$database->query($sql), 'current_imp_note_value'=>$boolean);

  }

public function validate() {
  $this->errors = [];
  
  if(is_blank($this->topic)) {
    $this->errors['topic'] = "Topic cannot be blank.";
  } elseif (!has_length(trim($this->topic), array('min' => 5, 'max' => 500))) {
    $this->errors['topic'] = "Topic must be between 5 and 500 characters.";
  }

  if(is_blank($this->access_type)) {
    $this->errors['access_type'] = "Access type cannot be empty.";
  }elseif ($this->access_type != 'Public' && $this->access_type != 'Private') {
    $this->errors['access_type'] = "Access type is not given correct.";
  }

  if(is_blank($this->note_markdown)) {
    $this->errors['note_markdown'] = "Note markdown cannot be blank.";
  }elseif (!has_length($this->note_markdown, array('min' => 10))) {
    $this->errors['note_markdown'] = "Note markdown must have minimum 10 characters.";
  }
  if(is_blank($this->note_html)) {
    $this->errors['note_html'] = "Note preview cannot be blank.";
  }elseif (!has_length($this->note_markdown, array('min' => 10))) {
    $this->errors['note_markdown'] = "Note preview must have minimum 10 characters.";
  }
  
  return $this->errors;
}

}
 ?>
