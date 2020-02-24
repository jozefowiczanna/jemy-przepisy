<?php 

  
if (isset($recipe['label'])) {
  // main page - 2 recipes in a row, each with label
  $class = "";
  if ($recipe['label'] === "najświeższy") {
    $label = "<div class='card__label'>najświeższy</div>";
  } else if ($recipe['label'] === "najsmaczniejszy") {
    $label = "<div class='card__label card__label--secondary'>najsmaczniejszy</div>";
  }
} else {
  // recipes page - max 3 recipes in a row
  $class = "col-3";
}

?>

<article class="card col-2 <?php echo $class; ?>">
  <?php if(isset($label)){ echo $label; } ?>
  <a href="show.php?id=<?php echo $recipe['id'] ?>" class="card__header">
    <div class="card__img-holder card__img-holder--big">
      <div class="card__img" style="background-image: url(assets/images/food/<?php echo $recipe['img'] ?>)"></div>
    </div>
    <h3 class="card__title"><?php echo h($recipe['recipe_name']); ?></h3>
  </a>
  <div class="card__body">
    <div class="card__author"><?php echo h($recipe['username']); ?></div>
    <div class="card__date"><?php echo h($recipe['date_added']); ?></div>
    <div class="card__category"><?php echo h($recipe['category']); ?></div>
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
    </div>
  </div>
</article><!-- card -->