<?php

  require_once('db_credentials.php');

  function db_connect() {
    try {
      $dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8';
      $connection = new PDO($dsn, DB_USER, DB_PASS);
    } catch (Exception $e) {
      $error = $e->getMessage();
      $msg = "Database connection failed: " . $error;
      exit($msg);
    }
    return $connection;
  }

  function db_disconnect($connection) {
    if(isset($connection)) {
      $connection = null;
    }
  }

  function confirm_result_set($result_set) {
    if (!$result_set) {
    	exit("Database query failed.");
    }
  }

?>
