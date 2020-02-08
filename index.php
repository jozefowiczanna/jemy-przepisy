<?php 
  require_once('private/initialize.php'); 


  $fresh_recipe = find_top_recipe("num_likes");
  $top_recipe = find_most_liked_recipe();

  // shorten datetime to date only
  // 2020-02-06 00:00:00 > 2020-02-06
  $fresh_recipe['date_added'] = substr($fresh_recipe['date_added'],0,10);
  // $test = find_test();
  // echo "<pre>";
  // print_r($test);
  // echo "</pre>";
?>



<?php include(SHARED_PATH . '/header.php'); ?>
    <section class="section">
      <div class="container">
        <div class="flex-row">
          <div class="col-featured">
            <h1 class="section__title section__title--big">Jemy!</h1>
            <p class="section__para">Jemy! to strona na której możesz dodawać i lajkować przepisy. Stworzyłam ją od podstaw, żeby nauczyć się pisania praktycznych projektów wykorzystując technologie:.</p>
            <p class="section__para">Kliknij  <a href="#" class="section__para-link">tutaj</a>, aby zobaczyć repozytorium projektu na GitHubie.</p>
            <p class="section__para">Kliknij <a href="#" class="section__para-link">tutaj</a>, żeby zobaczyć inne projekty mojego autorstwa.</p>
            <p class="section__para">Aby dodać lub polubić przepis, musisz się <a href="#" class="section__para-link">zalogować</a>. Jeśli jeszcze nie masz konta, <a href="#" class="section__para-link">zarejestruj się</a> - wystarczy login i hasło.</p>
            <a href="#" class="cta-btn">Szukaj przepisów</a>
          </div>
          <div class="col-featured d-none">
            <div class="main-img"></div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <h2 class="section__title">Wyróżnione przepisy</h2>
        <div class="flex-row">
          
          <article class="card col-featured">
            <div class="card__label">najświeższy</div>
            <a href="#" class="card__header">
              <div class="card__img-holder card__img-holder--big">
                <div class="card__img" style="background-image: url(assets/images/food/casserole.jpeg)"></div>
              </div>
              <h3 class="card__title"><?php echo $fresh_recipe['recipe_name']; ?></h3>
            </a>
            <div class="card__body">
              <div class="card__author"><?php echo $fresh_recipe['added_by']; ?></div>
              <div class="card__date"><?php echo $fresh_recipe['date_added']; ?></div>
              <div class="card__category"><?php echo $fresh_recipe['category']; ?></div>
              <div class="card__iconset">
                <div class="card__icon">
                  <img src="assets/images/icons/schedule-24px.svg" alt="czas przygotowania" class="card__icon-img">
                  <div class="card__icon-desc"><?php echo $fresh_recipe['prep_time']; ?> min</div>
                </div>
                <div class="card__icon">
                  <img src="assets/images/icons/my-level1-24px.svg" alt="czas przygotowania" class="card__icon-img">
                  <div class="card__icon-desc"><?php echo $fresh_recipe['difficulty']; ?></div>
                </div>
                <div class="card__icon">
                  <img src="assets/images/icons/thumb_up-24px.svg" alt="czas przygotowania" class="card__icon-img">
                  <div class="card__icon-desc"><?php echo $fresh_recipe['num_likes']; ?></div>
                </div>
              </div>
            </div>
          </article><!-- card -->
          
          <article class="card col-featured">
            <div class="card__label card__label--secondary">najsmaczniejszy</div>
            <a href="#" class="card__header">
              <div class="card__img-holder card__img-holder--big">
                <div class="card__img" style="background-image: url(assets/images/food/soup.jpeg)"></div>
              </div>
              <h3 class="card__title">Zupa brokułowa z dynią i pietruszką</h3>
            </a>
            <div class="card__body">
              <div class="card__author">Pan Kucharz</div>
              <div class="card__date">02.01.2020</div>
              <div class="card__category">zupa</div>
              <div class="card__iconset">
                <div class="card__icon">
                  <img src="assets/images/icons/schedule-24px.svg" alt="czas przygotowania" class="card__icon-img">
                  <div class="card__icon-desc">45 min</div>
                </div>
                <div class="card__icon">
                  <img src="assets/images/icons/my-level2-24px.svg" alt="czas przygotowania" class="card__icon-img">
                  <div class="card__icon-desc">średni</div>
                </div>
                <div class="card__icon">
                  <img src="assets/images/icons/thumb_up-24px.svg" alt="czas przygotowania" class="card__icon-img">
                  <div class="card__icon-desc">973</div>
                </div>
              </div>
            </div>
          </article><!-- card -->
        </div>

      </div>
    </section>
  </body>
</html>
