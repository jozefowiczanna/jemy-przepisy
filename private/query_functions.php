<?php 

  function find_recipe_by_id($id) {
    global $db;

    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    $sql .= "WHERE r.id='" . db_escape($db, $id) . "'";
    $result = mysqli_query($db, $sql);

    $row = mysqli_fetch_assoc($result);
    $row['date_added'] = datetime_to_date($row['date_added']);
    $row['difficulty_desc'] = get_difficulty_desc($row['difficulty']);

    return $row;
  }

  function find_recipes($options=[]) {
    global $db;

    $category = $options['category'] ?? "all";
    $sort = $options['sort'] ?? "date_added";

    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    if ($category !== "all") {
      $sql .= "WHERE category_id='" . $category . "' ";
    }
    $sql .= "ORDER BY " . $sort . " DESC";
    $result = mysqli_query($db, $sql);

    return $result;
  }

  function find_top_recipe($column) {
    global $db;
    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    $sql .= "ORDER BY " . $column . " DESC LIMIT 1";
    $result = mysqli_query($db, $sql);

    $row = mysqli_fetch_assoc($result);
    $row['date_added'] = datetime_to_date($row['date_added']);
    $row['difficulty_desc'] = get_difficulty_desc($row['difficulty']);
    if ($column === "date_added") {
      $row['label'] = "najświeższy";
    } else if ($column === "num_likes") {
      $row['label'] = "najsmaczniejszy";
    }

    return $row;
  }

  function find_all_categories() {
    global $db;

    $sql = "SELECT * FROM categories";
    $result = mysqli_query($db, $sql);

    return $result;
  }

?>