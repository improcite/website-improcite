<?php

#====================================================================
# Credits du site Improcite
# 2010 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page
#
$CURRENT_MENU_ITEM = "exercices";

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

	if (getp("new")) {
        ?>

        <div class="embed-responsive embed-responsive-4by3">
          <iframe src="<?php echo "$airtables_form_url" ?>"></iframe>
        </div>

	<?
	} else {
        ?>

        <div class="embed-responsive embed-responsive-4by3">
          <iframe src="<?php echo "$airtables_cards_url" ?>"></iframe>
        </div>

	<?
	}

	# Fermeture du corps de la page

	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
