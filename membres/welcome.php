<?php

// Liste des prochaines dates
$dates = [];
$result = getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, time(), 0, false, 0, 0, true);

foreach ($result as $row) {
    // Dispos
    $dispo = getEventDisposUser($mysqli, "impro_dispo", $row['id'], $membre['id']);
    if ($dispo) {
        $row['dispo_pourcent'] = $dispo['dispo_pourcent'];
        $row['dispo_commentaire'] = $dispo['commentaire'];
    } else {
        $row['dispo_pourcent'] = "50";
    }
    // Commentaire
    $row['commentaire'] = $row['ecommentaire'] ? $row['ecommentaire'] : $row['description'];
    // Selection
    $row['selection'] = ucfirst(getEventSelectionUser($mysqli, $t_eve, $row['id'], $membre['id']));
    $dates[] = $row;
}

$smarty->assign('dates', $dates);
