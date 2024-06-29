<?php

# Affichage des informations d'une date

$id = $_GET['id'];

if (!$id) { header('location: /?p=agenda'); exit; }

$infos = getEventInfos($mysqli, $t_eve, $t_cat, $t_lieu, $id);

if (!$infos) { header('location: /?p=agenda'); exit; }

$infos['photo'] = getPhotoEvenement($infos['id'], $infos['lieu'], $infos['categorie']);

$smarty->assign('infos', $infos);
