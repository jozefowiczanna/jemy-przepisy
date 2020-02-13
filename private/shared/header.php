<?php 

if(!isset($page_title)) { $page_title = 'Jemy'; }

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
            <a href="przepisy.html" class="nav__link"><img src="assets/images/icons/menu_book-24px.svg" alt="przepisy" class="nav__icon"></a>
            <a href="uzytkownicy.html" class="nav__link"><img src="assets/images/icons/people-24px.svg" alt="użytkownicy" class="nav__icon"></a>
            <a href="profil.html" class="nav__link"><img src="assets/images/icons/person-24px.svg" alt="twój profil" class="nav__icon"></a>
          </nav>
        </div>
      </div>
    </div>
    <div class="under-nav"></div>