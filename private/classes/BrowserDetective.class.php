<?php
  
class BrowserDetective {
  
  public $user_agent;
  public $platform;
  public $browser_name;
  
  public function __construct() {
    $this->set_user_agent();
    $this->reset();
  }
  
  public function set_user_agent() {
    if(isset($_SERVER['HTTP_USER_AGENT'])) {
      $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
    } else {
      $this->user_agent = '';
    }
  }
  
  public function reset() {
    $this->platform = 'Unknown';
    $this->browser_name = 'Unknown';
  }
  
  public function detect() {
    $this->detect_platform();
    $this->detect_browser();
    return array($this->platform, $this->browser_name);
  }
  
  public function detect_platform() {
    if(preg_match('/linux/i', $this->user_agent)) {
      $this->platform = 'Linux';
    } elseif(preg_match('/macintosh|mac os/i', $this->user_agent)) {
      $this->platform = 'Mac';
    } elseif(preg_match('/windows|win32/i', $this->user_agent)) {
      $this->platform = 'Windows';
    }
  }
  
  public function detect_browser() {
    if(preg_match('/MSIE/i', $this->user_agent)) {
      $this->browser_name = 'Internet Explorer';
    } elseif(preg_match('/Firefox/i', $this->user_agent)) {
      $this->browser_name = 'Firefox';
    } elseif(preg_match('/Chrome/i', $this->user_agent)) {
      $this->browser_name = 'Chrome';
    } elseif(preg_match('/Safari/i', $this->user_agent)) {
      $this->browser_name = 'Safari';
    } elseif(preg_match('/Opera/i', $this->user_agent)) {
      $this->browser_name = 'Opera';
    } elseif(preg_match('/Netscape/i', $this->user_agent)) {
      $this->browser_name = 'Netscape';
    }
  }

  public function get_browser_details_HTML(){
    $bd = new self;
    $bd->detect();
    date_default_timezone_set('Asia/Kolkata');
    $date_of_request = date('l, F j, Y g:ia', $_SERVER['REQUEST_TIME']);
    $is_https = isset($_SERVER['HTTPS']) ? 'YES' : 'NO';
    $html = <<<BROWSER_HTML
    <p><big>Remote IP:</big> {$_SERVER['REMOTE_ADDR']}</p>
    <p><big>User Agent:</big> {$_SERVER['HTTP_USER_AGENT']}</p>
    <p><big>Platform:</big>  {$bd->platform}</p>
    <p><big>Browser:</big> {$bd->browser_name}</p>
    <p><big>Referer:</big> {$_SERVER['HTTP_REFERER']}</p>
    <p><big>Request Time (Unix):</big> {$_SERVER['REQUEST_TIME']}</p>
    <p><big>Request Time (formatted):</big> {$date_of_request}</p>
    <p><big>Request URI:</big> {$_SERVER['REQUEST_URI']}</p>
    <p><big>Request Method:</big> {$_SERVER['REQUEST_METHOD']}</p>
    <p><big>Query String:</big> {$_SERVER['QUERY_STRING']}</p>
    <p><big>HTTP Accept:</big> {$_SERVER['HTTP_ACCEPT']}</p>
    <p><big>HTTP Accept Charset:</big> {$_SERVER['HTTP_ACCEPT_CHARSET']}</p>
    <p><big>HTTP Accept Encoding:</big> {$_SERVER['HTTP_ACCEPT_ENCODING']}</p>
    <p><big>HTTP Accept Language:</big> {$_SERVER['HTTP_ACCEPT_LANGUAGE']}</p>
    <p><big>HTTPS ?:</big>  {$is_https}</p>
    <p><big>Remote Port:</big> {$_SERVER['REMOTE_PORT']}</p>
    BROWSER_HTML;
  return $html;
  }

}
  
?>