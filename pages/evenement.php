<?php

# Affichage des informations d'une date

$id = $_GET['id'];

if (!$id) { header('location: /?p=agenda'); exit; }

$infos = getEventInfos($mysqli, $t_eve, $t_cat, $t_lieu, $id);

if (!$infos) { header('location: /?p=agenda'); exit; }

$infos['photo'] = getPhotoEvenement($infos['id'], $infos['lieu'], $infos['categorie']);

if (preg_match('/^(;)+$/', $infos['joueurs'])) { $infos['joueurs'] = null; }
if (preg_match('/^(;)+$/', $infos['animateurs'])) { $infos['animateurs'] = null; }

$smarty->assign('infos', $infos);
$smarty->assign('og_title', "Improcité - ".$infos['nom']." - ".$infos['lnom']);
$smarty->assign('og_description', $infos['ecommentaire'] ? strip_tags($infos['ecommentaire']) : strip_tags($infos['description']));
$smarty->assign('og_image', "https://improcite.com".$infos['photo']);
