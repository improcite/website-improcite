<?php

#====================================================================
# Tete des pages Improcite - Membres
# 2004 (c) Clement OUDOT
#====================================================================

# Verification de la session

session_start() ;
session_save_path ('sessions'); 

if ( !isset ( $_SESSION[ "id_impro_membre" ] ) )
{
	# La session n'existe pas
	@header("Location: identification.php?backURL=".base64_encode($_SERVER["REQUEST_URI"]));
	die(0);
}

# Chargement de la configuration
require_once ( "../config.inc.php" ) ;

/* Messages d'erreur */
error_reporting(0);
if($debug) error_reporting(E_ALL);

# Chargement des fonctions
require_once ("../fonctions.inc.php") ;
require_once ("../Mobile_Detect.php");

# Lancement de la connexion MySQL
include ( "../connexion_mysql.php" ) ;

include ( "../fxDB.php" );

// Fix warning
if(!isset($CURRENT_MENU_ITEM)) $CURRENT_MENU_ITEM = '';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Improcite - Espace membres</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="../js/improcite.js"></script>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<?php if ( $CURRENT_MENU_ITEM == "fichiers" ) { ?>

	<!-- elFinder CSS (REQUIRED) -->
	<link rel="stylesheet" type="text/css" href="elfinder/css/elfinder.min.css">
	<link rel="stylesheet" type="text/css" href="elfinder/css/theme.css">

	<!-- elFinder JS (REQUIRED) -->
	<script src="elfinder/js/elfinder.min.js"></script>

	<!-- elFinder translation (OPTIONAL) -->
	<script src="elfinder/js/i18n/elfinder.fr.js"></script>

	<!-- elFinder initialization (REQUIRED) -->
	<script type="text/javascript" charset="utf-8">
		// Documentation for client options:
		// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
		$(document).ready(function() {
			$('#elfinder').elfinder({
				url : 'elfinder/php/connector.improcite.php'  // connector URL (REQUIRED)
				, lang: 'fr'                    // language (OPTIONAL)
			});
		});
	</script>
<?php } ?>

<?php
if (!isPrintMode()) {
	echo "\t<link rel=\"stylesheet\" href=\"../css/improcite2.css\" type=\"text/css\" />\n";
} else {
	echo "\t<link rel=\"stylesheet\" href=\"../css/print.css\" type=\"text/css\" />\n";
}
?>
	<meta name="author" content="Clement OUDOT & Mathieu FREMONT" />
</head>
<body>
	<div class="container">

	<?php include("tete_menu.php"); ?>

	<div id="pagemembres" class="panel panel-body">

<?php
$aUserInfos = fxQueryMultiValues("SELECT prenom, rights FROM impro_comediens WHERE id = ?", array($_SESSION['id_impro_membre']));
$aUserRights = array();
foreach(explode(";", $aUserInfos[1]) as $v)
{
	if ($v)
	{
		$aUserRights[$v] = 1;
	}
}

function fxGetExistingRights()
{
	return 	array("admin"=>"Administrateur", "selection"=>"Sélectionneur", "artistik"=>"Comité&nbsp;artistique", "noselect"=>"Non sélectionnable");
}

function fxUserHasRight($sRight)
{
	$aExisting = fxGetExistingRights();
	if (!$aExisting[$sRight]) die("invalid right : '$sRight'");
	global $aUserRights;
	return (isset($aUserRights[$sRight])  &&  $aUserRights[$sRight] == 1);
}

?>
