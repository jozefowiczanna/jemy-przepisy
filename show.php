<?php 
  require_once('private/initialize.php'); 

  $id = $_GET['id'] ?? '1';
  if ($_GET['id']) {
    $recipe = find_recipe_by_id($id);
  } else {
    header("Location: index.php");
  }

?>

<?php $page_title = 'Przepis'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section">
  <div class="container">
    <div class="flex-row">
      <div class="col-2">
        <h1 class="section__title"><?php echo $recipe['recipe_name']; ?></h1>
        <p class="section__author">autor: 
        <a href="<?php echo "profil.php?id=" . $recipe['user_id'] ?>"><?php echo $recipe['username']; ?></a>
        <p class="section__para"><?php echo $recipe['category']; ?></p>
        <div class="card__iconset">
          <div class="card__icon">
            <img src="assets/images/icons/schedule-24px.svg" alt="czas przygotowania" class="card__icon-img">
            <div class="card__icon-desc"><?php echo h($recipe['prep_time']); ?> min</div>
          </div>
          <div class="card__icon">
            <img src="assets/images/icons/my-level<?php echo $recipe['difficulty']; ?>-24px.svg" alt="czas przygotowania" class="card__icon-img">
            <div class="card__icon-desc"><?php echo h($recipe['difficulty_desc']); ?></div>
          </div>
          <div class="card__icon">
            <img src="assets/images/icons/thumb_up-24px.svg" alt="czas przygotowania" class="card__icon-img">
            <div class="card__icon-desc"><?php echo h($recipe['num_likes']); ?></div>
          </div>
        </div><!-- card__iconset -->
        <p class="section__para"><?php echo h($recipe['description']); ?></p>
      </div>
      <div class="col-2">
        <img class="section__img" src="assets/images/food/<?php echo $recipe['img']; ?>" alt="">
      </div>
    </div>
    <div class="flex-row">
      <div class="col-2">
        <div class="ingred">
          <h2 class="ingred__title">Składniki</h2>
          <ul class="ingred__list">
            <?php 
            
            $pieces = explode("<br />", $recipe['ingredients']);
            
            foreach($pieces as $piece) {
              $piece = trim($piece);
              if (!empty($piece)) {
                echo "<li class='ingred__item'>" . $piece . "</li>";
              }
            }
            
            ?>
          </ul>
        </div>
      </div><!-- col -->

      <div class="col-2">
        <div class="prep">
          <h2 class="prep__title">Sposób przygotowania</h2>
          <ul class="prep__list">
            <?php 
            
            $pieces = explode("<br />", $recipe['preparation']);
            
            foreach($pieces as $piece) {
              $piece = trim($piece);
              if (!empty($piece)) {
                echo "<li class='prep__item'>" . $piece . "</li>";
              }
            }
            
            ?>
          </ul>
        </div>
      </div><!-- col -->

    </div>
  </div>
</section>


<?php include(SHARED_PATH . '/footer.php'); ?>