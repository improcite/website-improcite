<?php

function photo_membre($params, $smarty) {
    return getPhotoMembre($params['id_membre'], $params['id_saison']);
}

function get_membre($params, $smarty) {
    $infos = getUserInfos($params['mysqli'], $params['table_comediens'], $params['id']);
    $smarty->assign($params['infos'], $infos);
}

function get_membre_min($params, $smarty) {
    $infos = getUserMinimalInfos($params['mysqli'], $params['table_comediens'], $params['id']);
    $smarty->assign($params['infos'], $infos);
}
