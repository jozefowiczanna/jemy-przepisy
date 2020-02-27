<?php 

  function check_for_error($stmt) {
    $errorInfo = $stmt->errorInfo();
    if (isset($errorInfo[2])) {
      return true;
    }
  }

  function return_error_msg($stmt) {
    $errorInfo = $stmt->errorInfo();
    if (isset($errorInfo[2])) {
      return $errorInfo[2];
    }
  }

  function find_recipe_by_id($id) {
    global $db;

    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    $sql .= "WHERE r.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $row = $stmt->fetch();

    // Pobranie danych o autorze przepisu
    $user = find_user_by_id($row['user_id']);

    
    $row['date_added'] = datetime_to_date($row['date_added']);
    $row['difficulty_desc'] = get_difficulty_desc($row['difficulty']);
    $row['username'] = $user['username'];

    return $row;
  }

  function find_recipes($options=[]) {
    global $db;

    $category = $options['category'] ?? "all";
    $userid = $options['user_id'] ?? false;
    
    if (isset($options['sort'])) {
      $sort = ($options['sort'] == "num_likes") ? "num_likes" : "date_added";
    } else {
      $sort = $options['sort'] ?? "date_added";
    }
    
    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    if ($category != "all") {
      $sql .= "WHERE category_id = :category ";
    }
    if ($userid) {
      $sql .= "WHERE user_id = :userid ";
    }
    $sql .= "ORDER BY $sort DESC";

    $stmt = $db->prepare($sql);
    if ($category != "all") {
      $stmt->bindParam(':category', $category);
    }
    if ($userid) {
      $stmt->bindParam(':userid', $userid);
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

    $user = find_user_by_id($row['user_id']);
    $row['username'] = $user['username'];

    return $row;
  }

  // ulubione przepisy użytkownika
  function find_users_favorite_recipes($userid) {
    global $db;

    $sql = "SELECT r.recipe_name, r.id FROM likes l JOIN recipes r ON l.recipe_id = r.id ";
    $sql .= "WHERE l.user_id = :userid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
    if (check_for_error($stmt)) {
      return "dberror";
    }

    return $stmt;
  }

  function find_all_categories() {
    global $db;

    $sql = "SELECT * FROM categories";
    $result = $db->query($sql);

    return $result;
  }

  function find_all_users() {
    global $db;

    $sql = "SELECT * FROM users ORDER BY username";
    $result = $db->query($sql);

    return $result;
  }

  function find_user_by_email($email) {
    global $db;

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if (check_for_error($stmt)) {
      return "dberror";
    }
    $result = $stmt->fetch();

    return $result;
  }

  function find_user_by_id($id) {
    global $db;

    $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if (check_for_error($stmt)) {
      return "dberror";
    }
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

  function insert_recipe($recipe) {
    global $db;

    $date_added = date("Y-m-d H:i:s");

    $sql = "INSERT INTO recipes (`recipe_name`, `user_id`, `description`, `category_id`, `ingredients`, `preparation`, `prep_time`, `difficulty`, `img`, `date_added`, `num_likes`) ";
    $sql .= "VALUES (:recipe_name, :user_id, :description, :category_id, :ingredients, :preparation, :prep_time, :difficulty, :img, '$date_added', '0')";
    $stmt = $db->prepare($sql);
    foreach($recipe as $key => &$value) {
      $stmt->bindParam($key, $value);
    }
    $result = $stmt->execute();
    // $msg = return_error_msg($stmt);
    // echo $msg;

    return $result;
  }


?>