<?php

#====================================================================
# Credits du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

include ( "tete.php" ) ;

# Verification de la disponibilite de MySQL
if ( ! $connexion || ! $db )
{
	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
	die();
}



# Traitement special pour les entrainements
$bDisplayTrain = getp("train") ? 1 : 0;
$CURRENT_MENU_ITEM = $bDisplayTrain ? "dispos_t" : "dispos";

# Gestion des droits
$bIsAdmin = fxUserHasRight("admin");
$bIsSelectionneur = fxUserHasRight("selection");
if (getp("adminfeatures") == "0") unset($_SESSION["adminfeatures"]);
if (getp("adminfeatures") == "1") $_SESSION["adminfeatures"] = 1;
if (getp("selectfeatures") == "0") unset($_SESSION["selectfeatures"]);
if (getp("selectfeatures") == "1") $_SESSION["selectfeatures"] = 1;

$bAdminDispoFeatures = getp("adminfeatures")  ||  (isset($_SESSION["adminfeatures"]) && $_SESSION["adminfeatures"]);
$bSelectionDispoFeatures = getp("selectfeatures")  ||  (isset($_SESSION["selectfeatures"]) && $_SESSION["selectfeatures"]);

if (getp("user")  &&  getp("event"))
{
	if (getp("dispo", false) !== false)
	{
		if (getp("dispo") == "")
		{	// effacement
			fxQuery("DELETE FROM impro_dispo WHERE id_spectacle = ? AND id_personne = ?", array(getp("event"),getp("user")));
		}
		else
		{
			fxQueryReplace("impro_dispo", array("id_spectacle"=>getp("event"), "id_personne"=>getp("user"), "dispo_pourcent"=>getp("dispo"), "commentaire"=>getp("commentaire")));
		}
	}
	
	if (getp("selection", false) !== false)
	{
		$s = getp("selection");
		$aEvent = fxFetch(fxQuery("SELECT * FROM $t_eve WHERE id = ?", getp("event")));
		if ($aEvent['coach'] == getp("user")) fxQueryUpdate($t_eve, array('coach'=>''), getp("event"));
		if ($aEvent['mc'] == getp("user")) fxQueryUpdate($t_eve, array('mc'=>''), getp("event"));
		if ($aEvent['arbitre'] == getp("user")) fxQueryUpdate($t_eve, array('arbitre'=>''), getp("event"));
		if ($aEvent['regisseur'] == getp("user")) fxQueryUpdate($t_eve, array('regisseur'=>''), getp("event"));
		if ($aEvent['caisse'] == getp("user")) fxQueryUpdate($t_eve, array('caisse'=>''), getp("event"));
		if ($aEvent['catering'] == getp("user")) fxQueryUpdate($t_eve, array('catering'=>''), getp("event"));
		if ($aEvent['ovs'] == getp("user")) fxQueryUpdate($t_eve, array('ovs'=>''), getp("event"));
		$sNoJoueur = trim(str_replace(";".getp("user").";", "", ";".$aEvent['joueurs'].";"), ";");
		$sNoJoueur = preg_replace("~[0-9][0-9][0-9]+~", "", $sNoJoueur);// cleanup des 2425; qui trainent
		
		if (strstr(";".$aEvent['joueurs'].";", ";".getp("user").";")) fxQueryUpdate($t_eve, array('joueurs'=>$sNoJoueur), getp("event"));
		
		if ($s == "c") 
		{
			fxQueryUpdate($t_eve, array('coach'=>getp("user")), getp("event"));
		}
		else if ($s == "mc") 
		{
			fxQueryUpdate($t_eve, array('mc'=>getp("user")), getp("event"));
		}
		else if ($s == "a") 
		{
			fxQueryUpdate($t_eve, array('arbitre'=>getp("user")), getp("event"));
		}
		else if ($s == "r") 
		{
			fxQueryUpdate($t_eve, array('regisseur'=>getp("user")), getp("event"));
		}
		else if ($s == "cai") 
		{
			fxQueryUpdate($t_eve, array('caisse'=>getp("user")), getp("event"));
		}
		else if ($s == "cat") 
		{
			fxQueryUpdate($t_eve, array('catering'=>getp("user")), getp("event"));
		}
		else if ($s == "ovs") 
		{
			fxQueryUpdate($t_eve, array('ovs'=>getp("user")), getp("event"));
		}
		else if ($s == "j") 
		{
			fxQueryUpdate($t_eve, array('joueurs'=>($sNoJoueur.";".getp("user"))), getp("event"));
		}
	}
}

