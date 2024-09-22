<?php 

function getUserMinimalInfos($mysqli, $table, $id) {
    $query = $mysqli->execute_query("SELECT id, prenom, nom, email, rights FROM $table WHERE id=?", array($id));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getUserInfos($mysqli, $table, $id) {
    $query = $mysqli->execute_query("SELECT * FROM $table WHERE id=?", array($id));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getUserWithPassword($mysqli, $table, $login, $password, $id_saison) {
    $bit_saison = pow(2, $id_saison);
    $query = $mysqli->execute_query("SELECT id, prenom, nom, email, rights FROM $table WHERE (login=? OR email=?) AND password=? AND saison & ?", array($login, $login, $password, $bit_saison));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getUsersSaison($mysqli, $table, $id_saison) {
    $bit_saison = pow(2, $id_saison);
    $query = $mysqli->execute_query("SELECT * FROM $table WHERE saison & ? ORDER BY prenom", array($bit_saison));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function getUsersWithRights($mysqli, $table, $right, $id_saison) {
    $bit_saison = pow(2, $id_saison);
    $query = $mysqli->execute_query("SELECT id, nom, prenom, email, portable FROM $table WHERE saison & ? AND rights LIKE '%$right%' ORDER BY prenom", array($bit_saison));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, $date, $limit=0, $only_public=false, $month=0, $year=0, $asc=false) {
    $values = array();
    $recherche = "SELECT e.id as id, e.lieu as lieu, l.nom as lnom, c.nom as nom, c.description as description, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.categorie as categorie, e.regisseur as regisseur, e.caisse as caisse, e.animateurs as animateurs, e.ovs as ovs, e.places as places, e.tarif as tarif, c.interne as interne"
        ." FROM $t_eve e, $t_cat c, $t_lieu l "
        ." WHERE e.categorie=c.id AND e.lieu=l.id";
    if ($month and $year) {
        $recherche .= " AND date>? AND date<?";
        $values[] = $year.$month."01000000";
        $values[] = $year.$month."31235959";
    }
    if ($date) {
        $recherche .= " AND UNIX_TIMESTAMP(e.date)>?";
        $values[] = $date;
    }
    if ($only_public) {
        $recherche .= " AND c.publique=1";
    }
    $recherche .= " ORDER BY date";
    $recherche .= $asc ? " ASC" : " DESC";
    if ($limit) {
        $recherche .= " LIMIT ?";
        $values[] = $limit;
    }
    $query = $mysqli->execute_query($recherche, $values);
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function getEventInfos($mysqli, $t_eve, $t_cat, $t_lieu, $id_eve) {
    $recherche = "SELECT e.id as id, e.lieu as lieu, l.nom as lnom, l.adresse as ladresse, l.adresse2 as ladresse2, l.coordonnees as lcoordonnees, c.nom as nom, c.description as description, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.categorie as categorie, e.regisseur as regisseur, e.caisse as caisse, e.animateurs as animateurs, e.ovs as ovs, e.places as places, e.tarif as tarif, c.interne as interne"
        ." FROM $t_eve e, $t_cat c, $t_lieu l "
        ." WHERE e.categorie=c.id AND e.lieu=l.id AND e.id=?";
    $query = $mysqli->execute_query($recherche, array($id_eve));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getEventDisposUser($mysqli, $t_dispo, $id_eve, $id) {
    $query = $mysqli->execute_query("SELECT * FROM $t_dispo WHERE id_spectacle=? AND id_personne=?", array($id_eve, $id));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function getEventSelectionUser($mysqli, $t_eve, $id_eve, $id) {
    $query = $mysqli->execute_query("SELECT joueurs,coach,mc,arbitre,regisseur,caisse,animateurs FROM $t_eve WHERE id=?", array($id_eve));
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
    $insert = "INSERT INTO $t_recrutement (nom, prenom, datenaissance, adresse, mail, telephone, source, experience, envie, disponibilite, date, saison) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $values = array($data['nom'], $data['prenom'], $data['datenaissance'], $data['adresse'], $data['mail'], $data['telephone'], $data['source'], $data['experience'], $data['envie'], $data['disponibilite'], date('Y-m-d H:i:s'), $id_saison);
    $query = $mysqli->execute_query($insert, $values);
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function updateEventDispo($mysqli, $t_dispo, $id_eve, $id, $dispo_pourcent, $dispo_commentaire) {
    $replace = "REPLACE INTO $t_dispo (id_spectacle, id_personne, dispo_pourcent, commentaire) VALUES (?,?,?,?)";
    $query = $mysqli->execute_query($replace, array($id_eve, $id, $dispo_pourcent, $dispo_commentaire));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function getCandidats($mysqli, $table, $id_saison) {
    $query = $mysqli->execute_query("SELECT * FROM $table WHERE saison=? ORDER BY date ASC", array($id_saison));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function getAllObjects($mysqli, $table) {
    $query = $mysqli->execute_query("SELECT * FROM $table ORDER BY id ASC", array());
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function getObject($mysqli, $table, $id) {
    $query = $mysqli->execute_query("SELECT * FROM $table WHERE id=?", array($id));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query->fetch_assoc();
}

function deleteObject($mysqli, $table, $id) {
    $query = $mysqli->execute_query("DELETE FROM $table WHERE id=?", array($id));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function updateCategorie($mysqli, $table, $data) {
    $replace = "REPLACE INTO $table (id, nom, description, publique, interne) VALUES (?,?,?,?,?)";
    $query = $mysqli->execute_query($replace, array($data["id"], $data["nom"], $data["description"], $data["publique"], $data["interne"]));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function createCategorie($mysqli, $table, $data) {
    $insert = "INSERT INTO $table (nom, description, publique, interne) VALUES (?,?,?,?)";
    $query = $mysqli->execute_query($insert, array($data["nom"], $data["description"], $data["publique"], $data["interne"]));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function deleteDispoEvenement($mysqli, $table, $id) {
    $query = $mysqli->execute_query("DELETE FROM $table WHERE id_spectacle=?", array($id));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function updateEvenement($mysqli, $table, $data) {
    $replace = "REPLACE INTO $table (id, categorie, date, commentaire, lieu, tarif, places, joueurs, coach, mc, arbitre, regisseur, caisse, animateurs) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $mysqli->execute_query($replace, array($data["id"], $data["categorie"], $data["date"], $data["commentaire"], $data["lieu"], $data["tarif"], $data["places"], $data["joueurs"], $data["coach"], $data["mc"], $data["arbitre"], $data["regisseur"], $data["caisse"], $data["animateurs"]));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function createEvenement($mysqli, $table, $data) {
    $insert = "INSERT INTO $table (categorie, date, commentaire, lieu, tarif, places, joueurs, coach, mc, arbitre, regisseur, caisse, animateurs) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $mysqli->execute_query($insert, array($data["categorie"], $data["date"], $data["commentaire"], $data["lieu"], $data["tarif"], $data["places"], $data["joueurs"], $data["coach"], $data["mc"], $data["arbitre"], $data["regisseur"], $data["caisse"], $data["animateurs"]));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function updateUser($mysqli, $table, $data) {
    $update = "UPDATE $table SET login=?, prenom=?, nom=?, surnom=?, email=?, portable=?, jour=?, mois=?, annee=?, adresse=?, rights=?, saison=? WHERE id=?";
    $query = $mysqli->execute_query($update, array($data["login"], $data["prenom"], $data["nom"], $data["surnom"], $data["email"], $data["portable"], $data["jour"], $data["mois"], $data["annee"], $data["adresse"], $data["rights"], $data["saison"], $data["id"]));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function createUser($mysqli, $table, $data) {
    $insert = "INSERT INTO $table (login, password, prenom, nom, surnom, email, portable, jour, mois, annee, adresse, rights, saison, qualite, defaut, debut, debutimprocite, envie, apport, improcite, affichernom, notif_email) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $query = $mysqli->execute_query($insert, array($data["login"], $data["password"], $data["prenom"], $data["nom"], $data["surnom"], $data["email"], $data["portable"], $data["jour"], $data["mois"], $data["annee"], $data["adresse"], $data["rights"], $data["saison"], $data["qualite"], $data["defaut"], $data["debut"], $data["envie"], $data["apport"], $data["debutimprocite"], $data["improcite"], $data["affichernom"], $data["notif_email"]));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function updatePassword($mysqli, $table, $id, $password, $salt) {
    $md5password = md5($salt.$password);
    $replace = "UPDATE $table SET password=? WHERE id=?";
    $query = $mysqli->execute_query($replace, array($md5password, $id));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

function updateInformationCompte($mysqli, $table, $data) {
    $update = "UPDATE $table SET prenom=?, nom=?, surnom=?, email=?, portable=?, jour=?, mois=?, annee=?, adresse=?, debut=?, envie=?, apport=?, debutimprocite=?, improcite=?, qualite=?, defaut=? WHERE id=?";
    $query = $mysqli->execute_query($update, array($data["prenom"], $data["nom"], $data["surnom"], $data["email"], $data["portable"], $data["jour"], $data["mois"], $data["annee"], $data["adresse"], $data["debut"], $data["envie"], $data["apport"], $data["debutimprocite"], $data["improcite"], $data["qualite"], $data["defaut"], $data["id"]));
    if (!$query && $debug) {
        die($mysqli->sqlstate);
    }
    return $query;
}

?>
