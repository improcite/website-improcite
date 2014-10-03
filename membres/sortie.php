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

# Redirection
header("Location: ../");

?>
