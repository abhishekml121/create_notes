<?php

function message_to_dev_for_email($arr=[]){
  if(!empty($arr)){
    $date = date(DATE_COOKIE);
    $html = <<<HTML
    <p style="font-size: 19px;">{$arr['email_message']}</p>
    <p style="margin-top: 20px"><span>From : {$arr['sender']}</p>
    <p>{$date}</p>
    HTML;
  }
  return $html;
}

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request($submit_name='',$submit_value='') {
  if($submit_name && $submit_value && array_key_exists($submit_name, $_POST)){
    return (($_SERVER['REQUEST_METHOD'] == 'POST') && ($submit_value == $_POST[$submit_name]));
  }else{
    return false;
  }
}

function is_ajax_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// PHP on Windows does not have a money_format() function.
// This is a super-simple replacement.
if(!function_exists('money_format')) {
  function money_format($format, $number) {
    return '$' . number_format($number, 2);
  }
}


function get_copyright_year($startYear) {
    $currentYear = date('Y');
    if ($startYear < $currentYear) {
        $currentYear = date('Y');
        return "&copy; $startYear&ndash;$currentYear";
    } else {
        return "&copy; $startYear";
    }
}

function generate_random_number($length){
  if($length > 15){
    $length = 15;
  }
  return rand(pow(10, $length-1), pow(10, $length)-1);
}

function is_valid_domain_name(){
  // When dealing with multiple environments then,
  // add more `domain-name`
  $domains = array('localhost','192.168.43.147','kamal');
  if (in_array($_SERVER['HTTP_HOST'], $domains)){
      // $domain = $_SERVER['HTTP_HOST'];
   return true;
  }
  else{
      // $domain = 'localhost';
    return false;
  }
}

function generate_random_id($token_length=12){
  $generator = new RandomStringGenerator;
  // Set token length.
  $tokenLength = $token_length;
  // Call method to generate random string.
  return $generator->generate($tokenLength);
}

function change_date_time_format($date='', $time='', $format=''){

  $d_format = ($format == '') ? 'Y-m-j h:i:s' : $format;
  $date = DateTime::createFromFormat($d_format, "$date $time");
  return date_format($date, 'M j Y, H:i');
}

/**
 * $arr = [
    [ 'name'=> 'abhishek',
      'school'=>'KVM'
    ],
    [ 'name'=> 'abhishekm',
      'school'=>'JNV'
    ],
    [ 'name'=> 'viraj',
      'school'=>'JNV'
    ],
  ];
  print_r(count_values_in_array($arr, 'name'));

OUTPUT : 
Array
(
    [abhishek] => 1
    [abhishekm] => 1
    [viraj] => 1
)
*/
function count_values_in_array($arr = [], $count_by){
  if(has_presence($count_by) && !empty($arr)){
    return array_count_values(array_column($arr, $count_by)); // array
  }
  return false;
}

/**
 * It prints array in better format
*/
function fa($arr, $exit = true){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if($exit) exit;
}

?>
