<?php 

function getUserMinimalInfos($mysqli, $table, $id) {
    $query = $mysqli->query("SELECT prenom, rights FROM $table WHERE id=$id");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

?>
