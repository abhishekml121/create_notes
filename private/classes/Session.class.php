<?php
class Session {

  private $user_id;
  public $username;
  private $domain;
  //private $last_login;

  //public const MAX_LOGIN_AGE = time()+60*60*24*365; //1 year

  public function __construct() {
    session_start();
    $this->check_stored_login();
    $this->domain = get_domain_name_for_cookie();
  }

  public function login($admin) {
    if($admin) {
      // echo 'logging in............';
      // prevent session fixation attacks
      session_regenerate_id();
      /*$this->user_id = $_SESSION['user_id'] = $admin->id;
      $this->username = $_SESSION['username'] = ($admin->username == '')  ? $admin->email : $admin->username;
      $this->last_login = $_SESSION['last_login'] = time();
      */
     $this->user_id = $admin->id;
     $this->username = ($admin->username == '')  ? $admin->email : $admin->username;
     setcookie('user_id', $this->user_id, time()+60*60*24*365, '/', $this->domain  , false);
     setcookie('username', $this->username, time()+60*60*24*365, '/', $this->domain , false);
    }
    return true;
  }

  public function is_logged_in() {
    //return isset($this->user_id) && $this->last_login_is_recent();
    return isset($this->user_id) && isset($_COOKIE['user_id']);
  }

  public function logout() {
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', null, -1, '/',$this->domain); 
        setcookie('username', null, -1, '/', $this->domain);
        unset($_COOKIE['user_id']);
        unset($_COOKIE['username']);
        unset($_SESSION['note_id']);
        unset($this->user_id);
        unset($this->username);  
        return true;
    } else {
        return false;
    }
  }

  private function check_stored_login() {
    if(isset($_COOKIE['user_id'])) {
      $this->user_id = $_COOKIE['user_id'];
      $this->username = $_COOKIE['username'];
      //$this->last_login = $_SESSION['last_login'];
    }
  }

  // private function last_login_is_recent() {
  //   if(!isset($this->last_login)) {
  //     return false;
  //   } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
  //     return false;
  //   } else {
  //     return true;
  //   }
  // }

  public function message($msg="") {
    if(!empty($msg)) {
      // Then this is a "set" message
      $_SESSION['message'] = $msg;
      return true;
    } else {
      // Then this is a "get" message
      return $_SESSION['message'] ?? '';
    }
  }

  public function clear_message() {
    unset($_SESSION['message']);
  }
}

?>
