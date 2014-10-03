<?php

#====================================================================
# Connexion a la base MySQL pour le site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Lancement de la connexion a MySQL
$connexion = @mysql_connect ( $host , $user , $passwd ) ;

# Selection de la base MySQL
$db = @mysql_select_db ( $base ) ;

?>
