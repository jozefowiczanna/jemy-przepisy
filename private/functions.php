<?php 

// ANCHOR alias functions

function h($string="") {
  return htmlspecialchars($string);
}

// ANCHOR query data modifiers

function datetime_to_date($date) { 
  // 2020-02-06 00:00:00 > 2020-02-06
  $new_date = substr($date,0,10);
  return $new_date;
}

function get_difficulty_desc($level) {
  $leve_desc = "";
  switch ($level) {
    case 1:
      $leve_desc = "łatwy";
      break;
    case 2:
      $leve_desc = "średni";
      break;
    case 3:
      $leve_desc = "trudny";
      break;
  }
  return $leve_desc;
}

?>