<?
include(dirname(__FILE__)."/../fxJoueurs.php");

function dispPlaces($iNbRest, $iTotal)
{
	if ($iNbRest <= 0)
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
		echo "<div class=\"alert alert-danger\">Spectacle demand&eacute; introuvable</div>\n";
	}
	else if (!$nom || !$prenom || !$email)
	{	# Test des parametres
		echo "<div class=\"alert alert-danger\">Tous les champs n'ont pas &eacute;t&eacute; remplis</div>\n";
	}
	else
	{
		# Infos du spectacle
		$infos = @mysql_fetch_array( $requete_spectacle ) ;
		$date_res =  date("YmdHis");
		
		# On recalcule les places disponibles
		$requete_places = @mysql_query( "SELECT SUM(places) AS total FROM $t_res WHERE evenement=$id_spectacle" ) ;
		$resultat_places = @mysql_fetch_array( $requete_places );
		$places_res = $resultat_places['total'];
		$places_restantes = $infos[ "places" ] - $places_res;

		if ($places_restantes < $places ) {
			echo "<div class=\"alert alert-danger\">Pas assez de places disponibles</div>\n";
		}

		else {
		# On inscrit la reservation dans la base de donnees
		$mysql_id_spectacle = mysql_real_escape_string($id_spectacle);
		$mysql_places = mysql_real_escape_string($places);
		$mysql_nom = mysql_real_escape_string($nom);
		$mysql_prenom = mysql_real_escape_string($prenom);
		$mysql_email = mysql_real_escape_string($email);
		$mysql_telephone = mysql_real_escape_string($telephone);
		$mysql_date_res = mysql_real_escape_string($date_res);
		@mysql_query("INSERT INTO $t_res ( `id` , `evenement` , `places` , `nom` , `prenom` , `email`, `telephone`, `date` ) 
			VALUES ( '' , '$mysql_id_spectacle' , '$mysql_places' , '$mysql_nom' , '$mysql_prenom' , '$mysql_email', '$mysql_telephone', $mysql_date_res )") ;
		
		$ref = @mysql_insert_id() ;

		# Envoi d'un mail de confirmation
		$subject = "Confirmation de tes places";
		$ml = "<html>\n"
		. "<head><title>$subject</title></head>\n"
		. "<body>\n"
                . "<p>Bonjour $prenom,</p>\n"
                . "<p>Tu as réservé $places place(s) pour notre spectacle, merci ! Ton identifiant de réservation est 1PRO6TE_$ref.</p>\n"
		. "<p>Tu peux retrouver les informations sur ce spectacle en cliquant <a href=\"http://www.improcite.com/?p=reservation&id_spectacle=$id_spectacle#apage\">ici</a>.</p>\n"
                . "<p>À bientôt !</p>\n"
		. "</body>\n"
		. "</html>\n"
                ;

	        // Always set content-type when sending HTML email
	        $headers = "MIME-Version: 1.0 \n";
		$headers .= "Content-Transfer-Encoding: 8bit \n";
	        $headers .= "Content-type:text/html;charset=utf-8 \n";
	        $headers .= 'From: Improcite <contact@improcite.com> ' . "\n";

		$verif_envoi_mail = TRUE;
	        $verif_envoi_mail = @mail($email, $subject, $ml, $headers);

		?>

		<div class="panel panel-info">
		<div class="panel-heading text-center">Réservation validée</div>
		<table class="table">
		<?
		echo "<tr><th>Date du spectacle</th><td>".@affiche_date( $infos["date"] )."</td></tr>\n" ;
		echo "<tr><th>Nombre de places</th><td>$places</td></th>" ;
		echo "<tr><th>Nom</th><td>$prenom $nom</td></th>" ;
		echo "<tr><th>Email</th><td>$email</td></th>" ;
		echo "<tr><th>R&eacute;f&eacute;rence</th><td>1PRO6TE_$ref (&agrave; nous communiquer pour le retrait sur place)</td></tr>\n" ;
		
		?>
		</table>
		</div>

		<? if ($verif_envoi_mail === FALSE ) { ?>
		<div class="alert alert-danger">Erreur lors de l'envoi de l'email de confirmation.</div>
		<? } else { ?>
		<div class="alert alert-success">Un email de confirmation a été envoyé.</div>
		<? } ?>
		<? } ?>

		<div class="panel panel-success">
		<div class="panel-heading text-center">Inscription à la lettre d'informations</div>
		<div class="panel-body">

		
		<p>Elle vous permet de rester facilement inform&eacute; de l'actualit&eacute; d'Improcit&eacute;</p>
		
		<? afficher_inscription_newsletter($email); ?>

		<p><a href="http://groups.google.com/group/improcite-infos">Voir les archives</a></p>

		</div>
		</div>
		<?
	}

}
else if ( $action == "Choisir" || $_REQUEST[ "id_spectacle" ] )
{ 
	
	# On affiche le formulaire pour reserver

	$id_spectacle = $_REQUEST[ "id_spectacle" ];
		
	if ( !$id_spectacle ) {
		echo "<div class=\"alert alert-danger\">Aucun spectacle n'a &eacute;t&eacute; s&eacute;lectionn&eacute;</div>\n" ;	
	} else {
	
	$requete_spectacle = @mysql_query( "SELECT * FROM $t_eve WHERE id=$id_spectacle" ) ;
	$nb = @mysql_num_rows ( $requete_spectacle ) ;
	$infos = @mysql_fetch_array($requete_spectacle) ;
	
	$requete_lieu = @mysql_query( "SELECT * FROM $t_lieu WHERE id=" . $infos['lieu'] ) ;
	$infosLieu = @mysql_fetch_array($requete_lieu) ;

	if ( $nb != 1 ) {
		echo "<div class=\"alert alert-danger\">Spectacle demand&eacute; introuvable</div>\n";
	} else {

	# Calcul des places restantes
	$requete_places = @mysql_query( "SELECT SUM(places) AS total FROM $t_res WHERE evenement=$id_spectacle" ) ;
	$resultat_places = @mysql_fetch_array( $requete_places );
	$places_res = $resultat_places['total'];
	$places_restantes = $infos[ "places" ] - $places_res;

	# Infos du spectacle

	echo "<h1>Informations sur le spectacle</h1>\n";

	// Affiche la photo de l'evenement ou de la categorie
	$photoEvenement = $sPhotoEvenement.$infos["id"].".jpg";
	$photoCategorie = $sPhotoCategorie.$infos["categorie"].".jpg";
	$photoLieu = $sPhotoLieuRelDir.$infos["lieu"].".jpg";
	?>
	<div class="row">
	<div class="col-md-4">
	<?
	if ( file_exists($photoEvenement) ) {
		echo "<img src=\"$photoEvenement\" class=\"affiche img-responsive\" />\n";
	}
	elseif ( file_exists($photoLieu) ) {
		echo "<img src=\"$photoLieu\" class=\"affiche\" style=\"float:left;margin-right:20px;\"/>\n";
	}	
	elseif( file_exists($photoCategorie) ) {
		echo "<img src=\"$photoCategorie\" class=\"affiche\" style=\"float:left;margin-right: 20px;\"/>\n";
	}
	?>
	</div>
	<div class="col-md-8">
	
	<?	
	if ($infos["commentaire"]) {echo "<div class=\"well\">".affiche_texte($infos["commentaire"])."</div>\n" ;}
	
	$selectionnes = $infos['joueurs'] .";" . $infos['mc'] . ";" . $infos['arbitre'] . ";" . $infos['coach']; 
	fxDispJoueurArray(explode(";", $selectionnes), "width:80px;height:60px;");

	?>
	
	</div>
	</div>

	<div class="panel panel-warning">
	<div class="panel-heading text-center">Plus d'informations</div>
	<table class="table">

	<tr><th>Date</th><td><?=affiche_date( $infos["date"] )?> à <?=affiche_heure( $infos["date"] )?></td></tr>
	<tr><th>Lieu</th><td><a href="?p=lieux&id=<?=$infosLieu['id']?>"><?=$infosLieu["nom"]?></a></td></tr>

	<?

	
	if ($resultat_places['total'])
	{
		echo "<tr><th>Places disponibles</th><td>".dispPlaces($places_restantes, $infos[ "places" ])."</td></tr>\n" ;
	}
	
	if ($infos["tarif"])
	{
		echo "<tr><th>Prix de la place</th><td>".$infos["tarif"]."&euro;</td></tr>\n" ;
	}
	
	?>

	</table>
	</div>

	<?
	
	if ($places_restantes > 0)
	{
		$max_places = $places_restantes > 5 ? 5 : $places_restantes ;
	
		?>

		<div class="panel panel-info">
		<div class="panel-heading text-center">Réserver des places</div>
		<form method="post">
		<input type="hidden" name="p" value="reservation">
		<input type="hidden" name="id_spectacle" value="<?=$id_spectacle?>" />
		<input type="hidden" name="action" value="Valider" />

		<table class="table">
		<tr><th>Nombre de places</th><td>
		<?
	
		# Renseignements a fournir
		echo "<select class=\"form-control\" name=\"places\"/>\n" ;
	
		for ( $i = 1 ; $i <= $max_places ; $i++ )
		{
			echo "<option value=\"$i\">$i</option>\n" ;
		}
		echo "</select>\n" ;
		?>
		
		<tr><th>Nom</th><td><input class="form-control" type="text" name="nom" /></td></tr>
		<tr><th>Pr&eacute;nom</th><td><input class="form-control" type="text" name="prenom" /></td></tr>
		<tr><th>E-mail</th><td><input class="form-control" type="text" name="email" /></td></tr>
		<tr><th>Téléphone (facultatif)</th><td><input class="form-control" type="text" name="telephone" /></td></tr>
		<tr class="text-center"><td colspan="2"><button class="btn btn-success btn-lg" type="submit"><i class="glyphicon glyphicon-shopping-cart"></i> Réserver</button></td></tr>
		</table>
		</form>
		</div>
		
		<div class="alert alert-danger">
		Attention les réservations sont valables jusqu'à l'heure de début du spectacle.
		Après cet horaire, les réservations ne seront plus garanties.
		</div>
		<?
	} 
	}
	}
}
else
{
	# On affiche le formulaire pour reserver
	echo "<h1>Réserver des places pour un spectacle</h1>\n" ;

	# Affichage des prochains spectacles
		
	# On recupere la date sous la forme AAAAMMJJhhmmss
	$date_actuelle = date("YmdHis") ;

	$requete_prochains = @mysql_query ( "SELECT * FROM $t_eve e, $t_cat c WHERE c.publique=1 AND e.categorie=c.id AND e.date>$date_actuelle AND e.places>0 ORDER BY date ASC LIMIT 0,9" ) ;

	$nb_prochains = @mysql_num_rows( $requete_prochains ) ;

	if ( $nb_prochains > 0 )
	{
		?>
		<form method="get">
		<input type="hidden" name="p" value="reservation">
		<select class="form-control" name="id_spectacle" onChange="if (this.value!='') this.form.submit();">
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
				echo "<option value=\"$id\">$nom ($date) : ".dispPlaces($places_restantes,$places)."</option>\n" ;
			}
			else
			{
				echo "<option value=\"$id\">$nom ($date) : Complet</option>\n" ;
			}
		}

		?>
		</select>
		<input type="hidden" name="action" value="Choisir" />
		</form>
		<?
	}
	else
	{
		echo "<div class=\"alert alert-warning\">Pas de spectacles avec r&eacute;servations... Merci de revenir plus tard.</div>" ;
	}

}

?>
