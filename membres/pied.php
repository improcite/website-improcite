<?php

#====================================================================
# Pied des pages Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Ouverture du pied de page

echo "<div id=\"pied\">\n" ;

# Barre

//echo "<img src=\"../images/barre_boulette2.gif\" alt=\"barre de s&eacute;paration\" />\n" ;

# Contenu du pied de page

//echo "<p>".date("Y")." (c) Improcit&eacute;</p>\n" ;

# Fermeture du pied de page

echo "</div>\n" ;

# Fermeture du cadre maitre

echo "</div>\n" ;

# Fermeture BODY

echo "</body>\n";

# Fermeture HTML

echo "</html>\n" ;

# Fermeture de la connexion MySQL

if ( $connexion ) {

	# La connexion a MySQL existe, on la ferme

	@mysql_close ( $connexion ) ;

}

if(isPrintMode())
{
	?>
	<script>
	window.print();
	</script>
	<?
}

?>
