<?php

#====================================================================
# Connexion a la base MySQL pour le site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

$mysqli = new mysqli($host, $user, $passwd, $base);
if ($mysqli->connect_errno && $debug) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . $mysqli->connect_errno . PHP_EOL;
    echo "Debugging error: " . $mysqli->connect_error . PHP_EOL;
    exit;
}
$mysqli->set_charset("utf8");

?>
