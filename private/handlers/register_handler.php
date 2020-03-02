<?php 
require_once('../../private/initialize.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  
  $errors = [];
  $return = [];
  
  $user['username'] = $_POST['username'] ?? "";
  $user['email'] = $_POST['email'] ?? "";
  $user['password'] = $_POST['password'] ?? "";
  $user['password2'] = $_POST['password2'] ?? "";

  $regex['username'] = '/^[^<>]{3,50}$/';
  $regex['email'] = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
  $regex['password'] = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,30}$/';
  $regex['password2'] = $regex['password'];
  
  $errors = validateRegex($user, $regex);

  if (count($errors) > 0) {
    $return["errors"] = $errors;
  }

  $find_user = find_user_by_email($user['email']);

  if ($find_user) {
    $return['userexists'] = "true";
  } 
  
  if (!$find_user && !isset($return["errors"])) {
    $insert = insert_user($user);
    if($insert) {
      // User has been added to db
      
      // Need to set session variable containing user id to keep him logged in
      // lastInsertId is not recommended, so find user query has to be made
      // TODO check if there is a better solution
      $find_user = find_user_by_email($user['email']);
      if ($find_user) {
        $_SESSION['user_id'] = $find_user['id'];
        $return['loggedin'] = true;
      }
      $return['status'] = "success";
    } else {
      $return['status'] = "fail";
    }
  }

  header("Content-Type: application/json");
  echo json_encode($return);
}

?>