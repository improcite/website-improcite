<?php

// Liste des joueurs de la saison

$joueurs = array();
$result = getUsersSaison($mysqli, $table_comediens, $iCurrentSaisonNumber);

foreach ($result as $row) {
    if (in_array("noselect" , explode(";", $row["rights"]))) { continue; }
    $joueurs[] = $row;
}

$smarty->assign('joueurs', $joueurs);

// Mois et année

$month = 0;
$year = 0;
if ($_GET["month"] && $_GET["year"]) {
    $year = $_GET["year"];
    $month = $_GET["month"];
} else {
    $year = date("Y");
    $month = date("m");
}

$smarty->assign('month', $month);
$smarty->assign('year', $year);

