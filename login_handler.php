<?php 
require_once('private/initialize.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $return = [];
  
  $user['email'] = $_POST['email'] ?? "";
  $user['password'] = $_POST['password'] ?? "";
  
  if (is_blank($user['email']) || is_blank($user['password'])) {
    $return['errors'] = true;
  }

  if (count($errors) == 0) {
    $find_user = find_user_by_email($user['email']);

    if ($find_user == "dberror") {
      $return['dberror'] = true;
    } else if ($find_user['email']) {
      if (!password_verify($user['password'], $find_user['hashed_password'])) {
        $return['errors'] = "error";
      } else {
        // successfully logged in
        // set session variables 
        log_in_user($find_user);
        $return['userid'] = $find_user['id'];
      }
    } else {
      // user not found in db
      $return['errors'] = true;
    }
  }

  header("Content-Type: application/json");
  echo json_encode($return);
}

?>