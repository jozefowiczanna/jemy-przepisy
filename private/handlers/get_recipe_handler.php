<?php 
require_once('../../private/initialize.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $json = file_get_contents('php://input');
  $data = json_decode($json);
  $test = $_POST['id'] ?? "";
  $id = $data->id;
  $return = [];
  
  $recipe = find_recipe_by_id($id);
  if ($recipe) {
    $return['recipe'] = $recipe;
  } else {
    $return['recipe'] = false;
  }

  header("Content-Type: application/json");
  echo json_encode($return);
}

?>