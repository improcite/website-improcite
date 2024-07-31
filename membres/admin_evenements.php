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
    if(!$_REQUEST["id"]) {
        createCategorie($mysqli, $t_eve, array("nom" => $_REQUEST["nom"], "description" => $_REQUEST["description"], "publique" => $_REQUEST["publique"] ? 1 : 0));
    } else {
        updateCategorie($mysqli, $t_eve, array('id' => $_REQUEST["id"], "nom" => $_REQUEST["nom"], "description" => $_REQUEST["description"], "publique" => $_REQUEST["publique"] ? 1 : 0));
    }
    header('location: /membres/index.php?p=admin_evenements'); exit;
}

$smarty->assign("action", $action);
