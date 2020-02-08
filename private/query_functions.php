<?php 

  function find_latest_recipe() {
    global $db;

    $sql = "SELECT * FROM recipes ";
    $sql .= "ORDER BY date_added ";
    $sql .= "DESC LIMIT 1";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recipe = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return $recipe;
  }

  function find_most_liked_recipe() {
    global $db;

    $sql = "SELECT * FROM recipes ";
    $sql .= "ORDER BY num_likes ";
    $sql .= "DESC LIMIT 1";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $recipe = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return $recipe;
  }

  function find_top_recipe($condition) {
    global $db;

    $sql = "SELECT * FROM recipes R LEFT JOIN categories C ON R.category = C.id  ORDER BY " . $condition . " DESC LIMIT 1";
    $result = mysqli_query($db, $sql);
    return mysqli_fetch_assoc($result);

  }

?>