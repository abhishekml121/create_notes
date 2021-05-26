<?php
header('Content-Type: image/jpeg');

$bg = imagecreatefromjpeg('https://images.unsplash.com/photo-1598124148472-2aaf04f23ea2?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MTF8fGpwZ3xlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');
$img = imagecreatefromjpeg('https://images.unsplash.com/photo-1598124145785-eb9a5b3b9c27?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MTJ8fGpwZ3xlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60');

imagecopymerge($bg, $img, 30, 80, 0, -100, imagesx($bg), imagesy($bg), 75);

imagejpeg($bg, null, 100);
?>