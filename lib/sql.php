<?php 

function getUserMinimalInfos($mysqli, $table, $id) {
    $query = $mysqli->query("SELECT prenom, rights FROM $table WHERE id=$id");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getUserInfos($mysqli, $table, $id) {
    $query = $mysqli->query("SELECT * FROM $table WHERE id=$id");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, $date, $limit=0, $only_public=false) {
    $recherche = "SELECT e.id as id, e.lieu as lieu, l.nom as lnom, c.nom as nom, c.description as description, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.categorie as categorie, e.regisseur as regisseur, e.caisse as caisse, e.animateurs as animateurs, e.ovs as ovs"
        ." FROM $t_eve e, $t_cat c, $t_lieu l "
        ." WHERE e.categorie=c.id AND UNIX_TIMESTAMP(e.date)>$date AND e.lieu=l.id";
    if ($only_public) { $recherche .= " AND c.publique=1"; } 
    $recherche .= " ORDER BY date ASC";
    if ($limit) { $recherche .= " LIMIT $limit"; }
    $query = $mysqli->query($recherche);
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

?>
