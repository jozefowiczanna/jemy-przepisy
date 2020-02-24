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
    /*
    użytkownik wybiera przy pomocy radio button kolumnę wg której sortuje przepisy
    Teoretycznie użytkownik może zmienić wartość value wybranego inputa na własną przed wysłaniem formularza
    
    PDO nie umożliwia ustawienia bindParam/bindValue dla NAZWY kolumny, tylko dla jej WARTOŚCI
    Dlatego najlepszą formą walidacji jest w takim przypadku sprawdzenie czy wartość $sort odpowiada wartości 1 z konkretnych kolumn
    */

    
    if (isset($options['sort'])) {
      $sort = ($options['sort'] == "num_likes") ? "num_likes" : "date_added";
    } else {
      $sort = $options['sort'] ?? "date_added";
    }
    
    // 1. STWORZENIE ZAPYTANIA
    $sql = "SELECT r.*, c.category FROM recipes r ";
    $sql .= "JOIN categories c ON r.category_id = c.id ";
    if ($category != "all") {
      $sql .= "WHERE category_id = '1' ";
    }
    if ($userid) {
      $sql .= "WHERE user_id = :userid ";
    }
    $sql .= "ORDER BY $sort DESC";

    // 2. PRZYPISANIE PARAMETRÓW
    $stmt = $db->prepare($sql);
    // Wyszukiwanie przepisów w konkretnej kategorii
    if ($category != "all") {
      $stmt->bindParam(':category', $category);
    }
    // Wyszukiwanie przepisów autorstwa konkretnego użytkownika
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

  function find_all_categories() {
    global $db;

    $sql = "SELECT * FROM categories";
    $result = $db->query($sql);

    return $result;
  }

  function find_user_by_email($email) {
    global $db;

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $errorInfo = $stmt->errorInfo();
    if (isset($errorInfo[2])) {
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
    $errorInfo = $stmt->errorInfo();
    if (isset($errorInfo[2])) {
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


?>