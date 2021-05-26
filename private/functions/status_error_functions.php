<?php
function require_login($url='/index.php',$hash='') {
  global $session;
    if(!$session->is_logged_in()) {
      redirect_to(url_for($url));
  }else{
    // continue to show pages.
  }
}

function ajax_require_login()
{
    global $session;
    if (!$session->is_logged_in()) {
        // you need to redirect for false return in AJAX-JAVASCRIPT
       return false;
     }else{
      return true;
     }
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $key => $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div id="message">' . h($msg) . '</div>';
  }
}

?>
