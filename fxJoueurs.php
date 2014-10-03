<?php

function fxDispJoueurArray($aJoueurs, $sStyle = "")
{
	global $table_comediens, $sPhotoRelDir;
	$iPct = round(100 / sizeof($aJoueurs));
	
	echo '<ul class="comediens comediens-small">';
	//echo '<table border="0"><tr>';
	$iCnt = 0;
	foreach($aJoueurs as $id)
	{
		if (empty($id)) {continue;}
		//if (++$iCnt == round(sizeof($aJoueurs)/2)) echo "</tr><tr>";
		
		# Infos sur le comedien
		$requete_joueur = fxQuery("SELECT id,prenom,nom,surnom,affichernom FROM $table_comediens WHERE id=?", $id);
		$id = @mysql_result($requete_joueur, 0, "id");
		$nom = @mysql_result($requete_joueur, 0, "nom");
		$prenom = @mysql_result($requete_joueur, 0, "prenom");
		$surnom = @mysql_result($requete_joueur, 0, "surnom");
		$afficherNom = @mysql_result($requete_joueur, 0, "affichernom");
		$sNomPrenom = $prenom.(($afficherNom)?" $nom":"");	// en fonction du désir de la personne, on l'affiche pas son nom
	
		$photo = "$sPhotoRelDir$id.jpg";
		if (!file_exists($photo)) { $photo = $sPhotoRelDir."defaut.jpg"; }
		
		
		echo "<li><a href=\"?p=comediens&id=$id#apage\" title=\"$sNomPrenom\">\n" ;
		echo "<img class=\"photo_comedien\" src=\"$photo\" alt=\"Photo de $sNomPrenom\" />\n";
		echo "</a></li>\n" ;
		
		/*
		echo "<td align=\"center\">" ;
		
		echo "<span style=\"display:block;position: relative;\">";
		echo "<a href=\"/index.php?p=comediens&id=$id\">";
		echo "<img class=\"photo_comedien2\" style=\"$sStyle\" src=\"$photo\" alt=\"$sNomPrenom\" title=\"$sNomPrenom";
		if ($surnom) { echo " ($surnom)"; }
		echo "\"/>";
		echo "</a>";
		if (strlen($prenom)>9) $prenom = substr($prenom,0,9).".";
		echo "$prenom";
		
		echo "<span style=\"z-index:100;position: absolute; top: 50px; left: 2px;color:black;\"><b><small>$prenom</small></b></span>";
		echo "<span style=\"z-index:110;position: absolute; top: 51px; left: 3px;color:white;\"><b><small>$prenom</small></b></span></span>";
		echo "</span></td>" ;
		*/
		
		
		
		//echo "<small><nobr><img  class=\"photo_comedien2\" style=\"$sStyle\" src=\"$photo\" alt=\"$sNomPrenom\" title=\"$sNomPrenom";
		//if ($prenom != $surnom) { echo " ($surnom)"; }
		//echo "\"/> $prenom</small></nobr></td>" ;
	}
	echo '</ul>';
	//echo '</tr></table>';
}

?>
