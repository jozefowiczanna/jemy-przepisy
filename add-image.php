<?php 
require_once('private/initialize.php'); 

$errors = [];
$upload_error = false;
$upload_success = false;

$id = $_GET['id'] ?? '';
if ($_GET['id'] && $_SESSION['user_id']) {
  $recipe = find_recipe_by_id($id);
  if (!$recipe) {
    header("Location: index.php");
  }

  if (isset($_POST['btn-remove'])) {
    $reset_img = restore_default_image($recipe);
    if ($reset_img) {
      header("Location: add-image.php?id=" . $id);
    }
  }

  // check for default image
  // if the user has changed default img other options will be shown
  $default_img = ($recipe['img'] == "default.jpg") ? true : false;

  if ($recipe['user_id'] != $_SESSION['user_id']) {
    header("Location: index.php");
  }

} else {
  header("Location: index.php");
}


  if (isset($_POST['add-img'])) {

    $result = add_image($recipe, $_FILES);

    if ($result == "success") {
      echo "success";
      header("Location: add-image.php?status=success&id=" . $id);
    } else {
      $errors = $result;
    }
  }

?>

<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section">
  <div class="container">
    <h1 class="section__title section__title--centered">
    <?php 
    if ($default_img) {
      echo "Dodaj zdjęcie";
    } else {
      echo "Zmień zdjęcie";
    }
    ?>
    </h1>
    <?php if (isset($_GET['status']) && $_GET['status'] = "success"): ?>
    <p class="text-center msg-success">Plik został dodany.</p>
    <?php

      endif; ?>
    <h2><a class="link" href="show.php?id=<?php echo $id; ?>"><?php echo $recipe['recipe_name'] ?></a></h2>
    <div class="flex-row">
      <div class="col-2">
        <div>
          <?php if ($default_img): ?>
            <p class="section__para">Twój przepis jest akutalnie zilustrowany zdjęciem domyślnym. Jeśli chcesz możesz zamiast niego wstawić własne zdjęcie.</p>
            <p class="section__para">Dopuszczalna wielkość zdjęcia wynosi 1 MB.</p>
          <?php else: ?>
            <p class="section__para">Jeśli chcesz zamienić zdjęcie kliknij wybierz plik a następnie “Dodaj”.</p>
            <p class="section__para">Jeśli chcesz usunąć aktualne zdjęcie i przywrocić zdjęcie domyślne, kliknij “Usuń”.</p>
          <?php endif; ?>
          <a href="show.php?id=<?php echo $recipe['id']; ?>" class="link">Wróć do strony z przepisem</a>
        </div>
        <form method="post" enctype="multipart/form-data"  class="form form--center-items">
          <div class="form__row form__row--centered">
            <input type="file" name="fileToUpload" id="file-2" class="inputfile inputfile-2"/>
            <label for="file-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
              <span>Wybierz plik&hellip;</span>
            </label>
    
          </div>
          <?php 
          if ($errors):
            foreach ($errors as $error) {
          ?>
            <p class="form__error form__error--file form__error--centered visible"><?php echo $error; ?></p>
          <?php
            }
          endif;
          ?>
          <button class="cta-btn form__btn" type="submit" name="add-img">
            <?php 
            if ($default_img) {
              echo "Dodaj zdjęcie";
            } else {
              echo "Zmień zdjęcie";
            }
            ?>
          </button>
        </form>
        <?php if (!$default_img): ?>
        <form action="add-image.php?id=<?php echo $id; ?>" method="POST" class="form form--center-items form--auto-margin">
          <button class="cta-btn form__btn cta-btn--secondary js-remove-img" type="submit" name="btn-remove">Przywróć zdj. domyślne</button>
        </form>
        <?php endif; ?>
      </div>
      <div class="col-2">
        <p>Aktualne zdjęcie:</p>
        <img class="section__img" src="assets/images/food/<?php echo $recipe['img']; ?>" alt="">
      </div>
    </div>
    
  </div>
</section>
<script src="assets/js/custom-file-input.js"></script>
<?php include(SHARED_PATH . '/footer.php'); ?>