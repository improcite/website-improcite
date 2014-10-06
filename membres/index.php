<?php

#====================================================================
# Page presentant les evenements d'Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

include ( "tete.php" ) ;
$idMe = $_SESSION['id_impro_membre'];

?>
<div class="row">
	<div class="col-md-6">
	<h1>Calendrier</h1>
		<div class="table-responsive">
<?php

$annee = date("Y");
$date_debut_saison = date("YmdHis", mktime(0, 0, 0, 8, 1, 2004+$iCurrentSaisonNumber)) ;
$date_actuelle = date("YmdHis") ;
$sSQL = "SELECT e.id as id, l.nom as lnom, c.nom as nom, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.categorie as categorie, e.regisseur as regisseur, e.caisse as caisse, e.catering as catering"
		." FROM $t_eve e, $t_cat c, $t_lieu l "
		." WHERE e.categorie=c.id AND e.date>$date_debut_saison AND e.lieu=l.id"
		." ORDER BY date ASC";
$requete_prochains = fxQuery($sSQL) ;

$aAllEvents = array();

$aAllSpecatclesId = array();
$aEntriesRow = array();
$aEntriesName = array();
$aEntriesId = array();
$aEntriesCate = array();
$aEntriesDesc = array();
while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
{
	$aAllEvents[] = $aRow;
	$year = substr($aRow['date'],0,4);
	$month = substr($aRow['date'],4,2);
	$day = substr($aRow['date'],6,2);
	$aEntriesRow[$year.$month.$day] = $aRow;
	$aEntriesName[$year.$month.$day] = "{$aRow["nom"]}-{$aRow["lnom"]}";
	$aEntriesId[$year.$month.$day] = $aRow['id'];
	$aEntriesCate[$year.$month.$day] = $aRow['categorie'];
	$aEntriesDesc[$year.$month.$day] = $aRow['ecommentaire'];
	$aAllSpecatclesId[] = $aRow['id'];
}

$aDispoForAllSpectacles = array();
if (sizeof($aAllSpecatclesId) > 0)
{
	$aDispoForAllSpectacles = fxQueryIndexed("SELECT id_spectacle, dispo_pourcent FROM impro_dispo WHERE id_spectacle IN (".implode(",", $aAllSpecatclesId).") AND id_personne = $idMe");
}

	echo "<br/><table border=0 cellspacing=0 cellpadding=0 width=100%><tr>";

	echo "<td valign=top><table border=0 cellspacing=0 cellpadding=0 width=100%><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>";
	for($i=1;$i<=31;$i++) echo "<tr><td style=\"border-bottom:1px dotted #888;border-left:1px solid #888;\">$i</td><td style=\"border-bottom:1px dotted #888;\"><img border=0 src=img/empty.gif></td></tr>";
	echo "</table></td>";

	for($mois=date("n");$mois<date("n")+10;$mois++)
	{
		$firstMois = mktime(0,0,0,$mois,1,$annee);
		$joursDansMois = date("t", $firstMois);	
		$lastMois = mktime(0,0,0,$mois,$joursDansMois,$annee);
		$jourSemaine1erJourDuMois = date("w", mktime(0,0,0,$mois,1,$annee));
		$moisReel = date("n", mktime(0,0,0,$mois,1,$annee));
		$moisReelTxt = date("M", mktime(0,0,0,$mois,1,$annee));
		
		$anReel = date("Y", mktime(0,0,0,$mois,1,$annee));
		
		echo "<td valign='top'><table border=0 cellspacing=0 cellpadding=0 width=100%>";
		echo "<tr><td style=\"background-color:#888;\" align=center>&nbsp;{$anReel}&nbsp;</td></tr>";
		echo "<tr><td style=\"background-color:#888;\" align=center>&nbsp;{$moisReelTxt}&nbsp;</td></tr>";
		
		$span1Jour = 3600*24;
		for($dateSeconds=$firstMois;$dateSeconds<$lastMois;$dateSeconds +=$span1Jour)
		{
			$iJourEnJours = ($dateSeconds-$firstMois)/$span1Jour + 1;
			$sJour = strlen($iJourEnJours) == 1 ? "0".$iJourEnJours : $iJourEnJours;
			$sMoisReel = strlen($moisReel) == 1 ? "0".$moisReel : $moisReel;
			$sDateEntry = $anReel.$sMoisReel.$sJour;
			$weekend = date("w", $dateSeconds) == 0  ||  date("w", $dateSeconds) == 6;
			
			if (time() > $dateSeconds  &&  time() < $dateSeconds+$span1Jour)
			{
				$bgColor = "#88f";
			}
			else
			{
				$bgColor = ($dateSeconds<time()) ? "#aaa" : ($weekend ? "#eec" : ((($iJourEnJours + $mois) % 2) ? "#fff" : "#eee"));
			}
			
			if (isset($aEntriesName[$sDateEntry]))
			{
				$icon = "calendar.gif";
				if ($aEntriesCate[$sDateEntry] == $category_train)
				{
					$icon = "calendar_train.gif";
				}
				
				$row = $aEntriesRow[$sDateEntry];
				$tooltip = $row["nom"]."<br/>".$row["lnom"]."<br/>".htmlentities($aEntriesDesc[$sDateEntry]);
				$txt = '<a href="dispos.php?month='.$moisReel.'&year='.$anReel.'" data-html="true" data-toggle="tooltip" title="'.$tooltip.'"><img border="0" src="img/'.$icon.'"></a>';
				
				$sName = "";
				
				if ($sName)
				{
					$txt .= "<img border=0 src=img/star.gif>";
				}
				if (isset($aDispoForAllSpectacles[$aEntriesId[$sDateEntry]]))
				{
					$dispo = ($aDispoForAllSpectacles[$aEntriesId[$sDateEntry]] == 100);
					
					// entrainement : pas répondu = ok
					if ($dispo) $txt .= "<img border=0 src=img/yes.gif>";
					if (!$dispo) $txt .= "<img border=0 src=img/no.gif>";
				}
				else
				{
					if ($aEntriesCate[$sDateEntry] == $category_train)
					{
						$txt .= "<img border=0 src=img/yes.gif>";
					}
					else
					{
						$txt .= "<img border=0 src=img/unk.gif>";
						$bgColor = '#F88';
					}
				}
			}
			else
			{
				$txt = "<img src=img/empty.gif>";
			}
			echo "<tr><td align=center style=\"border-bottom:1px dotted #888;border-left:1px solid #888;background-color:{$bgColor}\" >$txt</td></tr>\n";
		}
		echo "</table>";

		echo "</td>";
	}
	echo "</tr></table>\n";

	?>
		</div>
	</div>
	<div class="col-md-6">
	<h1>Sélections</h1>
