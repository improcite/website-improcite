<?php

#====================================================================
# Page presentant les evenements d'Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page
include ( "tete.php" ) ;
$idMe = $_SESSION['id_impro_membre'];

$annee = date("Y");
$date_debut_saison = date("YmdHis", mktime(0, 0, 0, 8, 1, 2004+$iCurrentSaisonNumber)) ;
$date_actuelle = date("YmdHis") ;
$requete_prochains = getNextEventsQuery($mysqli, $t_eve, $t_cat, $t_lieu, $date_debut_saison);

$aAllEvents = array();
$aAllSpecatclesId = array();
$aEntriesRow = array();
$aEntriesName = array();
$aEntriesId = array();
$aEntriesCate = array();
$aEntriesDesc = array();
$aDispoForAllSpectacles = array();
while ($aRow = $requete_prochains->fetch_assoc()) {
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

if (sizeof($aAllSpecatclesId) > 0) {
    $aDispoForAllSpectacles = fxQueryIndexed("SELECT id_spectacle, dispo_pourcent FROM impro_dispo WHERE id_spectacle IN (".implode(",", $aAllSpecatclesId).") AND id_personne = $idMe");
}

?>
<div class="row">
	<div class="col-md-6">
	
	<h1>Sélections</h1>
<?

$date_actuelle = date("YmdHis") ;
$date_max = date("YmdHis", time()+3600*24*31*3) ;// trois mois

echo "<table class=\"table table-striped\">";
echo "<tr><th></th><th></th>";
echo "<th>Statut</th>";
echo "<th>Date</th>";
echo "<th>Type</th>";
echo "</tr>";

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
	if ($idMe == $aRow['ovs']) $sName = "OVS";
	if (strstr(";".$aRow['joueurs'].";", ";".$idMe.";")) $sName = "Joueur";
	$date = affiche_date($aRow["date"]);

	$iPct = isset($aDispoForAllSpectacles[$aRow["id"]]) ? $aDispoForAllSpectacles[$aRow["id"]] : "";

	$tooltip = $aRow["nom"]."<br/>".$aRow["lnom"]."<br/>".htmlentities($aRow['ecommentaire']);
	$link = '<a href="dispos2.php?event='.$aRow["id"].'" data-html="true" data-toggle="tooltip" title="'.$tooltip.'"><img src="img/calendar.gif"></a> ';

        echo "<tr>";
	echo "<td>$link</td>";
	if($sName)
	{
		echo "<td><img src=\"img/star.gif\"></td><td>{$sName}</td>";
	}
	else if ($sName==""  &&  $iPct == "")
	{
		echo "<td><img src=\"img/unk.gif\"></td><td><a href=\"dispos2.php?event=".$aRow["id"]."\">Veuillez répondre !</a></td>";
	}
	else if ($sName==""  &&  $iPct == "0")
	{
		echo "<td><img src=\"img/no.gif\"></td><td>Non disponible</td>";
	}
	else if ($sName==""  &&  $iPct == "100")
	{
		echo "<td><img src=\"img/yes.gif\"></td><td>Disponible</td>";
	}
	echo "<td>$date</td>";
	echo "<td>".$aRow["nom"]."</td>";
	echo "</tr>";
}
echo "</table>";
?>


	</div>

	<div class="col-md-6">
	
	<h1>Calendrier</h1>
		<div class="table-responsive">
<?php

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
				$train = "";
				if ($aEntriesCate[$sDateEntry] == $category_train)
				{
					$icon = "calendar_train.gif";
					$train = "&train=1";
				}
				
				
				$row = $aEntriesRow[$sDateEntry];
				$tooltip = $row["nom"]."<br/>".$row["lnom"]."<br/>".htmlentities(cutIfWider($aEntriesDesc[$sDateEntry], 100));
				$txt = '<a href="dispos2.php?event='.$row["id"].$train.'" data-html="true" data-toggle="tooltip" title="'.$tooltip.'"><img border="0" src="img/'.$icon.'">';
				
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
				
				echo "</a>\n";
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
	</div>

<hr />
<div align="right" style="color:#aaa"> <?php
foreach(fxGetExistingRights() as $sRightId=>$sRightLib)
{
	echo "<input type=checkbox DISABLED ".(fxUserHasRight($sRightId) ? "CHECKED" : "")."> ".$sRightLib."&nbsp;&nbsp;&nbsp;&nbsp;";
}
?><div>
<?php @include ( "pied.php" ) ; ?>
