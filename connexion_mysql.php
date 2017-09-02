<?php

#====================================================================
# Connexion a la base MySQL pour le site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Old Driver
# Lancement de la connexion a MySQL
$connexion = @mysql_connect ( $host , $user , $passwd ) ;
$force_utf8 = @mysql_set_charset("utf8");

# Selection de la base MySQL
$db = @mysql_select_db ( $base ) ;

# New Driver
$connection_new = mysqli_connect($host, $user, $passwd, $base);
if (!$connection_new && $debug) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?>
