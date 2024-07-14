<?php

// Liste des prochaines dates
$dates = [];
$result = getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, time(), 0, false);

foreach ($result as $row) {
    $row['photo'] = getPhotoEvenement($row['id'], $row['lieu'], $row['categorie']);
    $dates[] = $row;
}

$smarty->assign('dates', $dates);
