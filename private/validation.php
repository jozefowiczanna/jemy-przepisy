<?php 

function validateRegex($fields, $regs) {
  $errors = [];
  
  foreach ( $fields as $key => $value ) {
    $valid = preg_match($regs[$key], $value);
    if (empty($value) || !$valid) {
      array_push($errors, $key);
    }
  }
  return $errors;
}

function is_empty($value) {
  return trim($value) === '';
}

// function is_blank($value) {
//   return !isset($value) || trim($value) === '';
// }

?>