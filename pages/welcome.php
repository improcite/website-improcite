<h1>Nos prochains spectacles</h1>

<?php

include(dirname(__FILE__)."/../fxJoueurs.php");

$oRqLastNews = mysql_query("SELECT * FROM impro_news WHERE active = 1 ORDER BY date desc");

		while ($aRowNews = @mysql_fetch_array($oRqLastNews))
		{
			?><div class="nouvelle">
			<?
			echo affiche_texte($aRowNews['texte']);
			?></div><?
		}
		
		$iCount = 0;
		$date_actuelle = date("YmdHis") ;
		$requete_prochains = fxQuery( 	"SELECT e.id as eid, c.id as cid, l.id as lid, e.commentaire as ecommentaire,"
									.	"c.description as cdescription, l.nom as lnom, c.nom as nom, e.date as date, e.joueurs as joueurs, e.animateurs as animateurs, e.mc as mc,"
									.	"e.arbitre as arbitre, e.coach as coach , e.places as places FROM $t_eve e, $t_cat c, $t_lieu l WHERE "
									.	"c.publique=1 AND e.categorie=c.id AND e.date>$date_actuelle AND e.lieu=l.id ORDER BY date ASC LIMIT 0,$nb_spectacles_welcome" );
		while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
		{
			$iCount++;
			$date = affiche_date($aRow["date"]);
			$heure = affiche_heure($aRow["date"]);
			?>
			<div class="row">
				<div class="col-md-4">
				<? // Affiche la photo de l'evenement ou de la categorie

					$photoEvenement = $sPhotoEvenement.$aRow["eid"].".jpg";
					$photoLieu = $sPhotoLieuRelDir.$aRow["lid"].".jpg";
					$photoCategorie = $sPhotoCategorie.$aRow["cid"].".jpg";
					echo "<a href=\"?p=reservation&id_spectacle=".$aRow["eid"]."\">\n";
					if ( file_exists($photoEvenement) ) {
						echo "<img src=\"$photoEvenement\" alt=\"$aRow[nom]\" class=\"img-responsive hvr-rotate\"/>\n";
					}
					elseif ( file_exists($photoLieu) ) {
						echo "<img src=\"$photoLieu\" alt=\"$aRow[nom]\" class=\"img-responsive hvr-rotate\"/>\n";
					}					
					elseif ( file_exists($photoCategorie) ) {
						echo "<img src=\"$photoCategorie\" alt=\"$aRow[nom]\" class=\"img-responsive hvr-rotate\"/>\n";
					}
					echo "</a>\n";
				?>
				</div>
				<div class="col-md-8">
					<div class="lieuspectacle"><a href="?p=lieux&id=<?=$aRow["lid"]?>#apage"><?=$aRow["lnom"]?></a></div>
					<div class="datespectacle"><?=$date?> - <?=$heure?></div>
					<div class="titrespectacle"><a href="?p=agenda#apage" title="<?=$aRow["cdescription"]?>"><?=$aRow["nom"]?></a></div>
					
					<? if ($aRow["ecommentaire"])
					{
						echo "<div class=\"well\">";
						echo affiche_texte($aRow['ecommentaire']);
						echo "</div>";
					}
					elseif ($aRow["cdescription"])
					{
						echo "<div class=\"well\">";
						echo affiche_texte($aRow['cdescription']);
						echo "</div>";
					}
					?>					
					
					<? if ($aRow["places"]) { ?>
					<div class="text-center" style="margin-bottom:20px;">
						<button type="button" class="btn btn-lg btn-default" onclick="location='?p=reservation&id_spectacle=<?=$aRow["eid"]?>#apage'">
						<i class="glyphicon glyphicon-shopping-cart"></i> Réserver une place
						</button>
					</div>
					<? }?>
					<div class="row">
					<?php
					$selectionnes = $aRow['joueurs'] .";" . $aRow["animateurs"] . ";" . $aRow['mc'] . ";" . $aRow['arbitre'] . ";" . $aRow['coach'];
					fxDispJoueurArray(explode(";", $selectionnes), "width:100px;");
					?>
					</div>
				</div>
			</div>
			<hr />
			
		<? } ?>
		
		<? if ($iCount == 0) { ?>
			<div class="alert alert-info">Nos prochaines dates seront bientôt disponibles</div>
		<? } ?>

