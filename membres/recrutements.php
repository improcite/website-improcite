<?php

if (!$display_recrutement_private) {
    header('location: /membres/'); exit;
}

// Liste des inscriptions au recrutement

$candidats = [];
$result = getCandidats($mysqli, "impro_recrutement", $saison_recrutement);

foreach ($result as $row) {
    $candidats[] = $row;
}

$smarty->assign('candidats', $candidats);
$smarty->assign('action', $_GET["action"]);
