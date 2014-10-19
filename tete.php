<?php

#====================================================================
# Tete des pages Improcite - Memebres
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

# Chargement des fonctions
require_once ( "../fonctions.inc.php" ) ;

# Lancement de la connexion MySQL
include ( "../connexion_mysql.php" ) ;

include ( "../fxDB.php" );

# XML
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n" ;

# Doctype 
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";

# Ouverture HTML
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n";

# Ouverture HEAD

echo "<head>\n";
echo "<title>Improcite - Espace membres</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n";

if (!isPrintMode())
{
	echo "<link rel=\"stylesheet\" href=\"../improcite.css\" type=\"text/css\" />\n";
}
else
{
	echo "<link rel=\"stylesheet\" href=\"../print.css\" type=\"text/css\" />\n";
}
echo "<meta name=\"author\" content=\"Clement OUDOT & Mathieu FREMONT\" />\n";

?>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<?


# Javascripts

?>
<script src="js/bootstrap.min.js"></script>
<?

echo "<script type=\"text/javascript\" src=\"../jquery-1.3.2.min.js\"></script>\n" ;
echo "<script type=\"text/javascript\" src=\"../jquery.lavalamp.min.js\"></script>\n" ;
echo "<script type=\"text/javascript\" src=\"../improcite.js\"></script>\n" ;

# Fermeture HEAD

echo "</head>\n" ;

# Ouverture BODY

echo "<body>\n";

# Ouverture Maitre

echo "<div id=\"maitre\">\n" ;

# Ouverture Menu
echo "<div id=\"menu\">\n" ;

include("tete_menu.php");

# Fermeture Menu
echo "</div>\n" ;


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
