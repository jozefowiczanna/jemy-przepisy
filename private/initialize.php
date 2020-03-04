<?php
  ob_start();
  session_start();

  define("PRIVATE_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("SHARED_PATH", PRIVATE_PATH . '/shared');
  define("UPLOADS_PATH", PROJECT_PATH . '/assets/images/food/');

  require_once('messages.php');
  require_once('functions.php');
  require_once('database.php');
  require_once('validation.php');
  require_once('query_functions.php');
  require_once('auth_functions.php');

  $db = db_connect();
  $errors = [];

?>
