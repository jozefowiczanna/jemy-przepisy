<?php 
  require_once('private/initialize.php'); 

?>

<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section">
  <div class="container">
    <h1 class="section__title section__title--centered">Zarejestruj się</h1>
    <form action="send-script.php" method="post" class="form form--flex form--centered js-form-register">
      <div class="form__row">
        <label for="username" class="form__label"><span class="form__label">Pseudonim
          <span class="form__label-info">(widoczny dla innych użytkowników)</span>
        </label>
        <input type="text" id="username" name="username" class="form__input" autocomplete="off">
        <p class="form__error">Pseudonim musi składać się z 3-50 znaków, bez znaków specjalnych "<>"</p>
      </div>
      <div class="form__row">
        <label for="email" class="form__label">Email 
          <span class="form__label-info">(wymagany tylko przy logowaniu, niewidoczny dla innych)</span>
        </label>
        <input type="text" id="email" name="email" class="form__input" autocomplete="off">
        <p class="form__error">Niepoprawny format adresu email</p>
        <p class="form__error js-user-exists">Użytkownik z takim adresem email już istnieje w naszej bazie.</p>
      </div>
      <div class="form__row">
        <label for="password" class="form__label">Hasło</label>
        <input type="password" id="password" name="password" class="form__input" autocomplete="off">
        <p class="form__error">Hasło musi składać się z 6-30 znaków (bez polskich znaków), w tym co najmniej 1 litery i 1 cyfry</p>
      </div>
      <div class="form__row">
        <label for="password2" class="form__label">Powtórz hasło</label>
        <input type="password" id="password2" name="password2" class="form__input" autocomplete="off">
        <p class="form__error">Hasła muszą być identyczne</p>
      </div>
      <button class="cta-btn form__btn" type="submit" name="btn-submit">Zarejestruj się</button>
      <p class="form__info">Masz już konto?</p>
      <a href="#" class="link form__link">Zaloguj się!</a>
    </form>
  </div>
</section>
  
<?php include(SHARED_PATH . '/footer.php'); ?>