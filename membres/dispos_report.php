<?php

include ( "tete.php" ) ;

$g_NbJoursMaxiAvantRappelDemandeDispo = 20;

$bDoSendMail = getp("sendmail");

# Verification de la disponibilite de MySQL
if ( ! $connexion || ! $db )
{
	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
	die();
}

echo "<div id=\"corps\">\n" ;
echo "<h1>Disponibilités: Rapport</h1>\n" ;

echo "<h1>(en cours...)</h1>\n" ;

//echo "<table border=1 cellspacing=0 cellpadding=2>";
//echo "<tr bgcolor=#AAAAAA>";
//echo "<td>Quand</td><td>Quoi</td><td>Ou</td>";

$saison = 1 << $iCurrentSaisonNumber;
$filtresql = "saison & ".($saison)." <> 0";
$requete_membres = mysql_query ( "SELECT * FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;
//while ($aRowJ = mysql_fetch_array($requete_membres, MYSQL_ASSOC))
//{
//	echo "<td>".$aRowJ['prenom']."</td>";
//}
//echo "</tr>";


$aMails = array();

$iCount = 0;
$date_actuelle = date("YmdHis") ;
$sSQL = "SELECT e.id as id, l.nom as lnom, c.nom as nom, e.date as date, e.joueurs as joueurs FROM $t_eve e, $t_cat c, $t_lieu l WHERE e.categorie=c.id AND e.date>$date_actuelle AND e.lieu=l.id ORDER BY date ASC";
$requete_prochains = fxQuery($sSQL) ;
while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
{
	$iCount++;
	$date = affiche_date($aRow["date"]);
	$jDiff = round((dateToUnix($aRow["date"])-time())/3600/24);
	$iDispoEnteredOk = 0;
	$iDispoEnteredNo = 0;
	$iDispoMiss = 0;
	if ($jDiff > 0)
	{
		echo "<u>{$date} - {$aRow["nom"]} - {$aRow["lnom"]} - {$jDiff} jours.</u><br>";
		$requete_membres = fxQuery( "SELECT * FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;
		while ($aRowJ = fxFetch($requete_membres))
		{
			list($iDispo,$sComment) = fxQueryMultiValues("SELECT dispo_pourcent, commentaire FROM impro_dispo WHERE id_spectacle = ? AND id_personne = ?", array($aRow['id'], $aRowJ['id']));
			$bSelection = strstr(";".$aRow['joueurs'].";", $aRowJ['id']);
			if ($iDispo == "100") $iDispoEnteredOk++;
			if ($iDispo == "0") $iDispoEnteredNo++;
			if ($iDispo == "") $iDispoMiss++;
			
			if ($jDiff < $g_NbJoursMaxiAvantRappelDemandeDispo)
			{
				if ($iDispo == "")
				{
					$aMails[] = array(
									$aRowJ["email"],
									"[Impro] Dispos pour le {$date} ({$aRow["nom"]})",
									"Salut {$aRowJ['prenom']}, il nous faudait tes dispos pour le {$date}, {$aRow['nom']}, {$aRow['lnom']}\n\n"
										."Tu pourrais regarder steplait ?\n"
										."http://improcite.free.fr/membres/identification.php - rubrique \"Disponibilités\"\n"
										."\n"
										."A bientôt !"
									);
				}
			}
		}
		echo "&nbsp;&nbsp;&nbsp;&nbsp;{$iDispoEnteredOk} dispos, {$iDispoEnteredNo} non dispos, {$iDispoMiss} manquants.";
	}
	echo "<br>";
}

if ($bDoSendMail)
{
	//$sMailFromName = "Mathieu Frémont";
	//$sMailFromEmail = "mfremont@edengames.com";
	$sMailFromName = "Site Improcité";
	$sMailFromEmail = "contact@improcite.com";
	
	$sMailHeaders ="From: \"$sMailFromName\"<$sMailFromEmail>\n";
	$sMailHeaders .="Reply-To: $sMailFromEmail\n";
	$sMailHeaders .="Content-Type: text/plain; charset=\"iso-8859-1\"\n";
	$sMailHeaders .="Content-Transfer-Encoding: 8bit"; 
	foreach($aMails as $aMail)
	{
		if ($aMail[0] == "mathieu.fremont@peous.com")
		{
			//$aMail[0] = "mfremont@edengames.com";
			//print_r( $aMail );
			//flush();
			//mail($aMail[0], $aMail[1], $aMail[2], $sMailHeaders);
		}
	}
}


# Fermeture du corps de la page
echo "</div>\n" ;

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
