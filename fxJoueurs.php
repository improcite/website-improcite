<?php

function fxDispJoueurArray($aJoueurs, $sStyle = "")
{
	global $table_comediens, $sPhotoRelDir, $currentSaisonBit;
	
	echo '<div class="row">';
	$iCnt = 0;
	foreach($aJoueurs as $id)
	{
		if (empty($id)) {continue;}
		
		# Infos sur le comedien
		$requete_joueur = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $id);
		$id = @mysql_result($requete_joueur, 0, "id");
		$nom = @mysql_result($requete_joueur, 0, "nom");
		$prenom = @mysql_result($requete_joueur, 0, "prenom");
		$surnom = @mysql_result($requete_joueur, 0, "surnom");
		$afficherNom = @mysql_result($requete_joueur, 0, "affichernom");
		$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");	// en fonction du désir de la personne, on l'affiche pas son nom
	
		$photo = $sPhotoRelDir . $currentSaisonBit . "/" ."$id.jpg";
		if (!file_exists($photo)) { $photo = $sPhotoRelDir."$id.jpg"; }
		if (!file_exists($photo)) { $photo = $sPhotoRelDir."defaut.jpg"; }
		echo "<div class=\"col-xs-6 col-sm-4 col-md-3 text-center\" style=\"margin-top:5px;\">\n";
		echo "<a href=\"?p=comediens&id=$id#apage\" title=\"$sNomPrenom\">\n" ;
		echo "<img class=\"img-responsive img-circle\" src=\"$photo\" alt=\"Photo de $sNomPrenom\" />\n";
		echo "<strong>$prenom</strong>\n";
		echo "</a>\n" ;
		echo "</div>\n" ;
		
	}
	echo '</div>';
}

?>
