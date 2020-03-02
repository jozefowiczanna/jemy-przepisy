<?php 
  require_once('private/initialize.php');

$users = find_all_users();
?>

<?php  include_once(SHARED_PATH . "/header.php"); ?>

<section class="section">
  <div class="container">
    <h1 class="section__title">Użytkownicy</h1>
    <p class="section__para">Kiknij na kucharza, żeby zobaczyć szczegóły.</p>

    <table class="table">
        <tr class="table__row">
          <th class="table__heading table__heading--left"><img src="assets/images/icons/person-24px-black.svg" alt="nazwa użytkownika" title="nazwa użytkownika" class="table__icon"></th>
          <th class="table__heading"><img src="assets/images/icons/menu_book-24px-black.svg" alt="liczba przepisów" title="liczba przepisów" class="table__icon"></th>
          <th class="table__heading"><img src="assets/images/icons/thumb_up-24px.svg" alt="liczba lajków" title="liczba lajków" class="table__icon"></th>
        </tr>
        <?php while ($row = $users->fetch()): ?>
        <tr class="table__row">
          <td class="table__cell table__cell--left"><a href="profile.php?id=<?php echo $row['id'] ?>" class="table__link"><?php echo $row['username']; ?></a></td>
          <td class="table__cell"><?php echo $row['num_recipes'] ?></td>
          <td class="table__cell"><?php echo $row['num_likes'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
  </div>
</section>

<?php  include_once(SHARED_PATH . "/footer.php"); ?>