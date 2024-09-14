<?php

if (!$membre["isAdmin"]) {
    header('location: /membres/'); exit;
}

# Action
$action = $_REQUEST["action"] ? $_REQUEST["action"] : "consultation";

if ($action == "consultation") {

    $result = getAllObjects($mysqli, $table_comediens);
    $users = [];
    foreach ($result as $row) {
        $row["photo"] = getPhotoMembre($row["id"], $iCurrentSaisonNumber ,"..");
        $users[] = $row;
    }
    $smarty->assign("users", $users);

}

if ($action == "afficher" or $action == "editer") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_users'); exit;
    }
    $user = getObject($mysqli, $table_comediens, $_REQUEST["id"]);
    $user["photo"] = getPhotoMembre($user["id"], $iCurrentSaisonNumber ,"..");
    $user["rights_array"] = explode(';', $user["rights"]);
    $smarty->assign("user", $user);
}

if ($action == "supprimer") {
    if(!$_REQUEST["id"]) {
        header('location: /membres/index.php?p=admin_users'); exit;
    }
    deleteObject($mysqli, $table_comediens, $_REQUEST["id"]);
    # TODO delete from disponibilites
    header('location: /membres/index.php?p=admin_users'); exit;
}

if ($action == "enregistrer") {

    # Données
    $data = array();
    foreach(array("login", "surnom", "prenom", "nom", "jour", "mois", "annee", "email", "portable", "adresse") as $key) {
        $data[$key] = $_REQUEST[$key];
    }

    # Droits
    $rights = "";
    foreach($rights_list as $right_key => $right_value) {
        if ($_REQUEST["right_$right_key"]) {
            $rights .= $right_key.";";
        }
    }
    $data["rights"] = $rights;

    # Saisons
    $saison = 0;
    for ($i = 0; $i <= $iCurrentSaisonNumber + 1; $i++) {
        if ($_REQUEST["saison_$i"]) {
            $saison = $saison + 2 ** $i;
            error_log("==============> SAISON $saison");
        } 
    }
    $data["saison"] = $saison;

    $id = 0;
    if(!$_REQUEST["id"]) {
        foreach(array("qualite", "defaut", "debut", "debutimprocite", "envie", "apport", "improcite") as $key) {
            $data[$key] = "";
        }
        $data["password"] = md5($salt.$$_REQUEST["password"]);
        $data["affichernom"] = 1;
        $data["notif_email"] = 1;
        createUser($mysqli, $table_comediens, $data);
        $id = mysqli_insert_id($mysqli);
    } else {
        $data["id"] = $_REQUEST["id"];
        if ($_REQUEST["password"]) {
            updatePassword($mysqli, $table_comediens, $_REQUEST["id"], $_REQUEST["password"], $salt);
        }
        updateUser($mysqli, $table_comediens, $data);
        $id = $_REQUEST["id"];
    }
    header('location: /membres/index.php?p=admin_users&action=afficher&id='.$id); exit;
}

$smarty->assign("action", $action);
