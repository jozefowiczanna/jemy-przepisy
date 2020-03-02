<?php
require_once('private/initialize.php'); 

unset($_SESSION['user_id']);
unset($_SESSION['username']);
header('Location: index.php');

?>
