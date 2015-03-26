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
		
		$bFirst = true;
		$iCount = 0;
		$date_actuelle = date("YmdHis") ;
		$requete_prochains = fxQuery( 	"SELECT e.id as eid, c.id as cid, l.id as lid, e.commentaire as ecommentaire,"
									.	"c.description as cdescription, l.nom as lnom, c.nom as nom, e.date as date, e.joueurs as joueurs, e.mc as mc,"
									.	"e.arbitre as arbitre, e.coach as coach , e.places as places FROM $t_eve e, $t_cat c, $t_lieu l WHERE "
									.	"c.publique=1 AND e.categorie=c.id AND e.date>$date_actuelle AND e.lieu=l.id ORDER BY date ASC LIMIT 0,$nb_spectacles_welcome" );
		while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
		{
			$iCount++;
			$date = affiche_date($aRow["date"]);
			if ($bFirst)
			{
				$bFirst = false;
				?><!--<h1>Prochain spectacle</h1>-->
				<br>
				<?
				
			}
			?>
			<div class="spectacle">
				<div class="affiche">
				<? // Affiche la photo de l'evenement ou de la categorie

					$photoEvenement = $sPhotoEvenement.$aRow["eid"].".jpg";
					$photoLieu = $sPhotoLieuRelDir.$aRow["lid"].".jpg";
					$photoCategorie = $sPhotoCategorie.$aRow["cid"].".jpg";
					if ( file_exists($photoEvenement) ) {
						echo "<img src=\"$photoEvenement\" alt=\"$aRow[nom]\" class=\"affiche\"/>\n";
					}
					elseif ( file_exists($photoLieu) ) {
						echo "<img src=\"$photoLieu\" alt=\"$aRow[nom]\" class=\"affiche\"/>\n";
					}					
					elseif ( file_exists($photoCategorie) ) {
						echo "<img src=\"$photoCategorie\" alt=\"$aRow[nom]\" class=\"affiche\"/>\n";
					}
				?>
				</div>
				<div class="description">
					<div class="lieuspectacle"><a href="?p=lieux&id=<?=$aRow["lid"]?>"><?=$aRow["lnom"]?></a></div>
					<div class="datespectacle"><?=$date?></div>
					<div class="titrespectacle"><a href="?p=agenda" title="<?=$aRow["cdescription"]?>"><?=$aRow["nom"]?></a></div>
					
					<? if ($aRow["ecommentaire"])
					{
						//echo "<div style=\"padding:2px;\">";
						echo affiche_texte($aRow['ecommentaire']);
						//echo "</div>";
					}
					elseif ($aRow["cdescription"])
					{
						//echo "<div style=\"padding:2px;\">";
						echo affiche_texte($aRow['cdescription']);
						//echo "</div>";
					}
					?>					
					
					<div style="display:block">
					<?php
					$selectionnes = $aRow['joueurs'] .";" . $aRow['mc'] . ";" . $aRow['arbitre'] . ";" . $aRow['coach']; 
					fxDispJoueurArray(explode(";", $selectionnes), "width:100px;");
					?>
					</div>
					<? if ($aRow["places"]) { ?>
						<br/><br/>
						<input type="button" style="float:right" value="Cliquer ici pour réserver votre place" onclick="location='?p=reservation&id_spectacle=<?=$aRow["eid"]?>'">
					<? }?>
					<br/>
					<hr/>
				</div>
			</div>
			
		<? } ?>
		
		<? if ($iCount == 0) { ?>
		<!--
		        <p>Nous jouons au bar <a href="?p=lieux&id=4">Le Trokson</a> chaque dernier mercredi du mois !</p>
			<p>A bientôt !</p>
		-->
		<? } ?>
		

		
		
		<h1>Inscrivez-vous à la newsletter</h1>
		<? afficher_inscription_newsletter(); ?>
		<br />
		</td>
	
	</td>

