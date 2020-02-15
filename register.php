<?php 
  require_once('private/initialize.php'); 
?>

<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section">
  <div class="container">
    <h1 class="section__title">Zarejestruj się</h1>
    <form action="register.php" method="post" class="form form--flex">
      <div class="form__row">
        <label for="nick" class="form__label"><span class="form__label">Pseudonim
          <span class="form__label-info">(widoczny dla innych użytkowników)</span>
        </label>
        <input type="text" id="nick" name="nick" class="form__input">
        <div class="form__error">Pseudonim może zawierać tylko litery, cyfry i znak spacji</div>
      </div>
      <div class="form__row">
        <label for="email" class="form__label">Email 
          <span class="form__label-info">(wymagany tylko przy logowaniu, niewidoczny dla innych)</span>
        </label>
        <input type="email" id="email" name="email" class="form__input">
        <div class="form__error">Niepoprawny format adresu email</div>
      </div>
      <div class="form__row">
        <label for="password" class="form__label">Hasło</label>
        <input type="password" id="password" name="password" class="form__input">
        <div class="form__error">Hasło musi składać się z co najmniej 8 znaków, w tym jednej 1&nbspwielkiej litery, 1 małej litery i 1 cyfry</div>
        <!-- "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" -->
      </div>
      <div class="form__row">
        <label for="password-confirm" class="form__label">Powtórz hasło</label>
        <input type="password" id="password-confirm" name="password-confirm" class="form__input">
        <div class="form__error">Hasła muszą być identyczne</div>
      </div>
      <button class="cta-btn form__btn" type="submit" name="submit">Zarejestruj się</button>
      <div class="form__info">Masz już konto?</div>
      <a href="#" class="link form__link">Zaloguj się!</a>
    </form>
  </div>
</section>



  
<?php include(SHARED_PATH . '/footer.php'); ?>