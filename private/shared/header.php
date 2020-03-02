<?php 

if(!isset($page_title)) { $page_title = 'Jemy'; }

if (isset($_SESSION['user_id'])) {
  // if user logged in, set nav link to profile page
  $link = "profile.php?id=" . $_SESSION['user_id'];
} else {
  // if user not logged in, set nav link to login page
  $link = "login.php";
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.min.css" />
  </head>
  <body>

    <div class="navbar">
      <div class="container">
        <div class="navbar__inner">
          <a href="index.php" class="navbar__brand">JEMY!</a>
          <nav class="nav">
            <a href="recipes.php" class="nav__link"><img src="assets/images/icons/menu_book-24px.svg" alt="przepisy" title="przepisy" class="nav__icon"></a>
            <a href="users.php" class="nav__link"><img src="assets/images/icons/people-24px.svg" alt="użytkownicy" title="użytkownicy" class="nav__icon"></a>
            <a href="<?php echo $link; ?>" class="nav__link"><img src="assets/images/icons/person-24px.svg" alt="twój profil" title="twój profil" class="nav__icon"></a>
            <?php if(isset($_SESSION['user_id'])) {
              echo "<a href='logout.php' class='nav__link'><img src='assets/images/icons/logout.svg' alt='wyloguj się' title='wyloguj się' class='nav__icon'></a>";
            } ?>
          </nav>
        </div>
      </div>
    </div>
    <div class="under-nav"></div>