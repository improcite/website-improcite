<?php

if (!$membre["isAdmin"]) {
    header('location: /membres/'); exit;
}

# Action
$action = $_REQUEST["action"] ? $_REQUEST["action"] : "consultation";

if ($action == "consultation") {

    $result = getAllObjects($mysqli, $t_lieu);
    $lieux = [];
    foreach ($result as $row) {
        $lieux[] = $row;
    }
    $smarty->assign("lieux", $lieux);

}

if ($action == "afficher" or $action == "editer") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_lieux'); exit;
    }
    $lieu = getObject($mysqli, $t_lieu, $_REQUEST["id"]);
    $smarty->assign("lieu", $lieu);
}

if ($action == "supprimer") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_lieux'); exit;
    }
    deleteObject($mysqli, $t_lieu, $_REQUEST["id"]);
    header('location: /membres/index.php?p=admin_lieux'); exit;
}

if ($action == "enregistrer") {
    $data = array(
        "nom" => $_REQUEST["nom"],
        "adresse" => $_REQUEST["adresse"],
        "adresse2" => $_REQUEST["adresse2"],
        "coordonnees" => $_REQUEST["coordonnees"]
    );
    if(!$_REQUEST["id"]) {
        createLieu($mysqli, $t_lieu, $data);
    } else {
        $data["id"] = $_REQUEST["id"];
        updateLieu($mysqli, $t_lieu, $data);
    }
    header('location: /membres/index.php?p=admin_lieux'); exit;
}

$smarty->assign("action", $action);
