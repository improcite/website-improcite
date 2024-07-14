<?php

// Affichage des membres de la saison

$saison = $_GET['saison'] ? $_GET['saison'] : $iCurrentSaisonNumber;

$membres = [];
$result = getUsersSaison($mysqli, $table_comediens, $iCurrentSaisonNumber);

foreach ($result as $row) {
    $membres[] = $row;
}

$smarty->assign('membres', $membres);
