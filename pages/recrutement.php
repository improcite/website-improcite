<?php 
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

if (!$display_recrutement_public) {
    header('location: /?p=welcome'); exit;
}

# Présentation du recrutement
$action = $_POST["action"] ? $_POST["action"] : "presentation";
$error = $_GET["error"];

session_start();

if ($action == "presentation") {
    $builder = new CaptchaBuilder;
    $builder->build();
    $_SESSION['phrase'] = $builder->getPhrase();
    $smarty->assign("captcha_image",$builder->inline());
}

# Réception du formulaire
if ($action == "inscription") {

    # Filtre des données
    filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    # Vérification du captcha
    if (!isset($_POST["phrase"])) {
        header('location: /?p=recrutement&error=nocaptcha'); exit;
    }

    if (!isset($_SESSION['phrase'])) {
        header('location: /?p=recrutement&error=nocaptchasession'); exit;
    }

    if (!PhraseBuilder::comparePhrases($_SESSION['phrase'], $_POST['phrase'])){
        header('location: /?p=recrutement&error=badcaptcha'); exit;
    }

    # Enregistrement de l'inscription
    $query_inscription = addInscriptionRecrutement($mysqli, $t_recrutement, $saison_recrutement, $_POST);

    # Personnalisation du message affiché
    $smarty->assign('participant', $_POST);

    # Envoi d'un mail aux recruteurs
    $right = "recruteur";
    $result_recruteurs = getUsersWithRights($mysqli, $table_comediens, $right, $saison_recrutement);
    $mail_recruteurs = array();
    foreach($result_recruteurs as $row) {
        $mail_recruteurs[] = $row['email'];
    }

    $destinataires_confirmation_interne = implode(",", $mail_recruteurs);
    $mail_confirmation_interne = $smarty->fetch('mails/recrutement_interne.tpl');
    mail($destinataires_confirmation_interne,"[Improcité] Nouvelle inscription au recrutement !",$mail_confirmation_interne, "MIME-Version: 1.0\r\nContent-Type: text/html; charset=\"utf-8\"\r\nFrom: Improcité <contact@improcite.com>\r\n");

    # Envoi d'un mail au participant
    $mail_confirmation = $smarty->fetch('mails/recrutement.tpl');
    mail($_POST['mail'],"[Improcité] Inscription au recrutement",$mail_confirmation, "MIME-Version: 1.0\r\nContent-Type: text/html; charset=\"utf-8\"\r\nFrom: Improcité <contact@improcite.com>\r\n");

}

$smarty->assign('action', $action);
$smarty->assign('error', $error);
$smarty->assign('dates_recrutement', $dates_recrutement);
$smarty->assign('saison_recrutement', $saison_recrutement);
