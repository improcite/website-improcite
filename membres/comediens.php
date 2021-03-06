<?

# Recuperation de l'id par la methode GET
$id = getp("id");

# Si un id de comedien a ete precise on affiche la fiche du comedien
# Sinon c'est le tableau des comediens qu'on affiche

if ($id)
{

	# la variable $id est remplie. Recherche de la fiche du comedien.
	$rqComedien = @mysql_fetch_array(mysql_query ( "SELECT * FROM $table_comediens WHERE id=$id" ));

	# Affichage de l'image trame de la fiche
	//echo "<img class=\"logo_fiche\" src=\"images/fiche.gif\" alt=\"D&eacute;cor\" />\n" ;

	if ( $rqComedien ) {
	
		# Une fiche a ete trouvee -> Recuperation des informations
		$surnom = $rqComedien[ "surnom" ] ;
		$prenom = $rqComedien[ "prenom" ] ;
		$nom = $rqComedien[ "nom" ] ;
		$afficherNom = $rqComedien[ "affichernom" ] ;
		$jour = $rqComedien[ "jour" ] ;
		$mois = $rqComedien[ "mois" ] ;
		$annee = $rqComedien[ "annee" ] ;
		$email = $rqComedien[ "email" ] ;
		$qualite = affiche_texte ( $rqComedien[ "qualite" ] ) ;
		$defaut = affiche_texte ( $rqComedien[ "defaut" ] ) ;
		$debut = affiche_texte ( $rqComedien[ "debut" ] ) ;
		$debutimprocite = affiche_texte ( $rqComedien[ "debutimprocite" ] ) ;
		$envie = affiche_texte ( $rqComedien[ "envie" ] ) ;
		$apport = affiche_texte ( $rqComedien[ "apport" ] ) ;
		$improcite = affiche_texte ( $rqComedien[ "improcite" ] ) ;
			
		# Photo du comedien
		$photo = $sPhotoRelDir.$currentSaisonBit."/"."$id.jpg" ;
		if ( !file_exists( $photo ) ) {
			$photo = $sPhotoRelDir."$id.jpg" ;
		}

		# En gros on affiche le prenom du comedien, et le surnom s'il est différent
		echo "<h1>$prenom" ;

		echo "</h1>\n" ;
		echo "<div id=\"comedien\">\n";
		// en fonction du désir de la personne, on l'affiche pas son nom
		$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");

		if ( file_exists( $photo ) ) {
			# Si la photo existe on l'affiche
			echo "<img class=\"photo_fiche\" src=\"$photo\" alt=\"Photo de $sNomPrenom\" title=\"$sNomPrenom\" />\n" ;
		}

		//echo "<p><span class=\"intitules\">Matricule&nbsp;:</span> $sNomPrenom</p>\n" ;
		//echo "<p><span class=\"intitules\">Venue au monde&nbsp;:</span> $jour / $mois / $annee</p>\n" ;
		
		if ( $surnom ) {
			echo "<p><span class=\"intitules\">Alias&nbsp;:</span> $surnom</p>\n" ;
		}


		// Personnages OMERTA
		//$rqOmerta = @mysql_query ( "SELECT * FROM $t_omerta WHERE id_comedien=$id ORDER BY nom" );
		//$nbOmerta = @mysql_num_rows( $rqOmerta );


		if (isset($nbOmerta)) {
			echo "<p><span class=\"intitules\">Ses personnages Omerta&nbsp;:</span>";
			while ( $resOmerta = @mysql_fetch_array ( $rqOmerta ) ) {
				echo " <a href=\"index.php?p=omerta&id=".$resOmerta['id']."\">".$resOmerta['nom']."</a>";
			}
			echo "</p>";
		}

		if ($debut) echo "<p><span class=\"intitules\">D&eacute;but dans l'improvisation&nbsp;:</span> $debut</p>\n" ;

		if ($envie) echo "<p><span class=\"intitules\">Comment as-tu eu envie de faire de l'improvisation&nbsp;?</span> $envie</p>\n" ;
		if ($apport) echo "<p><span class=\"intitules\">Que t'apporte l'improvisation ?</span> $apport</p>\n" ;
		if ($debutimprocite) echo "<p><span class=\"intitules\">Ton arrivée à ImproCité ?</span> $debutimprocite</p>\n" ;
		if ($improcite) echo "<p><span class=\"intitules\">Improcit&eacute; pour toi c'est&nbsp;:</span> $improcite</p>\n" ;
		if ($qualite) echo "<p><span class=\"intitules\">Qualit&eacute; en impro&nbsp;:</span> $qualite</p>\n" ;
		if ($defaut) echo "<p><span class=\"intitules\">D&eacute;faut en impro&nbsp;:</span> $defaut</p>\n" ;
		echo "<div style=\"clear:both\"></div>\n";
		echo "</div>\n";
	} else {
		# La fiche n'a pas ete trouvee
		echo "<p class=\"titre\">La fiche demand&eacute;e est introuvable</p>\n" ;
	}

	?>
	<p>Cliquez ici pour voir <a href="?p=comediens" title="Retour">les autres com&eacute;diens</a></p>
	<br/>
	<?

} else {

	# On affiche le tableau de tous les comediens

	?>
	<h1>Les com&eacute;diens d'Improcit&eacute;</h1>
	<?

	// Toutes les catégories
	// (sous-titre => sélection SQL)
	
	$aSaisonNames = explode(",", $saisonAdminString);
	
	$iMaskCurrentYear = 1 << $iCurrentSaisonNumber;
	$iMaskLastYear = 1 << ($iCurrentSaisonNumber -1);
	
	$aCategories = array(
		"Saison ".$aSaisonNames[$iCurrentSaisonNumber] => $iCurrentSaisonNumber,
		"Saison ".$aSaisonNames[$iCurrentSaisonNumber-1] => $iCurrentSaisonNumber-1,
		);
	
	
	foreach( $aCategories as $sTitre => $iSaisonNumber )
	{
		?>
<h2 style="clear:both;"><?=$sTitre?></h2> 
<ul class="comediens">
		<?
		$iMask = 1 << $iSaisonNumber;
		$iSaisonBit = pow( 2, $iSaisonNumber );
		$sConditionSQL = "saison & ". $iMask ." <> 0";
		$rqComedien = @mysql_query ( "SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE $sConditionSQL ORDER BY nom" );
		$nb = @mysql_num_rows( $rqComedien ) ;
		
		# Boucle sur chaque resultat
		while ( $resultat_tous_comediens = @mysql_fetch_array ( $rqComedien ) ) {
		
			//print_r( $resultat_tous_comediens );
	
			$id = $resultat_tous_comediens[ "id" ] ;
			$prenom = $resultat_tous_comediens[ "prenom" ] ;
			$nom = $resultat_tous_comediens[ "nom" ] ;
			$surnom = $resultat_tous_comediens[ "surnom" ] ;
			$afficherNom = $resultat_tous_comediens[ "affichernom" ] ;
			$photo = $sPhotoRelDir.$iSaisonBit."/"."$id.jpg" ;
			if ( !file_exists( $photo ) ) {
				$photo = $sPhotoRelDir."$id.jpg" ;
			}
	
			# Affichage de la photo si elle existe, sinon une image par defaut
			if ( ! file_exists( $photo ) ) {
				$photo = $sPhotoRelDir."defaut.jpg" ;
			}
			
			// en fonction du désir de la personne, on l'affiche pas son nom
			$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");
	
			echo "<li><a href=\"?p=comediens&id=$id#apage\" title=\"$sNomPrenom\">\n" ;
			echo "<img class=\"photo_comedien\" src=\"$photo\" alt=\"Photo de $sNomPrenom\" />\n";
			echo "</a></li>\n" ;
		}
	
		# Liberation de la memoire MySQL
		@mysql_free_result ( $rqComedien ) ;
	}
	
}

?>
</ul>
