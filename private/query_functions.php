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
    $sql .= "WHERE r.id = :id LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if (check_for_error($stmt)) {
      return "dberror";
    } else {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $user = find_user_by_id($row['user_id']);
  
      if ($user) {
        $row['date_added'] = datetime_to_date($row['date_added']);
        $row['difficulty_desc'] = get_difficulty_desc($row['difficulty']);
        $row['username'] = $user['username'];
      }
  
      return $row;
    }

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

    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
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

  function update_image($recipe, $newimg, $remove_prev_img) {
    global $db;

    // $remove_prev_img - if true user's image has to be removed before uploading new one
    // if false - default image has been used - no image to be removed
    if ($remove_prev_img) {

      $old_filename = $recipe['img'];

      $file_pointer = '../assets/images/food/d2.jpg'; 
  
      if (file_exists($file_pointer))  
      { 
          echo "The file $file_pointer exists"; 
          // $deleted = unlink($file_pointer);
          // if ($deleted) {
          //   echo "FILE REMOVED";
          // } else {
          //   echo "file NOT removed";
          // }
      } 
      else 
      { 
          echo "The file $file_pointer does 
                                  not exists"; 
      } 
          }

  }

  function update_img_path($id, $new_filename) {
    global $db;

    $sql = "UPDATE recipes SET img = :img WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':img', $new_filename);
    $result = $stmt->execute();
    if (check_for_error($stmt)) {
      return "dberror";
    }

    return $result;
  }

  function restore_default_image($recipe) {
    global $db;

    // check if hasn't already been set to default
    if ($recipe['img'] != "default.jpg") {
      $file_pointer = UPLOADS_PATH . $recipe['img'];
      if (file_exists($file_pointer)) {
        $removed = unlink($file_pointer);
        if ($removed) {
          // if file was succesfully removed, link has to updated to default
          $new_filename = "default.jpg";
          $result = update_img_path($recipe['id'], $new_filename);

          return $result;
        } else {
          return "dberror";
        }
      }
    }
  }

  function add_image($recipe, $files) {
    global $db;
    global $errors_list;

    $errors = [];
    // due to limited database space, 1 image per recipe is allowed
    // if value == default - default image is used, user can add image
    // if value != default - it means user has already added image to this recipe
    // replace_image function should be used - old image has to be removed before adding a new one
    
    if (empty($files['fileToUpload']['name'])) {
      array_push($errors, $errors_list['no_file_chosen']);
      return $errors;
    } else {
      $filename = basename($_FILES["fileToUpload"]["name"]);
      $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
      
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      $image_type = $check[2];
      
      if(in_array($image_type, array(IMAGETYPE_JPEG, IMAGETYPE_PNG))) {
      } else {
        array_push($errors, $errors_list['wrong_file_format']);
      }
      
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 1000000) {
        array_push($errors, $errors_list['wrong_file_size']);
      }
      
      if (count($errors) > 0) {
        // file is not valid
        return $errors;
      } else {
        // file is valid, generate unique name and upload it to server
        $uniqid = time().uniqid(rand());
        $target_dir = UPLOADS_PATH;
        // add recipe id to file name so it can be matched with recipe 
        // (for example: if it fails to update the image name in the database)
        $recipeid = $recipe['id'];
        $new_filename = "$uniqid-id$recipeid.$imageFileType";
        $path = $target_dir . $new_filename;

        // if user has already uploaded image for this recipe
        // previous image has to be removed before updating new one
        if ($recipe['img'] !== "default.jpg") {
          $restore = restore_default_image($recipe);
          if ($restore === "dberror") {
            array_push($errors, $errors_list['db']);
            return $errors;
          }
        }

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path)) {
          // file has been added, db link has to updated
          $result = update_img_path($recipe['id'], $new_filename);
          if ($result === "dberror") {
            array_push($errors, $errors_list['db']);
            return $errors;
          } else {
            return "success";
          }
        } else {
          array_push($errors, $errors_list['upload_failed']);

          return $errors;
        }
      }
    }

    // *********
    if ($recipe['img'] == "default.jpg") {
      // add file
      
    }
  }

?>