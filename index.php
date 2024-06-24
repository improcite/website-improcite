<?php

require 'vendor/autoload.php';
use Smarty\Smarty;

# Chargement de la configuration
require_once("config.inc.php");
date_default_timezone_set($date_timezone);

# Messages d'erreur
error_reporting(0);
if($debug) error_reporting(E_ALL);

# Chargement des fonctions
require_once("lib/images.php");
require_once("lib/sql.php");
require_once("lib/smarty.php");

# Lancement de la connexion MySQL
require_once("lib/connexion_mysql.php");

# Choix de la page
$p = isset($_GET['p']) ? $_GET['p'] : "welcome";

# Protection des acces
$page = "pages/" . preg_replace("[^a-z]", "", $p) . ".php";
if (file_exists($page) == false)
{
	header("Location: /?p=notfound");
	die();
}

# Template
$smarty = new Smarty();

$smarty->assign('p',$p);
$smarty->assign('id_saison',$iCurrentSaisonNumber);
$smarty->assign('mysqli',$mysqli);
$smarty->assign('table_comediens',$table_comediens);

$smarty->registerPlugin("function","photo_membre","photo_membre");
$smarty->registerPlugin("function","get_membre","get_membre");
$smarty->registerPlugin("function","get_membre_min","get_membre_min");

require_once($page);

$smarty->display('index.tpl');
