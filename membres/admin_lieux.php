<?php

if (!$membre["isAdmin"]) {
    header('location: /membres/'); exit;
}

# Action
$action = $_REQUEST["action"] ? $_REQUEST["action"] : "consultation";
$result = "";

if ( $action == "modifierphoto") {

    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_lieux'); exit;
    }
    if ( !empty($_FILES['photo']['name'])) {
        if (filesize($_FILES['photo']['tmp_name']) >= 1000000) {
            $result = "phototoobig";
        } else if (!move_uploaded_file($_FILES['photo']['tmp_name'], '../photos/lieux/' . $_REQUEST["id"] .'.jpg')) {
            $result = "photonotuploaded";
        } else {
            $result = "photouploaded";
        }
    }
    $action = "editer";
}

if ($action == "consultation") {

    $result = getAllObjects($mysqli, $t_lieu);
    $lieux = [];
    foreach ($result as $row) {
        $row["photo"] = getPhotoLieu($row["id"], "..");
        $lieux[] = $row;
    }
    $smarty->assign("lieux", $lieux);

}

if ($action == "afficher" or $action == "editer") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_lieux'); exit;
    }
    $lieu = getObject($mysqli, $t_lieu, $_REQUEST["id"]);
    $lieu["photo"] = getPhotoLieu($lieu["id"], "..");
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
$smarty->assign("result", $result);
