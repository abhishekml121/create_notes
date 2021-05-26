<?php
header('Content-Type: image/jpeg');
require('./qrlib.php');
// $url_param = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['noteID']);
$raw_data = $_GET['noteID'] ?? $_GET['quick_note_id'];
preg_match('/^\w+$/', $raw_data, $filtered_data);
if(!empty($filtered_data)){

$barcode_content = 'http://192.168.43.147/php_projects/user_notes/';
if(array_key_exists('noteID', $_GET)){
    $barcode_content .= 'user/view_note?noteID='. htmlspecialchars($filtered_data[0]);
}else if(array_key_exists('quick_note_id', $_GET)){
    $barcode_content .= htmlspecialchars($filtered_data[0]);
}

QRcode::png($barcode_content);
}
?>