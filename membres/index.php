<?php

# Verification de la session
session_start();

if (!isset ($_SESSION[ "id_impro_membre" ])) {
    # La session n'existe pas
    @header("Location: /?p=identification&backURL=".base64_encode($_SERVER["REQUEST_URI"]));
    die(0);
}

require '../vendor/autoload.php';
use Smarty\Smarty;

# Chargement de la configuration
require_once("../config.inc.php");
date_default_timezone_set($date_timezone);

# Messages d'erreur
error_reporting(0);
if($debug) error_reporting(E_ALL);

# Chargement des fonctions
require_once("../lib/images.php");
require_once("../lib/sql.php");
require_once("../lib/smarty.php");

# Lancement de la connexion MySQL
require_once("../lib/connexion_mysql.php");
    
# Choix de la page
$p = isset($_GET['p']) ? $_GET['p'] : "welcome";

# Protection des acces
$page = preg_replace("[^a-z]", "", $p) . ".php";
if (file_exists($page) == false)
{
    header("Location: /?p=notfound");
    die();
}

# Infos membre
$membre = getUserMinimalInfos($mysqli, $table_comediens, $_SESSION[ "id_impro_membre" ]);

# Template
$smarty = new Smarty();
$smarty->setTemplateDir('../templates/membres/');
$smarty->setCompileDir('../templates_c/membres/');

$smarty->assign('p',$p);
$smarty->assign('id_saison',$iCurrentSaisonNumber);
$smarty->assign('mysqli',$mysqli);
$smarty->assign('table_comediens',$table_comediens);
$smarty->assign('t_dispo',"impro_dispo");
$smarty->assign('t_eve',$t_eve);
$smarty->assign('membre',$membre);

$smarty->registerPlugin("function","photo_membre","photo_membre");
$smarty->registerPlugin("function","get_membre","get_membre");
$smarty->registerPlugin("function","get_membre_min","get_membre_min");
$smarty->registerPlugin("function","get_saison_string","get_saison_string");
$smarty->registerPlugin("function","get_dispo_user","get_dispo_user");
$smarty->registerPlugin("function","get_selection_user","get_selection_user");

require_once($page);

$smarty->display('index.tpl');
