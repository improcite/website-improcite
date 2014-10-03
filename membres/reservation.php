<?php

#====================================================================
# Credits du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

$CURRENT_MENU_ITEM = "reservation";

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

	echo "<h1>Liste des r&eacute;servations</h1>\n" ;

	# Affichage des prochains spectacles
		
	# On recupere la date sous la forme AAAAMMJJhhmmss

	$date_actuelle = date("YmdHis") ;

	$requete_prochains = @mysql_query ( "SELECT * FROM $t_eve e, $t_cat c WHERE c.publique=1 AND e.categorie=c.id AND e.places>0 AND e.date>=$date_actuelle ORDER BY date ASC LIMIT 0,8" ) ;

	$nb_prochains = @mysql_num_rows( $requete_prochains ) ;

	if ( $nb_prochains > 0 ) {

		for ( $i = 0 ; $i < $nb_prochains ; $i++ ) {

			$id = @mysql_result( $requete_prochains , $i , "e.id" ) ;
			$nom = @mysql_result( $requete_prochains , $i , "c.nom" ) ;
			$date = @affiche_date( @mysql_result( $requete_prochains , $i , "e.date" ) ) ;
			$tarif = @mysql_result( $requete_prochains , $i , "e.tarif" ) ;
			$places = @mysql_result( $requete_prochains , $i , "e.places" ) ;

		echo "<h2>$nom - $date - $places places maximum</h2>\n" ;

			# Requete pour connaitre le nb de places deja reservees

			$requete_places = @mysql_query( "SELECT * FROM $t_res WHERE evenement=$id ORDER BY nom ASC" ) ;

			$places_tot = 0 ;

			while ( $resultat_places = @mysql_fetch_array( $requete_places ) ) {

				$ref = "1PRO6TE_".$resultat_places["id"] ;
				$places_res = $resultat_places["places"] ;
				$nom_res = $resultat_places["nom"] ;
				$prenom_res = $resultat_places["prenom"] ;
				$email_res = $resultat_places["email"] ;
				$tel_res = $resultat_places["telephone"] ;
				$date_res = @affiche_date( $resultat_places["date"] );
				
				$places_tot += $places_res ;

				echo "<p>$places_res places r&eacute;serv&eacute;es pour $prenom_res $nom_res ($email_res - $tel_res)";
				if ($date_res) { echo " le $date_res"; }
				echo " (r&eacute;f&eacute;rence $ref)</p>\n";
				
			}

			$places_restantes = $places - $places_tot ;

			echo "<p>$places_restantes places restantes pour ce spectacle</p>\n" ;
		}

			} else {

			echo "<p>Pas de spectacles avec r&eacute;servations.</p>" ;
		
		}
	
	echo "<h1>Statistiques</h1>\n" ;

	# Filtre de recherche 
	# -> Debut de saison -> date actuelle
	$datedebut = 2004 + $iCurrentSaisonNumber;
	$datedebut .= "0901000000";
	# -> Spectacles avec au moins 1 place
	# -> Categorie liee au spectacle
	
	$filtresql = "e.places > 0 AND e.date > $datedebut AND e.date < $date_actuelle and e.categorie = c.id";
	$requete_stats_resas = @mysql_query( "SELECT * FROM $t_eve e, $t_cat c WHERE $filtresql ORDER BY e.date ASC" ) ;
	$nb_stats_resas = @mysql_num_rows( $requete_stats_resas );

	if ( $nb_stats_resas > 0 ) {
		echo "<table class='stats'>\n";
		echo "<caption>Statistiques des r&eacute;servations pour chaque spectacle</caption>\n";
		echo "<thead>\n";
		echo "<tr>\n";
		echo "<td></td>\n";
		echo "<th scope='col'>Places disponibles</th>\n";
		echo "<th scope='col'>Places r&eacute;serv&eacute;es</th>\n";
		echo "<th scope='col'>Places restantes</th>\n";
		echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";

		for ( $i = 0 ; $i < $nb_stats_resas ; $i++ ) {
			$id = @mysql_result( $requete_stats_resas , $i , "e.id" ) ;
			$nom = @mysql_result( $requete_stats_resas , $i , "c.nom" ) ;
			$date = @affiche_date( @mysql_result( $requete_stats_resas , $i , "e.date" ) ) ;
			$places = @mysql_result( $requete_stats_resas , $i , "e.places" ) ;

                        $requete_places = @mysql_query( "SELECT * FROM $t_res WHERE evenement=$id" ) ;
			$places_tot = 0 ;
			while ( $resultat_places = @mysql_fetch_array( $requete_places ) ) {
				$places_res = $resultat_places["places"] ;
				$places_tot += $places_res ;
			}
			$places_restantes = $places - $places_tot ;

			echo "<tr>\n";
			echo "<th scope='row'>$nom - $date</th>\n";
			echo "<td>$places</td>\n";
			echo "<td>$places_tot</td>\n";
			echo "<td>$places_restantes</td>\n";
			echo "</tr>\n";

		}

		echo "</tbody>\n";
		echo "</table>\n";
	} else {
		echo "<p>Pas de statistiques disponibles.</p>\n";
	}



	# Fermeture du corps de la page

	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
