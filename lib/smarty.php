<?php

function photo_membre($params, $smarty) {
    return getPhotoMembre($params['id_membre'], $params['id_saison'], $params['path']);
}

function get_membre($params, $smarty) {
    $infos = getUserInfos($params['mysqli'], $params['table_comediens'], $params['id']);
    $smarty->assign($params['infos'], $infos);
}

function get_membre_min($params, $smarty) {
    $infos = getUserMinimalInfos($params['mysqli'], $params['table_comediens'], $params['id']);
    $smarty->assign($params['infos'], $infos);
}

function get_saison_string($params, $smarty) {
    $id_saison = $params['id_saison'];
    $annee_debut = 2004 + $id_saison;
    $annee_fin = 2005 + $id_saison;
    return $annee_debut." - ".$annee_fin;
}

function get_dispo_user($params, $smarty) {
    $infos = getEventDisposUser($params['mysqli'], $params['t_dispo'], $params['id_eve'] , $params['id']);
    $smarty->assign($params['infos'], $infos);
}

function get_selection_user($params, $smarty) {
    return ucfirst(getEventSelectionUser($params['mysqli'], $params['t_eve'], $params['id_eve'] , $params['id']));
}
