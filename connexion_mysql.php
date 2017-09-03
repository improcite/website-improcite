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
$mysqli = new mysqli($host, $user, $passwd, $base);
if ($mysqli->connect_errno && $debug) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . $mysqli->connect_errno . PHP_EOL;
    echo "Debugging error: " . $mysqli->connect_error . PHP_EOL;
    exit;
}

?>
