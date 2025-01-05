<?php

# Action
$action = $_REQUEST["action"] ? $_REQUEST["action"] : "consultation";
$result = "";

if ( $action == "modifier") {

    $data = array(
        "id" => $membre['id'],
        "prenom" => $_POST["prenom"],
        "nom" => $_POST["nom"],
        "surnom" => $_POST["surnom"],
        "email" => $_POST["email"],
        "portable" => $_POST["portable"],
        "jour" => $_POST["jour"],
        "mois" => $_POST["mois"],
        "annee" => $_POST["annee"],
        "adresse" => $_POST["adresse"],
        "debut" => $_POST['debut'],
        "envie" => $_POST['envie'],
        "apport" => $_POST['apport'],
        "debutimprocite" => $_POST['debutimprocite'],
        "improcite" => $_POST['improcite'],
        "qualite" => $_POST['qualite'],
        "defaut" => $_POST['defaut']
    );

    if ( updateInformationCompte($mysqli, $table_comediens, $data) ) {
        $result = "infosupdated";
    } else {
        $result = "infonotupdated";
    }
    $action = "consultation";
}

if ( $action == "modifierphoto") {

    if ( !empty($_FILES['photo']['name'])) {
        if (filesize($_FILES['photo']['tmp_name']) >= 500000) {
            $result = "phototoobig";
        } else if (!move_uploaded_file($_FILES['photo']['tmp_name'], '../photos/comediens/' .pow(2, $iCurrentSaisonNumber). '/' . $membre['id'] .'.jpg')) {
            $result = "photonotuploaded";
        } else {
            $result = "photouploaded";
        }
        $action = "consultation";
    } else {
        $action = "editer";
    }
}

$infos = getUserInfos($mysqli, $table_comediens, $membre['id']);
$infos["rights_array"] = explode(';', $infos["rights"]);


$smarty->assign("infos", $infos);
$smarty->assign("action", $action);
$smarty->assign("result", $result);
