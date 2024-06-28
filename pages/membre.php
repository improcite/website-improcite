<?php

# Affichage des informations d'un membre

$id = $_GET['id'];

$infos = getUserInfos($mysqli, $table_comediens, $id);

if (!$infos) { header('location: /?p=equipe'); exit; }

$smarty->assign('infos', $infos);
