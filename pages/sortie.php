<?php

# Fermeture session
session_start();
unset($_SESSION["id_impro_membre"]);
session_destroy();

# Suppression des cookies
setcookie('login', '', time()+60*60*24*365);
setcookie('md5password', '', time()+60*60*24*365);

?>
