<?php 
  require_once('private/initialize.php');

  $user_error_msg = false;
  $is_logged_user_profile = false;

  // Pobieranie danych TYLKO jeśli url posiada parametr id
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user = find_user_by_id($_GET['id']);
    if ($user == "dberror") {
      // Błąd bazy przy pobieraniu informacji o użytkowniku
      $user_error_msg = $errors_list['db'];
    } else if(!$user) {
      // Brak wyników dla danego id
      $user_error_msg = $errors_list['no_user_found'];
    }
  // Brak parametru id w url
  } else {
    // Zalogowany użytkownik > przekierowanie na jego profil
    if (isset($_SESSION['user_id'])) {
      header("Location: profil.php?id=" . $_SESSION['user_id']);
    // Niezalogowany użytkownik > przekierowanie na stronę logowania
    } else {
      header("Location: login.php");
    }
  }
  
  // Sprawdzenie czy użytkownik jest zalogowany
  if (isset($_SESSION['user_id'])) {
    // Sprawdzenie czy użytkownik jest na własnym profilu
    // Jeśli tak, zmienna posłuży do wyświetlenia dodatkowych opcji
    if ($user['id'] === $_SESSION['user_id']) {
      $is_logged_user_profile = true;
    }
  } else {
    $is_logged_user_profile = false;
  }

?>

<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section">
  <div class="container">
    <?php 
    if ($is_logged_user_profile) {
      echo "<h1 class='section__title'>Twój profil</h1>";
    } else {
      echo "<h1 class='section__title'>Profil użytkownika</h1>";
    }
    ?>
    <?php 
      if ($user_error_msg) {
        fatal_error_display($user_error_msg);
        exit();
      }
    ?>

      <div class="section__box">
        <p class='p'><b>Nazwa użytkownika:</b> <?php echo $user['username']; ?> </p>
        <p class='p'><b>Data dołączenia:</b> <?php echo datetime_to_date($user['signup_date']); ?> </p>
      </div>

    <?php 
      // Jeśli profil użytkownika = aktualnie wyświetlany profil
      if ($is_logged_user_profile): ?>
      <div>
        <a href="dodaj.php" class="cta-btn">Dodaj przepis</a>
      </div>
    <?php endif; ?>

    <div class="section__subsection">
      <h2>Przepisy</h2>
      <?php 
      // Przepisy użytkownika wyszukane na bazie id
      $options['user_id'] = $user['id'];
      $recipes = find_recipes($options);
      $num_rows = $recipes->rowCount();
      ?>
      <ul class="ingred__list">
        <?php
        if ($num_rows > 0):
          while ($row = $recipes->fetch()):
          ?>
          <li class="ingred__item">
            <a href="show.php?id=<?php echo $row['id']; ?>" class="link">
              <?php echo $row['recipe_name']; ?>
            </a>
            <?php if ($is_logged_user_profile): ?>
              <a href="edit.php?id=<?php echo $row['id'] ?>" class="cta-btn cta-btn--small">Edytuj</a>
            <?php endif; ?>
          </li>
          <?php
          endwhile;
        else:?>
        <li>Użytkownik nie dodał jeszcze żadnego przepisu.</li>
      <?php 
      endif; ?>
      </ul>
    </div>

    <div class="section__subsection">
      <h2>Polubienia</h2>
      <?php 
      $recipes = find_users_favorite_recipes($user['id']);
      $num_rows = $recipes->rowCount();
      ?>
      <ul class="ingred__list">
        <?php
        if ($num_rows > 0):
          while ($row = $recipes->fetch()):
          ?>
          <li class="ingred__item">
            <a href="show.php?id=<?php echo $row['id']; ?>" class="link">
              <?php echo $row['recipe_name']; ?>
            </a>
            <?php if ($is_logged_user_profile): ?>
              <a href="edit.php?id=<?php echo $row['id'] ?>" class="cta-btn cta-btn--small cta-btn--secondary">Usuń lajka</a>
            <?php endif; ?>
          </li>
          <?php
          endwhile;
        else:?>
          <li>Użytkownik nie polubił jeszcze żadnego przepisu.</li>
        <?php 
        endif; ?>
      </ul>
    </div>

    

  </div>
</section>

<!-- <script src="assets/js/profil.js"></script> -->
<?php include(SHARED_PATH . '/footer.php'); ?>