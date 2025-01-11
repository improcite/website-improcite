<?php

// Liste des joueurs de la saison

$joueurs = array();
$result = getUsersSaison($mysqli, $table_comediens, $iCurrentSaisonNumber);

foreach ($result as $row) {
    if (in_array("noselect" , explode(";", $row["rights"]))) { continue; }
    $joueurs[] = $row;
}


// Sélections depuis le début de la saison

$roles = array('joueur','mc','arbitre','regisseur','animateur');
$statistiques = array();
foreach ($joueurs as $joueur) {
    $selections = getSelectionSaison($mysqli, $t_eve, $iCurrentSaisonNumber, $joueur['id']);
    $statistiques[$joueur["id"]] = array();
    foreach ($roles as $role) {
        $statistiques[$joueur["id"]][$role] = $selections[$role];
    }
}

$smarty->assign('joueurs', $joueurs);
$smarty->assign('roles', $roles);
$smarty->assign('statistiques', $statistiques);
