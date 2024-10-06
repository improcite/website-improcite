<?php

# Verification de la session
session_start();

if (!isset ($_SESSION[ "id_impro_membre" ])) {
    die(0);
}

require '../vendor/autoload.php';
require_once("../config.inc.php");
require_once("../lib/sql.php");
require_once("../lib/connexion_mysql.php");

$date_id = isset($_POST['date_id']) ? $_POST['date_id'] : "";
$membre_id = isset($_POST['membre_id']) ? $_POST['membre_id']: "";
$backURL = isset($_POST['backURL']) ? $_POST['backURL'] : "";
$dispo_pourcent = isset($_POST['dispo_pourcent']) ? $_POST['dispo_pourcent'] : "";
$dispo_commentaire = isset($_POST['dispo_commentaire']) ? $_POST['dispo_commentaire'] : "";

# Seul un admin peut modifier pour autre membre
if (!array_search("admin", explode(";" , $_SESSION[ "rights_impro_membre" ]))) {
    $membre_id = $_SESSION[ "id_impro_membre" ];
}

# MAJ BDD
if ($date_id && $membre_id) {
    updateEventDispo($mysqli, "impro_dispo", $date_id, $membre_id, $dispo_pourcent, $dispo_commentaire);
}

# Retour
@header("Location: $backURL");
?>
