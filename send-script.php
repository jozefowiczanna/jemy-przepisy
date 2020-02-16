<?php 

// error_reporting(0);

require_once('private/validation.php'); 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  
  $errors = [];
  $return = [];
  
  $user['username'] = $_POST['fusername'] ?? "";
  $user['email'] = $_POST['femail'] ?? "";
  $user['password'] = $_POST['fpassword'] ?? "";
  $user['password2'] = $_POST['fpassword2'] ?? "";

  $regex['username'] = '/^[^<>]{3,50}$/'; // "Pseudonim musi składać się z 3-50 znaków, bez znaków specjalnych <>"
  $regex['email'] = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
  $regex['password'] = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,30}$/'; // "Hasło musi składać się z 6-30 znaków (bez polskich znaków), w tym co najmniej 1 litery i 1 cyfry"
  $regex['password2'] = $regex['fpassword'];
  
  $errors = validateRegex($user, $regex);

  if (count($errors) > 0) {
    $return["errors"] = $errors;
  }

  $find_user = find_user_by_email($user['email']);

  if ($find_user) {
    // echo "Użytkownik z takim emailem już jest w naszej bazie. Wpisz inny adres.";
    $return['userexists'] = "true";
  } else {
    // $insert = insert_user($user);
    // if($insert) {
    //   echo "Rejestracja przebiegła pomyślnie!";
    //   $status = "OK";
    // } else {
    //   echo "Błąd połączenia z serwerem. Spróbuj później";
    //   $status = "FAILED";
    // }
  }

  $return["status"] = "OK";

  header("Content-Type: application/json");
  echo json_encode($return);
}

?>