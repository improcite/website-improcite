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

	# Traitement des actions
	$deleted = false;
	if ( getp("action") === "delete" and getp("id") ) {
		$id = mysql_real_escape_string( getp("id") );
		$deleted = mysql_query("DELETE FROM $t_res WHERE id=$id");
	}

	$places_updated = false;
	if ( getp("action") === "updateplaces" and getp("id") and getp("places") ) {
		$id = mysql_real_escape_string( getp("id") );
		$places = mysql_real_escape_string( getp("places") );
		$places_updated = mysql_query("UPDATE $t_res SET places=$places WHERE id=$id");
	}

	# Ouverture du corps de la page

	echo "<div id=\"corps\">\n" ;

	if ($deleted) {
		echo "<div class=\"alert alert-success\">La r&eacute;servation 1PRO6T_$id a &eacute;t&eacute; supprim&eacute;e</div>\n";
	}

	if ($places_updated) {
		echo "<div class=\"alert alert-success\">Les places pour la r&eacute;servation 1PRO6T_$id ont &eacute;t&eacute; modifi&eacute;es</div>\n";
	}

	echo "<h1>Liste des r&eacute;servations</h1>\n" ;

	# Affichage des prochains spectacles
		
	# On recupere la date sous la forme AAAAMMJJhhmmss

	$date_actuelle = date("YmdHis") ;

	$requete_prochains = @mysql_query ( "SELECT * FROM $t_eve e, $t_cat c WHERE c.publique=1 AND e.categorie=c.id AND e.places>0 AND e.date>=$date_actuelle ORDER BY date ASC LIMIT 0,8" ) ;

	$nb_prochains = @mysql_num_rows( $requete_prochains ) ;

	if ( $nb_prochains > 0 )
	{

			for ( $i = 0 ; $i < $nb_prochains ; $i++ )
			{

				$id = @mysql_result( $requete_prochains , $i , "e.id" ) ;
				$nom = @mysql_result( $requete_prochains , $i , "c.nom" ) ;
				$date = @affiche_date( @mysql_result( $requete_prochains , $i , "e.date" ), true ) ;
				$tarif = @mysql_result( $requete_prochains , $i , "e.tarif" ) ;
				$places = @mysql_result( $requete_prochains , $i , "e.places" ) ;

				echo "<h2>$nom - $date - $places places maximum</h2>\n" ;

				# Requete pour connaitre le nb de places deja reservees

				$requete_places = @mysql_query( "SELECT * FROM $t_res WHERE evenement=$id ORDER BY nom ASC" ) ;

				$places_tot = 0 ;

				echo "<div class='table-responsive'>\n";
				echo "<table class='table table-striped'>\n";
				echo "<thead>\n";
				echo "<tr>\n";
				echo "<th>Nom</th>\n";
				echo "<th>Places</th>\n";
				echo "<th>Email</th>\n";
				echo "<th>T&eacute;l&eacute;phone</th>\n";
				echo "<th>R&eacute;serv&eacute; le</th>\n";
				echo "<th>R&eacute;f&eacute;rence</th>\n";
				echo "<th></th>\n";
				echo "</tr>\n";
				echo "</thead>\n";
				echo "<tbody>\n";

				while ( $resultat_places = @mysql_fetch_array( $requete_places ) ) {

					$id = $resultat_places["id"];
					$ref = "1PRO6TE_$id" ;
					$places_res = $resultat_places["places"] ;
					$nom_res = $resultat_places["nom"] ;
					$prenom_res = $resultat_places["prenom"] ;
					$email_res = $resultat_places["email"] ;
					$tel_res = $resultat_places["telephone"] ;
					$date_res = @affiche_date( $resultat_places["date"], true );
					
					$places_tot += $places_res ;

					echo "<tr>\n";
					echo "<td>$nom_res $prenom_res</td>\n";
					echo "<td>";
					if ( $places_res > 1) { echo "<a href=\"reservation.php?id=$id&action=updateplaces&places=".($places_res-1)."\" title=\"Enlever une place\" class=\"text-danger\">"; }
					echo "<i class=\"glyphicon glyphicon-minus-sign bouton\"></i>";
					if ( $places_res > 1) { echo "</a>"; }
					echo " $places_res ";
					echo "<a href=\"reservation.php?id=$id&action=updateplaces&places=".($places_res+1)."\" title=\"Ajouter une place\" class=\"text-success\">";
					echo "<i class=\"glyphicon glyphicon-plus-sign bouton\"></i>";
					echo "</a>";
					echo "</td>\n";
					echo "<td>$email_res</td>\n";
					echo "<td>$tel_res</td>\n";
					echo "<td>$date_res</td>\n";
					echo "<td>$ref</td>\n";
					echo "<td><a href=\"reservation.php?id=$id&action=delete\" title=\"Supprimer\" class=\"text-danger\"><i class=\"glyphicon glyphicon-trash bouton\"></i></a></td>\n";
					echo "</tr>\n";
				}

				echo "</tbody>\n";
				echo "</table>\n";
				echo "</div>\n";

				$places_restantes = $places - $places_tot ;
				$places_percent = floor($places_tot/$places*100);

				echo "<div class='progress'>\n";
				echo "<div class='progress-bar progress-bar-striped active'  role='progressbar' aria-valuenow='$places_tot' aria-valuemin='0' aria-valuemax='$places' style='width: $places_percent%'>\n";
				echo "<span>$places_tot/$places places ($places_percent%)</span>";
				echo "</div>\n";
				echo "</div>\n";
				echo "<p>$places_restantes places restantes pour ce spectacle</p>\n";
				
				if(isPrintMode())
				{
					break; // only 1st
				}

			}

		} else {

			echo "<p>Pas de spectacles avec r&eacute;servations.</p>" ;
		
		}
	
	if(isPrintMode() == false)
	{
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
			echo "<div class='table-responsive'>\n";
			echo "<table class='table table-striped'>\n";
			echo "<thead>\n";
			echo "<tr>\n";
			echo "<td></td>\n";
			echo "<th>Places disponibles</th>\n";
			echo "<th>Places r&eacute;serv&eacute;es</th>\n";
			echo "<th>Remplissage</th>\n";
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
				$percent = floor($places_tot/$places*100);

				echo "<tr>\n";
				echo "<th>$nom - $date</th>\n";
				echo "<td>$places</td>\n";
				echo "<td>$places_tot</td>\n";
				echo "<td>\n";
				echo "<div class=\"progress\">\n";
				echo "<div class=\"progress-bar progress-bar-success progress-bar-striped\" role=\"progressbar\" aria-valuenow=\"$places_tot\" aria-valuemin=\"0\" aria-valuemax=\"$places\" style=\"width: $percent%\">\n";
				echo "<span>$percent%</span>\n";
				echo "</div>\n";
				echo "</div>\n";
				echo "</td>\n";
				echo "</tr>\n";

			}

			echo "</tbody>\n";
			echo "</table>\n";
			echo "</div>\n";
		} else {
			echo "<p>Pas de statistiques disponibles.</p>\n";
		}

	}

	DisplayPrintButton();

	# Fermeture du corps de la page

	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
