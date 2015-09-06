<h1>Informations sur le spectacle</h1>
<?
include(dirname(__FILE__)."/../fxJoueurs.php");

function dispPlaces($iNbRest, $iTotal)
{
	if ($iNbRest == 0)
	{
		return "Plus de places disponibles en r&eacute;servation.";
	}
	else
	{
		$iPct = $iNbRest/$iTotal*100;
		if ($iPct>80)
		{
			return "Pas mal de places restantes.";
		}
		else if ($iPct>40)
		{
			return "Encore des places restantes.";
		}
		else
		{
			return "Plus beaucoup de places&nbsp;!";
		}
	}
}

# On verifie l'action
$action = getp("action");

if ( $action == "Valider" )
{
	# Recuperation et validation des parametres
	$id_spectacle = $_REQUEST[ "id_spectacle" ] ;
	$places = $_REQUEST[ "places" ] ;
	$nom = $_REQUEST[ "nom" ] ;
	$prenom = $_REQUEST[ "prenom" ] ;
	$email = $_REQUEST[ "email" ] ;
	$telephone = $_REQUEST[ "telephone" ] ;

	$requete_spectacle = @mysql_query( "SELECT * FROM $t_eve WHERE id=$id_spectacle AND places>0" ) ;
	$nb = @mysql_num_rows ( $requete_spectacle ) ;

	if ( $nb != 1 )
	{
		echo "<p class=\"titre2\">Spectacle demand&eacute; introuvable...</p>\n";
		echo "<p>Merci de renouveller l'op&eacute;ration.</p>\n";
	}
	else if (!$nom || !$prenom || !$email)
	{	# Test des parametres
		echo "<p class=\"titre2\">Tous les champs n'ont pas &eacute;t&eacute; remplis...</p>\n";
		echo "<p>Merci de renouveller l'op&eacute;ration.</p>\n";
	}
	else
	{
		# Infos du spectacle
		$infos = @mysql_fetch_array( $requete_spectacle ) ;
		$date_res =  date("YmdHis");
		
		# On inscrit la reservation dans la base de donnees
		@mysql_query("INSERT INTO $t_res ( `id` , `evenement` , `places` , `nom` , `prenom` , `email`, `telephone`, `date` ) 
			VALUES ( '' , '$id_spectacle' , '$places' , '$nom' , '$prenom' , '$email', '$telephone', $date_res )") ;
		
		$ref = @mysql_insert_id() ;
		
		echo "<p class=\"titre3\">R&eacute;capitulatif de votre r&eacute;servation&nbsp;:</p>\n" ;
		
		echo "<p><span class=\"intitules\">Date du spectacle :</span> ".@affiche_date( $infos["date"] )."<br />\n" ;
		#echo "<span class=\"intitules\">Lieu du spectacle :</span> ".$infos["lieu"]."<br />\n" ;
		echo "<span class=\"intitules\">Nombre de places :</span> ".$places."<br />\n" ;
		echo "<span class=\"intitules\">R&eacute;f&eacute;rence :</span> 1PRO6TE_$ref (&agrave; nous communiquer pour le retrait sur place)</p>\n" ;
		
		echo "<p class=\"titre3\">Inscription &agrave; la lettre d'informations&nbsp;:</p>\n" ;
		
		echo "<p>Elle vous permet de rester facilement inform&eacute; de l'actualit&eacute; d'Improcit&eacute;.</p>\n";
		?>
		
		<table style="border:1px solid #aa0033; font-size:small" align=center>
			<tr>
			<td>
			<? afficher_inscription_newsletter($email); ?>
			</td>
			</tr>
			<tr>
			<td>
			<a href="http://groups.google.com/group/improcite-infos">Voir les archives</a> sur <a href="http://groups.google.com/">groups.google.com</a>
			</td>
			</tr>
		</table>
		<?
	}

}
else if ( $action == "Choisir" || $_REQUEST[ "id_spectacle" ] )
{ 
	
	# On affiche le formulaire pour reserver

	$id_spectacle = $_REQUEST[ "id_spectacle" ];
	if ($_REQUEST[ "id_spectacle" ]) { $id_spectacle = $_REQUEST[ "id_spectacle" ]; };
		
	if ( !$id_spectacle ) {
		echo "<p class=\"titre2\">Aucun spectacle n'a &eacute;t&eacute;s&eacute;lectionn&eacute;</p>\n" ;	
		echo "<p>Merci de renouveller l'op&eacute;ration.</p>\n";

		echo "</div>\n" ;
		@include( "pied.php" );
		exit;
	}
	
	$requete_spectacle = @mysql_query( "SELECT * FROM $t_eve WHERE id=$id_spectacle" ) ;
	$nb = @mysql_num_rows ( $requete_spectacle ) ;
	$infos = @mysql_fetch_array($requete_spectacle) ;
	
	$requete_lieu = @mysql_query( "SELECT * FROM $t_lieu WHERE id=" . $infos['lieu'] ) ;
	$infosLieu = @mysql_fetch_array($requete_lieu) ;

	if ( $nb != 1 ) {
		echo "<p class=\"titre2\">Spectacle demand&eacute; introuvable...</p>\n";
		echo "<p>Merci de renouveller l'op&eacute;ration.</p>\n";

		echo "</div>\n" ;
		@include( "pied.php" );
		exit;
	}

	# Calcul des places restantes
	$requete_places = @mysql_query( "SELECT SUM(places) AS total FROM $t_res WHERE evenement=$id_spectacle" ) ;
	$resultat_places = @mysql_fetch_array( $requete_places );
	$places_res = $resultat_places['total'];
	$places_restantes = $infos[ "places" ] - $places_res;

	# Infos du spectacle

	// Affiche la photo de l'evenement ou de la categorie
	$photoEvenement = $sPhotoEvenement.$infos["id"].".jpg";
	$photoCategorie = $sPhotoCategorie.$infos["categorie"].".jpg";
	$photoLieu = $sPhotoLieuRelDir.$infos["lieu"].".jpg";
	if ( file_exists($photoEvenement) ) {
		echo "<img src=\"$photoEvenement\" class=\"affiche\" style=\"float:left;margin-right:20px;\"/>\n";
	}
	elseif ( file_exists($photoLieu) ) {
		echo "<img src=\"$photoLieu\" class=\"affiche\" style=\"float:left;margin-right:20px;\"/>\n";
	}	
	elseif( file_exists($photoCategorie) ) {
		echo "<img src=\"$photoCategorie\" class=\"affiche\" style=\"float:left;margin-right: 20px;\"/>\n";
	}
	
	echo "<p>";
	?>Le <?=@affiche_date( $infos["date"] )?>, <a href="?p=lieux&id=<?=$infosLieu['id']?>"><?=$infosLieu["nom"]?></a>
	<br/>
	<br/><?
	
	
	if ($infos["commentaire"]) {echo affiche_texte($infos["commentaire"])."<br />\n" ;}
	
	if ($resultat_places['total'])
	{
		echo "<span class=\"intitules\">Places disponibles&nbsp;:</span> ".dispPlaces($places_restantes, $infos[ "places" ])."<br />\n" ;
	}
	
	if ($infos["tarif"])
	{
		echo "<span class=\"intitules\">Prix de la place&nbsp;:&nbsp;</span> ".$infos["tarif"]."&euro;<br />\n" ;
	}
	
	?><br/><span class=\"intitules\">Joueurs&nbsp;:&nbsp;</span></br><?
	$selectionnes = $infos['joueurs'] .";" . $infos['mc'] . ";" . $infos['arbitre'] . ";" . $infos['coach']; 
	fxDispJoueurArray(explode(";", $selectionnes), "width:80px;height:60px;");
	
	echo "</p>";
	
	if ($places_restantes)
	{
		$max_places = $places_restantes > 5 ? 5 : $places_restantes ;
	
		?>
		<hr style="clear:both"/>
		<form method="get">
		<input type="hidden" name="p" value="reservation">
		<?
	
		# Renseignements a fournir
		echo "<h3>Nombre de places à r&eacute;server :\n" ;
		echo "<select name=\"places\"/>\n" ;
	
		for ( $i = 1 ; $i <= $max_places ; $i++ )
		{
			echo "<option value=\"$i\">$i</option>\n" ;
		}
		echo "</select></h3>\n" ;
		?>
		
		<h3>Coordonn&eacute;es&nbsp;:</h3>
		<table>
		<tr><th>Nom&nbsp;:</th><td><input type="text" name="nom" /> *</td></tr>
		<tr><th>Pr&eacute;nom&nbsp;:</th><td><input type="text" name="prenom" /> *</td></tr>
		<tr><th>E-mail&nbsp;:</th><td><input type="text" name="email" /> *</td></tr>
		<tr><th>T&eacute;l&eacute;phone&nbsp;:</th><td><input type="text" name="telephone" /></td></tr>
		<!--<tr><th></th><td><input type="checkbox" name="newsletter" />S'inscrire à la newsletter *</td></tr>-->
		</table>
		
		<input type="hidden" name="id_spectacle" value="<?=$id_spectacle?>" />
		<input type="hidden" name="action" value="Valider" />
		<p><input type="submit" value="Valider la r&eacute;servation" /></p>
		</form>
		
		<div style="border: 1px solid red; padding:3px;font-size:80%;">
		Attention les réservations sont valables jusqu'à l'heure de début du spectacle (20h30 par exemple pour tes "Trokson").<br/>
		Après cet horaire, les réservations ne seront plus garanties.
		</div>
		<br/>
		<hr/>
		<?
	}

}
else
{
	# On affiche le formulaire pour reserver
	echo "<p class=\"titre2\">Choisissez votre spectacle&nbsp;:</p>\n" ;

	# Affichage des prochains spectacles
		
	# On recupere la date sous la forme AAAAMMJJhhmmss
	$date_actuelle = date("YmdHis") ;

	$requete_prochains = @mysql_query ( "SELECT * FROM $t_eve e, $t_cat c WHERE c.publique=1 AND e.categorie=c.id AND e.date>$date_actuelle AND e.places>0 ORDER BY date ASC LIMIT 0,9" ) ;

	$nb_prochains = @mysql_num_rows( $requete_prochains ) ;

	if ( $nb_prochains > 0 )
	{
		?><form method="get">
		<input type="hidden" name="p" value="reservation">
		<select name="id_spectacle" onChange="if (this.value!='') this.form.submit();">
		<option default="default" value="">Liste des spectacles...</option><?

		for ( $i = 0 ; $i < $nb_prochains ; $i++ )
		{
			$id = @mysql_result( $requete_prochains , $i , "e.id" ) ;
			$nom = @mysql_result( $requete_prochains , $i , "c.nom" ) ;
			$date = @affiche_date( @mysql_result( $requete_prochains , $i , "e.date" ) ) ;
			$tarif = @mysql_result( $requete_prochains , $i , "e.tarif" ) ;
			$places = @mysql_result( $requete_prochains , $i , "e.places" ) ;
	
			# Requete pour connaitre le nb de places deja reservees
			$requete_places = @mysql_query( "SELECT SUM(places) AS total FROM $t_res WHERE evenement=$id" ) ;
			$resultat_places = @mysql_fetch_array( $requete_places );
			$places_res = $resultat_places['total'];
			$places_restantes = $places -  $places_res;
	
			if ( $places_restantes > 0 )
			{
				echo "<option value=\"$id\">$nom ($date) [$tarif] : ".dispPlaces($places_restantes,$places)."</option>\n" ;
			}
			else
			{
				echo "<option>$nom ($date) [$tarif] : PLUS DE PLACE</option>\n" ;
			}
		}

		echo "</select>\n" ;
		?><input type="hidden" name="action" value="Choisir" /><?
		echo "<input type=\"submit\" value=\"Choisir\" />\n" ;
		echo "</form>\n" ;

	}
	else
	{
		echo "<p>Pas de spectacles avec r&eacute;servations... Merci de revenir plus tard.</p>" ;
	}

}

?>
