<?php 

function getUserMinimalInfos($mysqli, $table, $id) {
    $query = $mysqli->query("SELECT id, prenom, nom, rights FROM $table WHERE id=$id");
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

function getUserWithPassword($mysqli, $table, $login, $password, $id_saison) {
    $bit_saison = pow(2, $id_saison);
    $query = $mysqli->query("SELECT id, prenom, nom, rights FROM $table WHERE login='$login' AND password='$password' AND saison & $bit_saison");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getUsersSaison($mysqli, $table, $id_saison) {
    $bit_saison = pow(2, $id_saison);
    $query = $mysqli->query("SELECT * FROM $table WHERE saison & $bit_saison ORDER BY prenom");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function getUsersWithRights($mysqli, $table, $right, $id_saison) {
    $bit_saison = pow(2, $id_saison);
    $query = $mysqli->query("SELECT id, nom, prenom, email, portable FROM $table WHERE saison & $bit_saison AND rights LIKE '%$right%'ORDER BY prenom");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
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

function getEventInfos($mysqli, $t_eve, $t_cat, $t_lieu, $id_eve) {
    $recherche = "SELECT e.id as id, e.lieu as lieu, l.nom as lnom, l.adresse as ladresse, l.adresse2 as ladresse2, l.coordonnees as lcoordonnees, c.nom as nom, c.description as description, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.categorie as categorie, e.regisseur as regisseur, e.caisse as caisse, e.animateurs as animateurs, e.ovs as ovs"
        ." FROM $t_eve e, $t_cat c, $t_lieu l "
        ." WHERE e.categorie=c.id AND e.lieu=l.id AND e.id=$id_eve";
    $query = $mysqli->query($recherche);
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getEventDisposUser($mysqli, $t_dispo, $id_eve, $id) {
    $query = $mysqli->query("SELECT * FROM $t_dispo WHERE id_spectacle=$id_eve AND id_personne=$id");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getEventSelectionUser($mysqli, $t_eve, $id_eve, $id) {
    $query = $mysqli->query("SELECT joueurs,coach,mc,arbitre,regisseur,caisse,animateurs FROM $t_eve WHERE id=$id_eve");
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    $infos = $query->fetch_assoc();

    if ( in_array( $id, explode(';', $infos['joueurs']) ) ) { return "joueur"; }
    if ( $infos['coach'] == $id ) { return "coach"; }
    if ( $infos['mc'] == $id ) { return "mc"; }
    if ( $infos['arbitre'] == $id ) { return "arbitre"; }
    if ( $infos['regisseur'] == $id ) { return "regisseur"; }
    if ( $infos['caisse'] == $id ) { return "caisse"; }
    if ( in_array( $id, explode(';', $infos['animateurs']) ) ) { return "animateur"; }
    return;
}

function addInscriptionRecrutement($mysqli, $t_recrutement, $id_saison, $data) {
    $insert = "INSERT INTO $t_recrutement (nom, prenom, datenaissance, adresse, mail, telephone, source, experience, envie, disponibilite, date, saison) ";
    $insert .= "VALUES ('".$data['nom']."','".$data['prenom']."','".$data['datenaissance']."','".$data['adresse']."','".$data['mail']."','".$data['telephone']."','".$data['source']."','".$data['experience']."','".$data['envie']."','".$data['disponibilite']."','".date('Y-m-d H:i:s')."','".$id_saison."')";
    $query = $mysqli->query($insert);
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

?>
