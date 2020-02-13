<?php 
  require_once('private/initialize.php');
  
  $search['category'] = $_POST['category'] ?? 'all';
  $search['sort'] = $_POST['sort'] ?? 'date_added';

  $all_recipes = find_recipes(['sort' => $search['sort'], 'category' => $search['category']]);
?>

<?php  include_once(SHARED_PATH . "/header.php"); ?>

<section class="section">
  <div class="container">
    <h1 class="section__title">Przepisy</h1>
    <form action="recipes.php" method="post" class="form">
      <label class="form__label" for="category">Wybierz kategorię:</label>
      <select class="form__select" name="category" id="category">
        <option value="all">Wszytkie</option>
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
      <p>Sortuj według:</p>
      <div class="form__form-group">
        <input type="radio" name="sort" id="date_added" value="date_added" <?php if ($search['sort'] === "date_added") echo " checked" ?>>
        <label for="date_added">daty dodania</label>
      </div>
      <div class="form__form-group">
        <input type="radio" name="sort" id="num_likes" value="num_likes" <?php if ($search['sort'] === "num_likes") echo " checked" ?>>
        <label for="num_likes">liczby polubień</label>
      </div>
      <button class="cta-btn form__btn" type="submit" name="submit">Szukaj</button>
    </form>

    <?php 
    
    if (!mysqli_num_rows($all_recipes)) {
      echo "<p>Brak wyników.</p>";
    }
    
    ?>

    <div class="flex-row">
    <?php 
      while ($recipe = mysqli_fetch_assoc($all_recipes)) {
        $recipe['date_added'] = datetime_to_date($recipe['date_added']);
        $recipe['difficulty_desc'] = get_difficulty_desc($recipe['difficulty']);
        include(SHARED_PATH . '/recipe.php');
      }
      
    ?>
    </div>
  </div>
</section>

<?php  include_once(SHARED_PATH . "/footer.php"); ?>