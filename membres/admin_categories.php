<?php

if (!$membre["isAdmin"]) {
    header('location: /membres/'); exit;
}

# Action
$action = $_REQUEST["action"] ? $_REQUEST["action"] : "consultation";

if ($action == "consultation") {

    $result = getAllObjects($mysqli, $t_cat);
    $categories = [];
    foreach ($result as $row) {
        $row["photo"] = getPhotoCategorie($row["id"], "..");
        $categories[] = $row;
    }
    $smarty->assign("categories", $categories);

}

if ($action == "afficher") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_categories'); exit;
    }
    $categorie = getObject($mysqli, $t_cat, $_REQUEST["id"]);
    $categorie["photo"] = getPhotoCategorie($categorie["id"], "..");
    $smarty->assign("categorie", $categorie);
}

if ($action == "supprimer") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_categories'); exit;
    }
    deleteObject($mysqli, $t_cat, $_REQUEST["id"]);
    header('location: /membres/index.php?p=admin_categories'); exit;
}


$smarty->assign("action", $action);