echo "<div id=\"corps\">\n" ;
$year = 2004 + $iCurrentSaisonNumber;
echo "<h1>Statistiques de jeu pour ".$year." - ".($year+1)."</h1>\n" ;

# Proprietes du tableau
$iFontSize = 9;
$sStyl = " valign=\"top\" style=\"text-align:center\"";
$sTableHeader   = "<table class=\"grid\" style=\"font-size:{$iFontSize}pt;\" border=\"0\" cellspacing=\"0\" cellpadding=\"2px\">";
$sColumnHeader  = "<tr bgcolor=\"#444444\" style=\"font-weight:bold\">";
$sColumnHeader .= "<td {$sStyl} width=\"5%\">Quand</td><td {$sStyl} width=\"10%\">Quoi</td>";
$sColumnHeader .= "<td {$sStyl} width=\"5%\">Dispo.</td>";

# Filtre de recherche des comediens
# -> Saison en cours
$saison =  7 << $iCurrentSaisonNumber;
$filtresql = "saison & ".($saison)." <> 0";
# -> pas les 'noselect'
$filtresql .= " AND rights NOT LIKE '%noselect%'";

$requete_membres = fxQuery ( "SELECT * FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;
$aMembres = array();
while ($aRowJ = mysql_fetch_array($requete_membres, MYSQL_ASSOC))
{
	$aMembres[] = $aRowJ;
}
$nbMembres = sizeof($aMembres);
$aMemberIdToName = array();
$aStats = array();
foreach($aMembres as $aRowJ)
{
	$sNom = str_replace("-", " - ", $aRowJ['prenom']);
	$aMemberIdToName[$aRowJ['id']] = $sNom;
	
	$w = 80/$nbMembres;
	$sColumnHeader .= "<td {$sStyl} width=\"{$w}%\">{$sNom}</td>";
	
	$aStats[$aRowJ['id']] = array('joueur' => 0, 'coach'=>0, 'mc'=>0, 'arbitre'=>0, 'regisseur'=>0, 'caisse'=>0, 'catering'=>0, 'ovs'=>0);
}
$sColumnHeader .= "</tr>";


//-------------------------------- STATS

$sqlResult = fxQuery("SELECT * from $t_eve e WHERE date>'".(2004 + $iCurrentSaisonNumber)."0901000000'", MYSQL_ASSOC);
while ($aRow = mysql_fetch_array($sqlResult))
{
	if ($aRow['coach']) $aStats[$aRow['coach']]['coach']++;
	if ($aRow['mc']) $aStats[$aRow['mc']]['mc']++;
	if ($aRow['arbitre']) $aStats[$aRow['arbitre']]['arbitre']++;
	if ($aRow['regisseur']) $aStats[$aRow['regisseur']]['regisseur']++;
	if ($aRow['caisse']) $aStats[$aRow['caisse']]['caisse']++;
	if ($aRow['catering']) $aStats[$aRow['catering']]['catering']++;
	if ($aRow['ovs']) $aStats[$aRow['ovs']]['ovs']++;
	foreach(explode(';', $aRow['joueurs']) as $idJoueur)
	{
		if ($idJoueur) $aStats[$idJoueur]['joueur']++;
	}
}
echo '<div class="table-responsive">';
echo "<table class=\"table table-striped table-hover table-condensed table-bordered\" >";
$bFirst = true;
foreach($aStats as $idJoueur => $aStatJoueur)
{
	if(!isset($aMemberIdToName[$idJoueur])) continue;
	
	if ($bFirst)
	{
		$bFirst = false;
		echo "<thead><tr><th></th>";
		foreach($aStatJoueur as $nomCategorie => $count)
		{
			echo '<th class="text-center">'.ucfirst($nomCategorie).'</th>';
		}
		echo "</tr></thead><tbody>";	
	}
	echo "<tr>";
	echo '<th>'.$aMemberIdToName[$idJoueur].'</th>';
	foreach($aStatJoueur as $nom => $count)
	{
		echo '<td class="text-center" width="10%">';
		echo  $count ? $count : "";
		echo "</td>";
	}
	echo "</tr>";
}
echo "</tbody></table>";
echo '</div>';
?>
* Basé sur les sélections
<?
//-------------------------------- 

DisplayPrintButton();
# Affichage du pied de page
@include ( "pied.php" ) ;

?>
