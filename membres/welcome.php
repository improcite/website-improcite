<?php

// Liste des prochaines dates
$dates = [];
$result = getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, time(), 0, false);

foreach ($result as $row) {
    // Dispos
    $dispo = getEventDisposUser($mysqli, "impro_dispo", $row['id'], $membre['id']);
    if ($dispo) {
        $row['dispo_pourcent'] = $dispo['dispo_pourcent'];
        $row['dispo_commentaire'] = $dispo['dispo_commentaire'];
    } else {
        $row['dispo_pourcent'] = "50";
    }
    $dates[] = $row;
}

$smarty->assign('dates', $dates);
