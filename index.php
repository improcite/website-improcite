<?php

require 'vendor/autoload.php';
use Smarty\Smarty;

# Chargement de la configuration
require_once("config.inc.php");

# Messages d'erreur
error_reporting(0);
if($debug) error_reporting(E_ALL);

# Chargement des fonctions
require_once("lib/images.php");
require_once("lib/sql.php");

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
require_once($page);
$smarty->display('index.tpl');
