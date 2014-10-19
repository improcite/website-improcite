<?php

#====================================================================
# Credits du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

$CURRENT_MENU_ITEM = "infos";
include ( "tete.php" ) ;
$edited_id = $_SESSION['id_impro_membre'];

if(fxUserHasRight("admin"))
{
	$edited_id = getp("id", $edited_id);
}

# Verification de la disponibilite de MySQL

if ( ! $connexion || ! $db ) {

	# La connexion a MySQL a echoue, affichage d'un message d'erreur comprehensible

	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;

}

else {

	

	# MySQL est disponible, on continue !

	# Ouverture du corps de la page

	echo "<div id=\"corps\">\n" ;

	$action = getp("action"); 

	//--------------------------
	if ($action == "Modifier")
	{
		$password = getp("password");
		$prenom = getp("prenom");
		$nom = getp("nom");
		$afficherNom = getp("affichernom");
		$surnom = getp("surnom");
		$jour = getp("jour");
		$mois = getp("mois");
		$annee = getp("annee");
		$email = getp("email");
		$portable = getp("portable");
		$adresse = getp("adresse");
		$apport = getp("apport");
		$envie = getp("envie");
		$debut = getp("debut");
		$debutimprocite = getp("debutimprocite");
		$improcite = getp("improcite");
		$qualite = getp("qualite");
		$defaut = getp("defaut");

		// MAJ de la fiche
		$maj_fiche = @mysql_query("UPDATE $table_comediens SET
			password='$password',
			prenom='$prenom',
			nom='$nom',
			affichernom='$afficherNom',
			surnom='$surnom',
			jour='$jour',
			mois='$mois',
			annee='$annee',
			email='$email',
			portable='$portable',
			adresse='$adresse',
			apport='$apport',
			envie='$envie',
			debut='$debut',
			debutimprocite='$debutimprocite',
			improcite='$improcite',
			qualite='$qualite',
			defaut='$defaut'
			WHERE id=$edited_id");

		// Fin
		
		?><div class="alert alert-success">Modification effectu&eacute;e</div><?
	}
	
	//--------------------------
	if ($action == "UploadFile")
	{
		
		$extension = end(explode('.', $_FILES['uploaded_file']['name']));
		if(strtolower($extension) != "jpg")
		{
			?><div class="alert alert-danger">Erreur seul les fichiers '.jpg' sont autorisés.</div><?
		}
		else
		{
			$target_dir = dirname(__FILE__)."/../photos/comediens/1024/";
			@mkdir($target_dir);
			$target_path = $target_dir . $edited_id."_original.jpg";
			$target_path_final = $target_dir . $edited_id.".jpg";
			$source_path = $_FILES["uploaded_file"]["tmp_name"];
			
			if (!move_uploaded_file($source_path, $target_path))
			{
				echo "Error with your file.";
				?><div class="alert alert-danger">Erreur de mise à jour.</div><?
			}
			else
			{
				image_resize_crop($target_path, $target_path_final, 400, 300, 1);
				?><div class="alert alert-success">Image modifiée.</div><?
			}
		}
		$actionOk = true;
	}
	
	//--------------------------
	?><h1>Modifier mes informations</h1><?

	$requete_membres = @mysql_query ( "SELECT * FROM $table_comediens WHERE id=$edited_id" ) ;
	$resultat = @mysql_fetch_array ( $requete_membres );
	
	$login = $resultat[ "login" ];
	$password = $resultat[ "password" ];
	$prenom = $resultat[ "prenom" ];
	$nom = $resultat[ "nom" ];
	$afficherNom = $resultat[ "affichernom" ];
	$surnom = $resultat[ "surnom" ];
	$jour = $resultat[ "jour" ];
	$mois = $resultat[ "mois" ];
	$annee = $resultat[ "annee" ];
	$email = $resultat[ "email" ];
	$portable = $resultat[ "portable" ];
	$adresse = $resultat[ "adresse" ];
	$debut = $resultat[ "debut" ];
	$debutimprocite = $resultat[ "debutimprocite" ];
	$envie = $resultat[ "envie" ];
	$apport = $resultat[ "apport" ];
	$improcite = $resultat[ "improcite" ];
	$qualite = $resultat[ "qualite" ];
	$defaut = $resultat[ "defaut" ];

	?>
	
	<div class="panel panel-default"><div class="panel-heading">Image de l'année</div><div class="panel-body">
	<table><tr><td>
	<img src="<?=(get_photo_uri($edited_id)."?nocache=".rand())?>" style="width:150px;"/>
	</td><td>
	<div style="margin-left:30px;">
	<form action="?" method="post" enctype="multipart/form-data">
	  <input type="file" name="uploaded_file"><br>
	  <input type="hidden" name="action" value="UploadFile">
	  <input type="hidden" name="id" value="<?=$edited_id?>">
	  <input type="submit" class="btn btn-primary" value="Modifier l'image" />
	</form>
	</div>
	</td></tr></table>
	</div></div>		
	
	<div class="panel panel-default"><div class="panel-heading">Informations personnelles</div><div class="panel-body">
	<form method="post" role="form">
	<h2>Acc&egrave;s &agrave; l'espace membres</h2>
	<?
	echo "<p><span class=\"intitules\">Identifiant (non modifiable)&nbsp;:</span> $login</p>\n";
	echo "<p><span class=\"intitules\">Mot de passe&nbsp;:</span> <input type=\"password\" name=\"password\" value=\"$password\" /></p>\n";

	echo "<h2>Identit&eacute;</h2>\n";
	
	echo "<p><span class=\"intitules\">Pr&eacute;nom&nbsp;*&nbsp;:</span> <input type=\"text\" name=\"prenom\" value=\"$prenom\" /></p>\n";
	echo "<p><span class=\"intitules\">Nom&nbsp;:</span> <input type=\"text\" name=\"nom\" value=\"$nom\" />\n";
	echo "   <input type=\"checkbox\" name=\"afficherNom\" value=\"1\" ".($afficherNom?"CHECKED":"")." /> Nom affiché sur le site</p>\n";
	
	echo "<p><span class=\"intitules\">Surnom&nbsp;*&nbsp;:</span> <input type=\"text\" name=\"surnom\" value=\"$surnom\" /></p>\n";
	echo "<p><span class=\"intitules\">Date de naissance&nbsp;*&nbsp;:</span> ";
	echo "<input type=\"text\" name=\"jour\" value=\"$jour\" size=\"2\"/>";
	echo "<input type=\"text\" name=\"mois\" value=\"$mois\" size=\"2\"/>";
	echo "<input type=\"text\" name=\"annee\" value=\"$annee\" size=\"4\"/>";
	echo "</p>\n";
	echo "<p>* affiché sur le site</p>";

	echo "<h2>Informations priv&eacute;es</h2>\n";
	echo "<p><span class=\"intitules\">Email&nbsp;:</span> <input type=\"text\" name=\"email\" value=\"$email\" /></p>\n";
	echo "<p><span class=\"intitules\">Portable&nbsp;:</span> <input type=\"text\" name=\"portable\" value=\"$portable\" /></p>\n";
	echo "<p><span class=\"intitules\">Adresse&nbsp;:</span><br />\n";
	echo "<textarea name=\"adresse\" cols=\"80\">$adresse</textarea></p>\n";


	echo "<h2>Ta fiche sur le site</h2>\n";
	echo "<p><span class=\"intitules\">D&eacute;but dans l'improvisation&nbsp;:</span><br />\n";
	echo "<textarea name=\"debut\" cols=\"80\">$debut</textarea></p>\n";
	echo "<p><span class=\"intitules\">Ton arrivée à Improcité :</span><br />\n";
	echo "<textarea name=\"debutimprocite\" cols=\"80\">$debutimprocite</textarea></p>\n";
	echo "<p><span class=\"intitules\">Comment as-tu eu envie d'en faire&nbsp;:</span><br />\n";
	echo "<textarea name=\"envie\" cols=\"80\">$envie</textarea></p>\n";
	echo "<p><span class=\"intitules\">Que t'apporte l'improvisation&nbsp;:</span><br />\n";
	echo "<textarea name=\"apport\" cols=\"80\">$apport</textarea></p>\n";
	echo "<p><span class=\"intitules\">Quelques mots sur Improcit&eacute;&nbsp;:</span><br />\n";
	echo "<textarea name=\"improcite\" cols=\"80\">$improcite</textarea></p>\n";
	echo "<p><span class=\"intitules\">Qualit&eacute;&nbsp;:</span><br />\n";
	echo "<textarea name=\"qualite\" cols=\"80\">$qualite</textarea></p>\n";
	echo "<p><span class=\"intitules\">D&eacute;faut&nbsp;:</span><br />\n";
	echo "<textarea name=\"defaut\" cols=\"80\">$defaut</textarea></p>\n";

	?>

	<input type="hidden" name="id" value="<?=$edited_id?>">
	<input type="hidden" name="action" value="Modifier">
	<p><input type="submit" class="btn btn-primary" value="Modifier le profil" /></p>
	</div></div>
	</form>
	<?

	# Fermeture du corps de la page
	echo "</div>\n" ;
}

# Affichage du pied de page

@include ( "pied.php" ) ;

?>
