<?php

#====================================================================
# Connexion a la base MySQL pour le site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Lancement de la connexion a MySQL
$connexion = @mysql_connect ( $host , $user , $passwd ) ;
$force_utf8 = @mysql_set_charset("utf8");

# Selection de la base MySQL
$db = @mysql_select_db ( $base ) ;

?>
