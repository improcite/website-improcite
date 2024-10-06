<?php

// Affichage des membres de la saison

$saison = isset($_GET['saison']) ? $_GET['saison'] : $iCurrentSaisonNumber;

$membres = [];
$result = getUsersSaison($mysqli, $table_comediens, $saison);

foreach ($result as $row) {
    $membres[] = $row;
}

$smarty->assign('membres', $membres);
$smarty->assign('saison', $saison);

if ($saison > 0) {
    $smarty->assign('saison_before', $saison - 1);
}
if ($saison < $iCurrentSaisonNumber) {
    $smarty->assign('saison_after', $saison + 1);
}
