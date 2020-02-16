<?php 

  function find_recipe_by_id($id) {
    global $db;

    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    $sql .= "WHERE r.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $row = $stmt->fetch();
    $row['date_added'] = datetime_to_date($row['date_added']);
    $row['difficulty_desc'] = get_difficulty_desc($row['difficulty']);

    return $row;
  }

  function find_recipes($options=[]) {
    global $db;
    $category = $options['category'] ?? "all";
    // no PDO bind param for ORDER BY
    // prevent SQL injection by making sure only 1 of 2 values is selected
    $sort = ($options['sort'] == "num_likes") ? "num_likes" : "date_added";

    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    if ($category !== "all") {
      $sql .= "WHERE category_id = :category ";
    }
    $sql .= "ORDER BY $sort DESC";
    $stmt = $db->prepare($sql);
    if ($category !== "all") {
      $stmt->bindParam(':category', $category);
    }
    $stmt->execute();

    return $stmt;
  }

  function find_top_recipe($column) {
    global $db;
    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    $sql .= "ORDER BY $column DESC LIMIT 1";

    $result = $db->query($sql);

    $row = $result->fetch();
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
    $result = $db->query($sql);

    return $result;
  }

  function find_user_by_email($email) {
    global $db;

    $sql = "SELECT email FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch();

    return $result;
  }

  function insert_user($user) {
    global $db;

    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
    $signup_date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO users (username, email, hashed_password, signup_date, num_recipes, num_likes) ";
    $sql .= "VALUES (:username, :email, :hashed_password, '$signup_date', '0', '0')";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $user['username']);
    $stmt->bindParam(':email', $user['email']);
    $stmt->bindParam(':hashed_password', $hashed_password);
    $result = $stmt->execute();

    return $result;
  }

?>