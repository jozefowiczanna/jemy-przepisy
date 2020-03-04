<?php 

require_once('../../private/initialize.php');

$search['category'] = $_POST['category'] ?? 'all';

$errors = [];
$return = [];
$recipe = [];


if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // get values which require regex match
  $recipe['recipe_name'] = $_POST['recipe_name'] ?? "";
  $recipe['category_id'] = $_POST['category_id'] ?? "";
  $recipe['prep_time'] = $_POST['prep_time'] ?? "";
  $recipe['difficulty'] = $_POST['difficulty'] ?? "";
  
  $regex_number = '/\d+$/';
  $regex['recipe_name'] = '/^[^<>]{3,50}$/';
  $regex['category_id'] = $regex_number;
  $regex['prep_time'] = $regex_number;
  $regex['difficulty'] = $regex_number;
  
  $errors = validateRegex($recipe, $regex);
  
  // get values for empty string check
  $recipe['ingredients'] = $_POST['ingredients'] ?? "";
  $recipe['preparation'] = $_POST['preparation'] ?? "";
  
  if (is_empty($recipe['ingredients'])) {
    array_push($errors, 'ingredients');
  } else {
    $recipe['ingredients'] = nl2br($recipe['ingredients']);
  }
  if (is_empty($recipe['preparation'])) {
    array_push($errors, 'preparation');
  }else {
    $recipe['preparation'] = nl2br($recipe['preparation']);
  }
  
  // get optional values (no validation required)
  $recipe['description'] = $_POST['description'] ?? "";
  $recipe['description'] = trim($recipe['description']);
  $recipe['description'] = nl2br($recipe['description']);

  // add_handler.php - make sure only logged in user has access to this page, redirect to index page otherwise
  // edit - only logged in user AND author of this recipe should have acces to this page, redirect otherwise
  if (isset($_SESSION['user_id'])) {
    $recipe['user_id'] = $_SESSION['user_id'];
  }
  $recipe['img'] = "default.jpg";
  
  if (count($errors) > 0) {
    // return list of errors - error value = form field id
    $return["errors"] = $errors;
  } else {
    $insert = insert_recipe($recipe);
    if($insert) {
      $return['status'] = "success";
    } else {
      $return['status'] = "fail";
    }
  }

  header("Content-Type: application/json");
  echo json_encode($return);
}


?>