<?php
  ob_start(); // turn on output buffering
  // Assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define("CONFIG_PATH", dirname(__FILE__));
  define("PRIVATE_PATH", dirname(CONFIG_PATH));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", PROJECT_PATH . '/public');
  define("SHARED_PATH", PRIVATE_PATH . '/shared');
  define("LOG_PATH", PRIVATE_PATH . '/log');
  define("SITE_NAME", 'Save Notes');
  define("COMPANY_EMAIL", 'bbcarljohnson@gmail.com');

// echo CONFIG_PATH;
// echo "<br>";
// echo PRIVATE_PATH;
// echo "<br>";
// echo PROJECT_PATH;
// echo "<br>";

 //  define('COMMON_PATHS', array(
 // ));

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '/~kevinskoglund/chain_gang/public');
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/public"
  /**
  * Add 7 inplace of 0 to use public in URL
  * I replaced 7 with 0 because I don't want to include public in URL.
  */
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 0;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  require_once(PRIVATE_PATH . '/functions/common_functions.php');
  function is_this_ajax_request() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
  }
  // Useful when user makes an AJAX request but user isn't connected to the internet.
  if(is_this_ajax_request() && (is_connected_to_internet() === false)){
    $send_array = ['internet_connection'=> false];
    echo json_encode($send_array);
    exit;
  }
  require_once(PRIVATE_PATH . '/functions/functions.php');
  require_once(PRIVATE_PATH .'/functions/db_credentials.php');
  require_once(PRIVATE_PATH .'/functions/database_functions.php');
  require_once(PRIVATE_PATH . '/functions/validation_functions.php');
  require_once(PRIVATE_PATH . '/functions/status_error_functions.php');

  // Load class definitions manually

  // -> Individually
  // require_once('classes/bicycle.class.php');

  // -> All classes in directory
/*  foreach(glob('classes/*.class.php') as $file) {
    require_once($file);
  }*/

  // the file name of the class must be same as the name of the class.
  // Autoload class definitions
  function my_autoload($class) {
    if(preg_match('/\A\w+\Z/', $class)) {
      include(PRIVATE_PATH.'/classes/' . $class . '.class.php');
    }

  }
  spl_autoload_register('my_autoload');


  /* openning DB connection */
  $database = db_connect();
  DatabaseObject::set_database($database);

  /* initialize session */
  $session = new Session;
  /* logger */
  $logger = new Logger;


?>
