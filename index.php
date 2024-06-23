<?php

require 'vendor/autoload.php';
use Smarty\Smarty;

# Chargement de la configuration
require_once("config.inc.php");

# Messages d'erreur
error_reporting(0);
if($debug) error_reporting(E_ALL);

# Chargement des fonctions
require_once("fonctions.inc.php");

# Lancement de la connexion MySQL
require_once ("connexion_mysql.php");

# Choix de la page
$p = isset($_GET['p']) ? $_GET['p'] : "welcome";

# Protection des acces
$page = "pages/" . preg_replace("[^a-z]", "", $p) . ".php";
if (file_exists($page) == false)
{
	header("Location: /?p=notfound");
	die();
}
require_once($page);

# Template
$smarty = new Smarty();
$smarty->assign('p',$p);
$smarty->display('index.tpl');
