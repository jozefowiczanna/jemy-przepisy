<?php 
  require_once('private/initialize.php'); 
  // successfully logged in
  // set session variables and redirect to profile page

  // if user logged in redirect to profile page
  


  if (isset($_SESSION['user_id'])) {
    header("Location: profile.php?id=" . $_SESSION['user_id']);
  }
?>

<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section">
  <div class="container">
    <h1 class="section__title section__title--centered">Zaloguj się</h1>

    <form action="private/handlers/login_handler.php" method="post" class="form form--flex form--centered js-form-register">
      <div class="form__row">
        <label for="email" class="form__label">Email</label>
        <input type="text" id="email" name="email" class="form__input" autocomplete="off">
        <p class="form__error">To pole jest obowiązkowe</p>
      </div>
      <div class="form__row">
        <label for="password" class="form__label">Hasło</label>
        <input type="password" id="password" name="password" class="form__input" autocomplete="off">
        <p class="form__error">To pole jest obowiązkowe</p>
        <p class="form__error js-valid-error">Podany login lub hasło jest błędne.</p>
        <p class="form__error js-db-error">Błąd po stronie serwera. Spróbuj później.</p>
      </div>
      <button class="cta-btn form__btn" type="submit" name="btn-submit">Zaloguj się</button>
      <p class="form__info">Nie masz jeszcze konta?</p>
      <a href="register.php" class="link form__link">Zarejestruj się!</a>
    </form>
  </div>
</section>

<script src="assets/js/login.js"></script>
<?php include(SHARED_PATH . '/footer.php'); ?>