<?php 

# Présentation du recrutement
$action = $_POST["action"] ? $_POST["action"] : "presentation";

# Réception du formulaire
if ($action == "inscription") {

    # Filtre des données
    filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    # Enregistrement de l'inscription
    $query_inscription = addInscriptionRecrutement($mysqli, $t_recrutement, $iCurrentSaisonNumber, $_POST); 

    # Personnalisation du message affiché
    $smarty->assign('participant', $_POST);

    # Envoi d'un mail aux recruteurs
    $right = "recruteur";
    $result_recruteurs = getUsersWithRights($mysqli, $table_comediens, $right, $iCurrentSaisonNumber);
    $mail_recruteurs;
    foreach($result_recruteurs as $row) {
        $mail_recruteurs[] = $row['email'];
    }

    $destinataires_confirmation_interne = implode(",", $mail_recruteurs);
    $mail_confirmation_interne = $smarty->fetch('mails/recrutement_interne.tpl');
    mail($destinataires_confirmation_interne,"[Improcité] Nouvelle inscription au recrutement !",$mail_confirmation_interne, "MIME-Version: 1.0\r\nContent-Type: text/html; charset=\"utf-8\"\r\nFrom: Improcité <contact@improcite.com>\r\n");

    # Envoi d'un mail au participant

}

$smarty->assign('action', $action);
