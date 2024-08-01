<?php

if (!$membre["isAdmin"]) {
    header('location: /membres/'); exit;
}

# Action
$action = $_REQUEST["action"] ? $_REQUEST["action"] : "consultation";

if ($action == "consultation") {

    $result = getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, NULL, 0, false, 0, 0, false);
    $evenements = [];
    foreach ($result as $row) {
        $row["photo"] = getPhotoEve($row["id"], "..");
        $evenements[] = $row;
    }
    $smarty->assign("evenements", $evenements);

}

if ($action == "afficher" or $action == "editer") {

    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_evenements'); exit;
    }
    $evenement = getEventInfos($mysqli, $t_eve, $t_cat, $t_lieu, $_REQUEST["id"]);
    $evenement["photo"] = getPhotoEve($evenement["id"], "..");
    $evenement["joueursArray"] = explode(";", $evenement["joueurs"]);
    $evenement["animateursArray"] = explode(";", $evenement["animateurs"]);
    $smarty->assign("evenement", $evenement);

    $result_cat = getAllObjects($mysqli, $t_cat);
    $categories = [];
    foreach ($result_cat as $row) {
        $categories[] = $row;
    }
    usort($categories, fn($a, $b) => $a['nom'] <=> $b['nom']);
    $smarty->assign("categories", $categories);

    $result_lieu = getAllObjects($mysqli, $t_lieu);
    $lieux = [];
    foreach ($result_lieu as $row) {
        $lieux[] = $row;
    }
    usort($lieux, fn($a, $b) => $a['nom'] <=> $b['nom']);
    $smarty->assign("lieux", $lieux);

    $result_membre = getUsersSaison($mysqli, $table_comediens, $iCurrentSaisonNumber);
    $membres = [];
    foreach ($result_membre as $row) {
        $row["dispo"] = getEventDisposUser($mysqli, "impro_dispo", $_REQUEST["id"], $row["id"]);
        if (!isset($row["dispo"]["dispo_pourcent"])) { $row["dispo"]["dispo_pourcent"] = 50; }
        $membres[] = $row;
    }
    usort($membres, fn($a, $b) => $a['prenom'] <=> $b['prenom']);
    $smarty->assign("membres", $membres);
}

if ($action == "creer") {

    $result_cat = getAllObjects($mysqli, $t_cat);
    $categories = [];
    foreach ($result_cat as $row) {
        $categories[] = $row;
    }
    usort($categories, fn($a, $b) => $a['nom'] <=> $b['nom']);
    $smarty->assign("categories", $categories);

    $result_lieu = getAllObjects($mysqli, $t_lieu);
    $lieux = [];
    foreach ($result_lieu as $row) {
        $lieux[] = $row;
    }
    usort($lieux, fn($a, $b) => $a['nom'] <=> $b['nom']);
    $smarty->assign("lieux", $lieux);

    $result_membre = getUsersSaison($mysqli, $table_comediens, $iCurrentSaisonNumber);
    $membres = [];
    foreach ($result_membre as $row) {
        $membres[] = $row;
    }
    usort($membres, fn($a, $b) => $a['prenom'] <=> $b['prenom']);
    $smarty->assign("membres", $membres);
}

if ($action == "supprimer") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_evenements'); exit;
    }
    deleteObject($mysqli, $t_eve, $_REQUEST["id"]);
    deleteDispoEvenement($mysqli, "impro_dispo", $_REQUEST["id"]);
    header('location: /membres/index.php?p=admin_evenements'); exit;
}

if ($action == "enregistrer") {
    $datetime = $_REQUEST["date"];

    $data = array(
        "categorie" => $_REQUEST["categorie"],
        "date" => date("YmdHis", strtotime($_REQUEST["date"])),
        "lieu" => $_REQUEST["lieu"],
        "commentaire" => $_REQUEST["commentaire"],
        "places" => $_REQUEST["places"] ? $_REQUEST["places"] : 0,
        "tarif" => $_REQUEST["tarif"],
        "joueurs" => implode(";", array($_REQUEST["joueur1"], $_REQUEST["joueur2"], $_REQUEST["joueur3"], $_REQUEST["joueur4"], $_REQUEST["joueur5"], $_REQUEST["joueur6"])),
        "mc" => $_REQUEST["mc"],
        "arbitre" => $_REQUEST["arbitre"],
        "coach" => $_REQUEST["coach"],
        "regisseur" => $_REQUEST["regisseur"],
        "caisse" => $_REQUEST["caisse"],
        "animateurs" => implode(";", array($_REQUEST["animateur1"], $_REQUEST["animateur2"], $_REQUEST["animateur3"], $_REQUEST["animateur4"], $_REQUEST["animateur5"], $_REQUEST["animateur6"]))
    );
    if(!$_REQUEST["id"]) {
        createEvenement($mysqli, $t_eve, $data);
    } else {
        $data["id"] = $_REQUEST["id"];
        updateEvenement($mysqli, $t_eve, $data);
    }
    header('location: /membres/index.php?p=admin_evenements'); exit;
}

$smarty->assign("action", $action);
