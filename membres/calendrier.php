<?php

#====================================================================
# Credits du site Improcite
# 2010 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

$CURRENT_MENU_ITEM = "calendrier";

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

	echo "<h1>Calendrier (version de travail)</h1>\n" ;

        ?>

        <div class="embed-responsive embed-responsive-4by3">
          <iframe class="embed-responsive-item" src="https://docs.google.com/spreadsheets/d/1VwGlw6bNW0ThPGdDQ6Hg1F1TjOl4M844op7jt4IwUbA/pubhtml?gid=2015704494&single=true"></iframe>
        </div>

	<?


	# Fermeture du corps de la page

	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
