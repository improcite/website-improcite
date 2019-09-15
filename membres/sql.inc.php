<?php 

function getUserMinimalInfos($mysqli, $table, $id) {
    $query = $mysqli->query("SELECT prenom, rights FROM $table WHERE id=$id");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, $date) {
    $query = $mysqli->query("SELECT e.id as id, l.nom as lnom, c.nom as nom, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.categorie as categorie, e.regisseur as regisseur, e.caisse as caisse, e.animateurs as animateurs, e.ovs as ovs"
        ." FROM $t_eve e, $t_cat c, $t_lieu l "
        ." WHERE e.categorie=c.id AND e.date>$date AND e.lieu=l.id"
        ." ORDER BY date ASC");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

?>
