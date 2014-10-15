<?php

#====================================================================
# Credits du site Improcite
# 2006 (c) Clement OUDOT
#====================================================================

# Fermeture session
session_start();
session_save_path("sessions");
unset($_SESSION["id_impro_membre"]);
session_destroy();

# Suppression des cookies
setcookie('login', '', time()+60*60*24*365);
setcookie('md5password', '', time()+60*60*24*365);

# Redirection
header("Location: ../");

?>
