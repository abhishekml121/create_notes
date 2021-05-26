<?php
function get_greetings(){
  $hour_24_format = date('G'); // stores hours in 0-23
  if (($hour_24_format >= 5 & $hour_24_format <= 11)){
    return 1;         
    } else if ($hour_24_format > 11 & $hour_24_format <= 16) {
        return 2;
        // return "Good AfterNoon";
    } else if ($hour_24_format > 16 & $hour_24_format <= 19) {
        return 3;
        // return "Good Evening";
    } else {
        return 4; 
        // return "Good Night"; 
    }
}

function n_digit_OTP($length){
    // It can also return 000042 (starting with zeroS)
    return str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
}

function is_connected_to_internet(){
    //website, port  (try 80 or 443)
    $connected = @fsockopen("www.example.com", 80); 
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source https://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function get_domain_name_for_cookie(){
    //setcookie('quick_note_id', $note_id, time()+60*60*24*365, '/',  get_domain_name_for_cookie(), false);
    return ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
}
/*** Converting timestamp to time ago in PHP
* [e.g 1 minute ago, 1hr ago, 1 day ago, 2 days ago]
* $date = strtotime(date('Y-m-d H:i:s'));
* echo 'event happened '.humanTiming($time).' ago';
*/
function humanTiming($datetime, $break = 2) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if ($break > 0) $string = array_slice($string, 0, $break);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
