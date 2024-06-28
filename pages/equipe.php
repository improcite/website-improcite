<?php

# Affichage des membres de la saison actuelle

$membres = [];
$result = getUsersSaison($mysqli, $table_comediens, $iCurrentSaisonNumber);

foreach ($result as $row) {
    $membres[] = $row;
}

$smarty->assign('membres', $membres);
