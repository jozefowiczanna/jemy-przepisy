<?php 
  require_once('private/initialize.php'); 
?>

<?php include(SHARED_PATH . '/header.php'); ?>
    <section class="section">
      <div class="container">
        <div class="flex-row">
          <div class="col-2">
            <h1 class="section__title section__title--big">Jemy!</h1>
            <p class="section__para">Jemy! to strona na której możesz dodawać i lajkować przepisy. Stworzyłam ją od podstaw, żeby nauczyć się pisania praktycznych projektów wykorzystując technologie:.</p>
            <p class="section__para">Kliknij  <a href="#" class="link">tutaj</a>, aby zobaczyć repozytorium projektu na GitHubie.</p>
            <p class="section__para">Kliknij <a href="#" class="link">tutaj</a>, żeby zobaczyć inne projekty mojego autorstwa.</p>
            <p class="section__para">Aby dodać lub polubić przepis, musisz się <a href="login.php" class="link">zalogować</a>. Jeśli jeszcze nie masz konta, <a href="register.php" class="link">zarejestruj się</a> - wystarczy login i hasło.</p>
            <a href="recipes.php" class="cta-btn">Szukaj przepisów</a>
          </div>
          <div class="col-2 d-none">
            <div class="main-img"></div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <h2 class="section__title">Wyróżnione przepisy</h2>
        <div class="flex-row">

        <?php 
          $recipe = find_top_recipe("date_added");
          include(SHARED_PATH . '/recipe.php');

          $recipe = find_top_recipe("num_likes");
          include(SHARED_PATH . '/recipe.php');
        ?>
          
        </div>

      </div>
    </section>
  <?php include(SHARED_PATH . '/footer.php'); ?>