<?php 
  require_once('private/initialize.php'); 

  $search['category'] = $_POST['category'] ?? 'all';

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $recipe = find_recipe_by_id($id);
    if ($recipe === "dberror") {
      $msg = $errors_list['db'];
      fatal_error_display($msg);
    }
    // no recipe found
    if (!$recipe) {
      header("Location: index.php");
    }

  } else {
    header("Location: login.php");
  }

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
  }

  if ($recipe['user_id'] != $_SESSION['user_id']) {
    header("Location: index.php");
  }

?>

<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section">
  <div class="container">
    <h1 class="section__title section__title--centered">Dodaj przepis</h1>

    <form action="private/handlers/edit_handler.php" method="post" class="form form--flex form--wide js-form-add">
      <div class="form__row">
        <label for="recipe_name" class="form__label">Nazwa</label>
        <input type="text" id="recipe_name" name="recipe_name" class="form__input js-check" autocomplete="off">
        <p class="form__error">Nazwa musi składać się z 3-100 znaków. Nie może zawierać znaków specjalnych "<>"</p>
      </div>
      <div class="form__row">
        <label for="description" class="form__label">Opis (opcjonalnie)</label>
        <textarea name="description" id="description" cols="30" rows="6" class="form__textarea"></textarea>
      </div>
      <div class="form__row">
        <label for="category_id" class="form__label">Kategoria</label>
        <select class="form__select" name="category_id" id="category_id">
          <?php 
            $categories = find_all_categories();
            foreach($categories as $cat) {
              echo "<option value='" . $cat['id'] . "'";
              if ($cat['id'] == $search['category']) {
                echo " selected";
              }
              echo ">" . $cat['category'] . "</option>";
            }
          ?>
        </select>
        <p class="form__error">Błąd</p>
      </div>
      <div class="form__row">
        <label for="ingredients" class="form__label">Składniki</label>
        <textarea name="ingredients" id="ingredients" cols="30" rows="10" class="form__textarea js-check" placeholder="Składniki oddziel enterem"></textarea>
        <p class="form__error">To pole nie może być puste</p>
      </div>
      <div class="form__row">
        <label for="preparation" class="form__label">Sposób przygotowania</label>
        <textarea name="preparation" id="preparation" cols="30" rows="10" class="form__textarea js-check" placeholder="Kolejne kroki oddziel enterem"></textarea>
        <p class="form__error">To pole nie może być puste</p>
      </div>
      <div class="form__row">
        <label for="prep_time" class="form__label">Czas przygotowania (w minutach)</label>
        <input type="text" id="prep_time" name="prep_time" class="form__input form__input--narrow js-check" maxlength="4" autocomplete="off">
        <p class="form__error">Pole powinno zawierać tylko cyfry</p>
      </div>
      <div class="form__row">
        <label for="difficulty" class="form__label">Poziom trudności</label>
        <select class="form__select form__select--narrow" name="difficulty" id="difficulty">
          <option value="1">Łatwy</option>
          <option value="2">Średni</option>
          <option value="3">Trudny</option>
        </select>
        <p class="form__error">Błąd</p>
      </div>
      <button class="cta-btn form__btn" type="submit" name="btn-submit">Edytuj</button>
    </form>
  </div>
</section>
<script src="assets/js/edit.js"></script>
<script src="assets/js/addrecipe.js"></script>
<?php include(SHARED_PATH . '/footer.php'); ?>