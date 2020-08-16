<?php

#====================================================================
# Credits du site Improcite
# 2010 (c) Clement OUDOT
#====================================================================
# Modif Josselin GRANGER - 14/08/2020
# Intégration de l'API et UI box.com
# getBoxToken.php récupère le token JWT nécessaire à l'authentification
#    -> permet à l'app d'afficher le contenu du dossier et autorise l'upload
#		 -> nécessite deux dépendances (cf. doc API)
# 	 -> composer.lock, composer.json, dossier vendor

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

        ?>

					<div class="boxExplorer"></div>
          <!--iframe class="embed-responsive-item" src="../Filemanager/index.html"></iframe-->
				<script>

					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open("GET", "getBoxToken.php");
					xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					xmlhttp.send();

					xmlhttp.onload = function() {
							var contentExplorer = new Box.ContentExplorer();
							contentExplorer.show('0', this.response, {container: '.boxExplorer', logoUrl: '../images/logo-lapin-improcite-avecfond@2x.png'});
					};
				</script>
	<?


	# Fermeture du corps de la page

	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
