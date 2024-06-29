<?php 

# Présentation du recrutement
$action = $_POST["action"] ? $_POST["action"] : "presentation";

# Réception du formulaire
if ($action == "inscription") {

    # Filtre des données
    filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    # Enregistrement de l'inscription
    $query_inscription = addInscriptionRecrutement($mysqli, $t_recrutement, $iCurrentSaisonNumber, $_POST); 

    # Envoi d'un mail aux recruteurs

    # Envoi d'un mail au participant

    # Personnalisation du message affiché
    $smarty->assign('participant', $_POST);
}

$smarty->assign('action', $action);
