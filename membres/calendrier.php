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
          <iframe class="embed-responsive-item" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vS4AttoYcGZbi2KFrrpe7mgqLQijHegATDS_cpAqBlNI6giBUdweHssnKBHSmd4gyU5MuLrpE9t7pQB/pubhtml?gid=1752712870&amp;single=true&amp;widget=true&amp;headers=false"></iframe>
        </div>

	<?


	# Fermeture du corps de la page

	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
