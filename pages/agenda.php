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
	<h2>Les spectacles seront bientôt affichés</h2>
	<p>Nous jouons au bar <a href="?p=lieux&id=4">Le Trokson</a> chaque dernier mercredi du mois !</p>
	<p>A bientôt !</p>
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
		$coach = @mysql_result($requete_prochains, $i, "coach");
		$arbitre = @mysql_result($requete_prochains, $i, "arbitre");
		$mc = @mysql_result($requete_prochains, $i, "mc");

		echo "<div class=\"spectacle\">";
		echo "<h2>Le $date &agrave; $heure ($nom)</h2>\n";
		//echo '<table border="0" width="100%"><tr><td width="50%" valign="top">';
		// Affiche la photo de l'evenement ou de la categorie
		$photoEvenement = $sPhotoEvenement.$id.".jpg";
		$photoCategorie = $sPhotoCategorie.$cid.".jpg";
		$photoLieu = $sPhotoLieuRelDir.$id_lieu.".jpg";
		if ( file_exists($photoEvenement) ) {
			echo "<img src=\"$photoEvenement\" class=\"affiche\" style=\"float:left;\" />\n";
		}
		else if ( file_exists($photoLieu) ) {
			echo "<img src=\"$photoLieu\" class=\"affiche\" style=\"float:left;\" />\n";
		}		
		elseif( file_exists($photoCategorie) ) {
			echo "<img src=\"$photoCategorie\" class=\"affiche\" style=\"float:left;\" />\n";
		}
		//echo "</td><td>";
		echo "<div>";
		if ($commentaire) {echo "<p>$commentaire</p>\n";}
		if( $lieu) { echo "<p><span class=\"intitules\">Lieu&nbsp;:</span> <a href=\"?p=lieux&id=$id_lieu\" title=\"$lieu\">$lieu</a></p>\n";}
		if ($tarif) { echo "<p><span class=\"intitules\">Tarif&nbsp;:</span> $tarif &euro;";
		if ($places)
		{
			?><input type="button" style="float:right" value="Cliquer ici pour réserver votre place" onclick="location='?p=reservation&id_spectacle=<?=$id?>'"><?
		}
		echo "</p>\n";
		}
		
		if ($coach || $arbitre || $mc)
		{
			if ($coach) {
				$requete_coach = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $coach);
				$nom = @mysql_result($requete_coach, 0, "nom");
				$prenom = @mysql_result($requete_coach, 0, "prenom");
				$surnom = @mysql_result($requete_coach, 0, "surnom");
				$afficherNom = @mysql_result($requete_coach, 0, "affichernom");
				$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");// en fonction du désir de la personne, on l'affiche pas son nom

				echo "<span class=\"intitules\">Coach&nbsp;:</span> <a href=\"?p=comediens&id=$coach\">$sNomPrenom";
				if ($surnom) { echo " ($surnom)"; }
				echo "</a><br />\n";
			}
			if ($arbitre) {
				$requete_arbitre = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $arbitre);
				$nom = @mysql_result($requete_arbitre, 0, "nom");
				$prenom = @mysql_result($requete_arbitre, 0, "prenom");
				$surnom = @mysql_result($requete_arbitre, 0, "surnom");
				$afficherNom = @mysql_result($requete_arbitre, 0, "affichernom");
				$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");// en fonction du désir de la personne, on l'affiche pas son nom

				echo "<span class=\"intitules\">Arbitre&nbsp;:</span> <a href=\"?p=comediens&id=$arbitre\">$sNomPrenom";
				if ($surnom) { echo " ($surnom)"; }
				echo "</a><br />\n";
			}
			if ($mc) {
				$requete_mc = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $mc);
				$nom = @mysql_result($requete_mc, 0, "nom");
				$prenom = @mysql_result($requete_mc, 0, "prenom");
				$surnom = @mysql_result($requete_mc, 0, "surnom");
				$afficherNom = @mysql_result($requete_mc, 0, "affichernom");
				$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");// en fonction du désir de la personne, on l'affiche pas son nom

				echo "<span class=\"intitules\">Ma&icirc;tre de c&eacute;r&eacute;monie&nbsp;:</span> <a href=\"?p=comediens&id=$mc\">$sNomPrenom";
				if ($surnom) { echo " ($surnom)"; }
				echo "</a><br />\n";
			}
		}		

		if (trim(str_replace(";", "", $joueurs)) != "")
		{
			echo "Avec&nbsp;:";
			fxDispJoueurArray(explode(";", $joueurs), "width:80px;height:60px;");
		}


		echo "</div>";
		echo "</div>";
		//echo "</td></tr></table>";
		echo "<hr/>";

	}

}
?>


<?

?>