<?

$iCountSelect = 0;
$date_actuelle = date("YmdHis") ;
$date_max = date("YmdHis", time()+3600*24*31*3) ;// trois mois

foreach($aAllEvents as $aRow)
{
	if ($aRow['unixdate'] < time()) continue;
	if ($aRow['unixdate'] > time()+3600*24*31*4) continue;// 4 mois

	$sName = "";
	if ($idMe == $aRow['mc']) $sName = "MC";
	if ($idMe == $aRow['coach']) $sName = "Coach";
	if ($idMe == $aRow['arbitre']) $sName = "Arbitre";
	if ($idMe == $aRow['regisseur']) $sName = "Régisseur";
	if ($idMe == $aRow['caisse']) $sName = "Caisse";
	if ($idMe == $aRow['catering']) $sName = "Catering";
	if (strstr(";".$aRow['joueurs'].";", ";".$idMe.";")) $sName = "Joueur";
	$date = affiche_date($aRow["date"]);
	$mois = extract_month($aRow["date"]);
	$annee = extract_year($aRow["date"]);

	$iPct = isset($aDispoForAllSpectacles[$aRow["id"]]) ? $aDispoForAllSpectacles[$aRow["id"]] : "";
		
	if ($aRow['categorie'] == $category_train  &&  $iPct != "0")
	{
		// skip entrainements non répondu / répondu oui
		continue;
	}

	$tooltip = $aRow["nom"]."<br/>".$aRow["lnom"]."<br/>".htmlentities($aRow['ecommentaire']);
	$link = '<a href="dispos.php?month='.$mois.'&year='.$annee.'" data-html="true" data-toggle="tooltip" title="'.$tooltip.'"><img src="img/calendar.gif"></a> ';

	if($sName)
	{
		echo $link."<img src=img/star.gif> - <u>{$sName}</u> - {$date}-{$aRow["nom"]}-{$aRow["lnom"]} <br/>";
		$iCountSelect++;
	}
	else if ($sName==""  &&  $iPct == "")
	{
		echo $link."<img src=img/unk.gif> - <b><a href=dispos.php?month=".$mois."&year=".$annee.">Veuillez répondre !</a></b> - {$date}-{$aRow["nom"]}-{$aRow["lnom"]}<br/>";
	}
	else if ($sName==""  &&  $iPct == "0")
	{
		echo $link."<img src=img/no.gif> - <u>Non dispo</u> - {$date}-{$aRow["nom"]}-{$aRow["lnom"]}<br/>";
	}
	else if ($sName==""  &&  $iPct == "100")
	{
		echo $link."<img src=img/yes.gif> - <u>Dispo</u> - {$date}-{$aRow["nom"]}-{$aRow["lnom"]}<br/>";
	}
	if($aRow['ecommentaire'])
	{
		?><div style="margin-left:60px;margin-bottom:0px;font-style: italic;"><?=$aRow['ecommentaire']?></div><?
	}
	?><div style="height:5px;"></div><?
}

flush();

//-----------------------
?>
	</div>
</div>

<hr />
<div align="right" style="color:#aaa"> <?php
foreach(fxGetExistingRights() as $sRightId=>$sRightLib)
{
	echo "<input type=checkbox DISABLED ".(fxUserHasRight($sRightId) ? "CHECKED" : "")."> ".$sRightLib."&nbsp;&nbsp;&nbsp;&nbsp;";
}
?><div>
<?php @include ( "pied.php" ) ; ?>
