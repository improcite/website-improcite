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

$month_before = 0;
$month_after = 0;
$year_before = 0;
$year_after = 0;

if ($month === "01") {
	$month_before = "12";
	$month_after = "02";
	$year_before = intval($year) - 1;
	$year_after = intval($year);
} elseif ($month === "12") {
	$month_before = "11";
	$month_after = "01";
	$year_before = intval($year);
	$year_after = intval($year) + 1;
} else {
	$month_before = intval($month) -1;
	$month_after = intval($month) + 1;
	$year_before = intval($year);
	$year_after = intval($year);
}

if ( strlen( $month_before ) == 1) { $month_before = "0" . $month_before; }
if ( strlen( $month_after ) == 1) { $month_after = "0" . $month_after; }

$smarty->assign('month', $month);
$smarty->assign('month_before', $month_before);
$smarty->assign('month_after', $month_after);
$smarty->assign('year', $year);
$smarty->assign('year_before', $year_before);
$smarty->assign('year_after', $year_after);
