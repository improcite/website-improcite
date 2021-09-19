<h1>Nos spectacles</h1>
<?
include(dirname(__FILE__)."/../fxJoueurs.php");

# On recupere la date sous la forme AAAAMMJJhhmmss
$date_actuelle = date("YmdHis") ;

# Affichage des prochains spectacles
$requete_prochains = fxQuery( "SELECT * FROM $t_eve e, $t_cat c, $t_lieu l WHERE c.publique=1 AND e.categorie=c.id AND e.date>$date_actuelle AND e.lieu=l.id ORDER BY date ASC LIMIT 0,9" ) ;
$nb_prochains = @mysql_num_rows ( $requete_prochains );

if ($nb_prochains == 0)
{
?>
	<div class="alert alert-warning">Les spectacles seront bientôt affichés</div>
<?
} else {
	for ($i=0; $i<$nb_prochains; $i++) {
		# Le prochain spectacle
		$id = @mysql_result($requete_prochains, $i, "e.id");
		$cid = @mysql_result($requete_prochains, $i, "c.id");
		$nom = @mysql_result($requete_prochains, $i, "nom");
		$date = @affiche_date(@mysql_result($requete_prochains, $i, "date"));
		$id_lieu = @mysql_result($requete_prochains, $i, "e.lieu");
		$lieu = @affiche_texte(@mysql_result($requete_prochains, $i, "l.nom"));
		$heure = @affiche_heure(@mysql_result($requete_prochains, $i, "date"));
		$commentaire = @mysql_result($requete_prochains, $i, "e.commentaire") ? @affiche_texte(@mysql_result($requete_prochains, $i, "e.commentaire")) : @affiche_texte(@mysql_result($requete_prochains, $i, "c.description"));
		$tarif = @mysql_result($requete_prochains, $i, "tarif");
		$places = @mysql_result($requete_prochains, $i, "places");
		$joueurs = @mysql_result($requete_prochains, $i, "joueurs");
		$animateurs = @mysql_result($requete_prochains, $i, "animateurs");
		$coach = @mysql_result($requete_prochains, $i, "coach");
		$arbitre = @mysql_result($requete_prochains, $i, "arbitre");
		$mc = @mysql_result($requete_prochains, $i, "mc");

		echo "<div class=\"row\">";
		echo "<h2>Le $date &agrave; $heure&nbsp;: $nom</h2>\n";
		echo "<div class=\"col-md-4\">";
		// Affiche la photo de l'evenement ou de la categorie
		$photoEvenement = $sPhotoEvenement.$id.".jpg";
		$photoCategorie = $sPhotoCategorie.$cid.".jpg";
		$photoLieu = $sPhotoLieuRelDir.$id_lieu.".jpg";
		echo "<a href=\"?p=reservation&id_spectacle=".$id."\">\n";
		if ( file_exists($photoEvenement) ) {
			echo "<img src=\"$photoEvenement\" class=\"img-responsive hvr-rotate\" />\n";
		}
		else if ( file_exists($photoLieu) ) {
			echo "<img src=\"$photoLieu\" class=\"img-responsive hvr-rotate\" />\n";
		}		
		elseif( file_exists($photoCategorie) ) {
			echo "<img src=\"$photoCategorie\" class=\"img-responsive hvr-rotate\" />\n";
		}
		echo "</a>";
		echo "</div>";
		echo "<div class=\"col-md-8\">";
		if ($commentaire) {echo "<div class=\"well\">$commentaire</div>\n";}
                if ($places) { ?><div class="text-center" style="margin-bottom:20px;"><button type="button" class="btn btn-lg btn-default" onclick="location='?p=reservation&id_spectacle=<?=$id?>#apage'"><i class="glyphicon glyphicon-shopping-cart"></i> Réserver une place</button></div><? }

		if (trim(str_replace(";", "", $joueurs)) != "")
		{
			fxDispJoueurArray(explode(";", $joueurs), "width:80px;height:60px;");
		}
		if (trim(str_replace(";", "", $animateurs)) != "")
		{
			fxDispJoueurArray(explode(";", $animateurs), "width:80px;height:60px;");
		}

		?>

		<div class="panel panel-warning">
		<div class="panel-heading text-center">Plus d'informations</div>
		<table class="table">

		<?

		if( $lieu) { echo "<tr><th>Lieu</th><td><a href=\"?p=lieux&id=$id_lieu\" title=\"$lieu\">$lieu</a></td></tr>\n";}
		if ($tarif) { echo "<tr><th>Tarif</th><td>$tarif &euro;</td></tr>"; }
		
		if ($coach || $arbitre || $mc)
		{
			if ($coach) {
				$requete_coach = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $coach);
				$nom = @mysql_result($requete_coach, 0, "nom");
				$prenom = @mysql_result($requete_coach, 0, "prenom");
				$surnom = @mysql_result($requete_coach, 0, "surnom");
				$afficherNom = @mysql_result($requete_coach, 0, "affichernom");
				$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");// en fonction du désir de la personne, on l'affiche pas son nom

				echo "<tr><th>Coach</th><td><a href=\"?p=comediens&id=$coach\">$sNomPrenom";
				if ($surnom) { echo " ($surnom)"; }
				echo "</a></td></tr>\n";
			}
			if ($arbitre) {
				$requete_arbitre = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $arbitre);
				$nom = @mysql_result($requete_arbitre, 0, "nom");
				$prenom = @mysql_result($requete_arbitre, 0, "prenom");
				$surnom = @mysql_result($requete_arbitre, 0, "surnom");
				$afficherNom = @mysql_result($requete_arbitre, 0, "affichernom");
				$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");// en fonction du désir de la personne, on l'affiche pas son nom

				echo "<tr><th>Arbitre</th><td><a href=\"?p=comediens&id=$arbitre\">$sNomPrenom";
				if ($surnom) { echo " ($surnom)"; }
				echo "</a></td></tr>\n";
			}
			if ($mc) {
				$requete_mc = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $mc);
				$nom = @mysql_result($requete_mc, 0, "nom");
				$prenom = @mysql_result($requete_mc, 0, "prenom");
				$surnom = @mysql_result($requete_mc, 0, "surnom");
				$afficherNom = @mysql_result($requete_mc, 0, "affichernom");
				$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");// en fonction du désir de la personne, on l'affiche pas son nom

				echo "<tr><th>Ma&icirc;tre de c&eacute;r&eacute;monie</th><td><a href=\"?p=comediens&id=$mc\">$sNomPrenom";
				if ($surnom) { echo " ($surnom)"; }
				echo "</a></td></tr>\n";
			}
		}		

		?>

		</table>
		</div>
		</div>
		</div>
		<hr/>
		<?
	}

}
?>


<?

?>
