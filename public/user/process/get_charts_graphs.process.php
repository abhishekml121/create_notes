<?php
// sleep(2000);//
function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }
    // If this is not AJAX request then stop executing.
    if(!is_ajax_request()) { exit; }
    require_once('../../../private/config/initialize.php');
    if(is_get_request()){
        $user_id = isset($_COOKIE['user_id']) ? h((int) $_COOKIE['user_id']) : null;
        $total_n= (int) UserNote::count_all_notes_by_user_id($user_id);
        $total_subjects = (int) UserSubject::count_total_subjects_by_userID($user_id, $case_sensitive=true);
        $total_w_l = (int) UserNote::count_watch_later_notes_by_user_id($user_id);
        $total_imp = (int) UserNote::count_imp_notes_by_user_id($user_id);
        $total_tags = (int) NoteTag::count_total_tags_by_user_id($user_id);
        $data = [
            ['Notes', 'Total'],
            ['Notes', $total_n],
            ['Tags', $total_tags],
            ['Subjects', $total_subjects],
            ['Watch later notes', $total_w_l],
            ['Important notes', $total_imp]
        ];

        $total = $total_n + $total_subjects + $total_w_l + $total_imp + $total_tags;
        if($total == 0){
            $send_arr = array('type'=>'load_charts_graphs','result'=>'false', 'total'=> 0);
        }else{
            $send_arr = array('type'=>'load_charts_graphs','result'=>'true', 'data'=> $data);
        }
        echo json_encode($send_arr);
    }
			
?>
