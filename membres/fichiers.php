<?php

#====================================================================
# Credits du site Improcite
# 2010 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

$CURRENT_MENU_ITEM = "fichiers";

include ( "tete.php" ) ;

# Verification de la disponibilite de MySQL

if ( ! $connexion || ! $db ) {

	# La connexion a MySQL a echoue, affichage d'un message d'erreur comprehensible

	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;

}

else {

	# MySQL est disponible, on continue !

	# Ouverture du corps de la page

	echo "<div id=\"corps\">\n" ;

	echo "<h1>Fichiers</h1>\n" ;

	//echo "<div id=\"elfinder\">\n";
	//echo "</div>";
	
	
	include_once('FmDe/class/FileManager.php');

	$FileManager = new FileManager("/home/improcit/www/fichiers/data");
	$FileManager2->fmView = 'icons';
	$FileManager->hideSystemType = true;
	$FileManager->hideColumns = array('owner', 'group', 'permissions');
								// size, changed, permissions, owner, group
	$FileManager->logHeight = 0;
	$FileManager->fmCaption = "Improcit&eacute; file manager";
	$FileManager->uploadEngine = "JS";
	$FileManager->fmWidth = "800";
	$FileManager->fmHeight = "600";
	$FileManager->fmMargin = "0";
	print $FileManager->create();

	
	# Fermeture du corps de la page

	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
