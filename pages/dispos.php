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

DisplayPrintButton();

$bIsAdmin = fxUserHasRight("admin");
$bIsSelectionneur = fxUserHasRight("selection");

$bDisplayTrain = getp("train") ? 1 : 0;

$CURRENT_MENU_ITEM = $bDisplayTrain ? "dispos_t" : "dispos";

if (getp("adminfeatures") == "0") unset($_SESSION["adminfeatures"]);
if (getp("adminfeatures") == "1") $_SESSION["adminfeatures"] = 1;
if (getp("selectfeatures") == "0") unset($_SESSION["selectfeatures"]);
if (getp("selectfeatures") == "1") $_SESSION["selectfeatures"] = 1;

if ($bDisplayTrain)
{
	$bAdminDispoFeatures = false;
	$bSelectionDispoFeatures = false;
}
else
{
	$bAdminDispoFeatures = getp("adminfeatures")  ||  (isset($_SESSION["adminfeatures"]) && $_SESSION["adminfeatures"]);
	$bSelectionDispoFeatures = getp("selectfeatures")  ||  (isset($_SESSION["selectfeatures"]) && $_SESSION["selectfeatures"]);
}

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
		else if ($s == "j") 
		{
			fxQueryUpdate($t_eve, array('joueurs'=>($sNoJoueur.";".getp("user"))), getp("event"));
		}
	}
}

echo "<div id=\"corps\">\n" ;

if ($bDisplayTrain)
{
	echo "<h1>Disponibilit�s <b>entrainements</b></h1>\n" ;
}
else
{
	echo "<h1>Disponibilit�s <b>spectacles</b></h1>\n" ;
}

if (!isPrintMode()  &&  !$bDisplayTrain)
{
	if ($bIsAdmin)
	{
		?>
		<p>Activation des fonctionnalit�s <b>administrateur</b> sur cette page:
		<form style="display:inline;" action="dispos.php" method="get">
		<select name="adminfeatures" onChange="form.submit()">
		<OPTION value="1" <?=$bAdminDispoFeatures?"SELECTED":""?>>Activ�</OPTION>
		<OPTION value="0" <?=$bAdminDispoFeatures?"":"SELECTED"?>>D�sactiv�</OPTION>
		</select>
		<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
		</form></p>
		<?
	}
	if ($bIsSelectionneur)
	{
		?>
		<p>Activation des fonctionnalit�s <b>s�lectionneur</b> sur cette page:
		<form style="display:inline;" action="dispos.php" method="get">
		<select name="selectfeatures" onChange="form.submit()">
		<OPTION value="1" <?=$bSelectionDispoFeatures?"SELECTED":""?>>Activ�</OPTION>
		<OPTION value="0" <?=$bSelectionDispoFeatures?"":"SELECTED"?>>D�sactiv�</OPTION>
		</select>
		<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
		</form></p>
		<?
	}
?>
<p class="toggleOutdated">Afficher/masquer les anciennes dates</p>
<?
}

$iFontSize = 8;
$sStyl = " valign=\"top\"";

$sColumnHeader = "";

$sColumnHeader .= "<table class=\"grid\"  style=\"font-size:{$iFontSize}pt;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr bgcolor=\"#444444\">";
$sColumnHeader .= "<td {$sStyl}>Quand</td><td {$sStyl} width=\"15%\">Quoi</td>";

if (!$bDisplayTrain)
{
	$sColumnHeader .= "<td {$sStyl}>Dispo.</td>";
}

$saison = 1 << $iCurrentSaisonNumber;
$filtresql = "saison & ".($saison)." <> 0";
$filtresql .= " AND rights NOT LIKE '%noselect%'";

//$nbMembres = fxQuerySingleValue( "SELECT COUNT(*) FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;
//$requete_membres = mysql_query ( "SELECT * FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;

$requete_membres = fxQuery ( "SELECT * FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;
$aMembres = array();
while ($aRowJ = mysql_fetch_array($requete_membres, MYSQL_ASSOC))
{
	$aMembres[] = $aRowJ;
}
$nbMembres = sizeof($aMembres);

foreach($aMembres as $aRowJ)
{
	$sNom = str_replace("-", " - ", $aRowJ['prenom']);
	$w = 80/$nbMembres;
	$sColumnHeader .= "<td  {$sStyl} width=\"{$w}%\" valign=\"top\">{$sNom}</td>";
}
$sColumnHeader .= "</tr>";

$iCount = 0;
$date_debut_saison = date("YmdHis", mktime(0, 0, 0, 8, 1, 2004+$iCurrentSaisonNumber)) ;
//$date_actuelle = date("YmdHis") ;
$sWhereTrain = $bDisplayTrain ? " AND e.categorie = 1 " : " AND e.categorie <> 1 ";
$sSQL = "SELECT e.id as id, l.nom as lnom, c.nom as nom, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.regisseur as regisseur, e.caisse as caisse, e.catering as catering "
		."FROM $t_eve e, $t_cat c, $t_lieu l "
		."WHERE e.categorie=c.id AND e.date>'$date_debut_saison' AND e.lieu=l.id $sWhereTrain"
		."ORDER BY date ASC";
$requete_prochains = fxQuery($sSQL) ;
while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
{
	if ($iCount % 5 == 0) { echo $sColumnHeader; }
	$iCount++;
	$date = affiche_date($aRow["date"]);
	
	$sOutDated = ($aRow["unixdate"] < time()) ? "class=\"outdated hidden\"":"";
	echo "<tr $sOutDated>";
	if (!$bDisplayTrain)
	{
		$nbMembresDispos = fxQuerySingleValue( "SELECT COUNT(*) FROM impro_dispo WHERE id_spectacle = ? AND dispo_pourcent = 100", $aRow['id'] ) ;
	}
	?><td  <?=$sStyl?>><?=$date?></td><td  <?=$sStyl?>><u><?=$aRow["nom"]?></u><br><i><?=$aRow["lnom"]?></i><br><?=$aRow["ecommentaire"]?></td>
	<? if (!$bDisplayTrain)
	{
		?><td  <?=$sStyl?> align=center><?=$nbMembresDispos?></td><?
	}
	
	foreach($aMembres as $aRowJ)
	{
		list($iDispo,$sComment) = fxQueryMultiValues("SELECT dispo_pourcent, commentaire FROM impro_dispo WHERE id_spectacle = ? AND id_personne = ?", array($aRow['id'], $aRowJ['id']));
		
		
		$sClrOui = "#008800"; $sClrNon = "#880000"; $sClrSel = "#AA00AA";
		//$sClrOui = ""; $sClrNon = ""; $sClrSel = "";
		$sImgOui = "<img src=img/yes.gif>";
		$sImgNon = "<img src=img/no.gif>";
		$sImgSel = "<img src=img/star.gif>";
		$sImgUnk = "<img src=img/unk.gif>";

		
		if (isPrintMode())
		{
			$sClrOui = "";
			$sClrNon = "";
			$sClrSel = "";
		}	


		
		if ($bDisplayTrain)
		{
			$sCancel = "";
			if ($aRowJ['id'] == $_SESSION['id_impro_membre'])
			{
				$sCancel = "&nbsp;<a href=dispos.php?user={$aRowJ['id']}&event={$aRow['id']}&train={$bDisplayTrain}&dispo=".(($iDispo == "0")?"":"0")."><small>[x]</small></a>";
			}
			
			if ($iDispo == "0")
			{
				echo "<td $sStyl bgcolor=\"$sClrNon\" align=\"center\">{$sImgNon}{$sCancel}{$sComment}";
			}
			else
			{
				echo "<td $sStyl bgcolor=\"$sClrOui\" align=\"center\">{$sImgOui}{$sCancel}{$sComment}";
			}
		}
		
		else
		{		
			if ($bAdminDispoFeatures
					||  ($aRowJ['id'] == $_SESSION['id_impro_membre']
					  &&  $iDispo=="") // avec cette option on peut rentrer ses dispos qu'une fois :)
					  )
			{
				?>
				<td $sStyl width="<?=(100/$nbMembres)?>%"><form action="dispos.php" method="get">
				<input type="hidden" name="user" value="<?=$aRowJ['id']?>">
				<input type="hidden" name="event" value="<?=$aRow['id']?>">
				<small><u>Dispo:</u></small><br>
				<select style="font-size:<?=$iFontSize?>pt;" name="dispo" onChange="form.submit()">
				<OPTION value="" <?=($iDispo=="")?"SELECTED":""?>>?</OPTION>
				<OPTION value="100" <?=($iDispo=="100")?"SELECTED":""?>>Oui</OPTION>
				<OPTION value="0" <?=($iDispo=="0")?"SELECTED":""?>>Non</OPTION></select>
				<small><u>Commentaire:</u></small><br>
				<input style="font-size:<?=$iFontSize?>pt;" name="commentaire" value="<?=$sComment?>" size="10" maxsize="100">
				<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
				</form>
				
				<?
			}
			else
			{
				$sCancel = "";
				if ($aRowJ['id'] == $_SESSION['id_impro_membre']) $sCancel = "&nbsp;<a href=dispos.php?user={$aRowJ['id']}&event={$aRow['id']}&train={$bDisplayTrain}&dispo=><small>[x]</small></a>";
				if ($sComment) $sComment = "<br><font size=-2>$sComment</font>";
				
				$bSelection = strstr(";".$aRow['joueurs'].";", ";".$aRowJ['id'].";")
					||  $aRow['coach'] == $aRowJ['id']
					||  $aRow['mc'] == $aRowJ['id']
					||  $aRow['arbitre'] == $aRowJ['id']
					||  $aRow['regisseur'] == $aRowJ['id']
					||  $aRow['caisse'] == $aRowJ['id']
					||  $aRow['catering'] == $aRowJ['id'];
				if ($bSelection)
				{
					$sName = "Joueur";
					if ($aRow['coach'] == $aRowJ['id']) $sName = "Coach";
					if ($aRow['mc'] == $aRowJ['id']) $sName = "MC";
					if ($aRow['arbitre'] == $aRowJ['id']) $sName = "Arbitre";
					if ($aRow['regisseur'] == $aRowJ['id']) $sName = "R�gisseur";
					if ($aRow['caisse'] == $aRowJ['id']) $sName = "Caisse";
					if ($aRow['catering'] == $aRowJ['id']) $sName = "Catering";
				
					echo "<td $sStyl bgcolor=\"$sClrSel\" align=\"center\">{$sImgSel}{$sComment}";
					
					if (!$bSelectionDispoFeatures)
					{
						echo "<small><br><font color=#3FB1BF>$sName</font></small>";
					}
				}
				else
				{
					if ($iDispo == "") echo "<td $sStyl align=center>{$sImgUnk}{$sComment}";
					if ($iDispo == "0") echo "<td $sStyl bgcolor=\"$sClrNon\" align=\"center\">{$sImgNon}{$sCancel}{$sComment}";
					if ($iDispo == "100") echo "<td $sStyl bgcolor=\"$sClrOui\" align=\"center\">{$sImgOui}{$sCancel}{$sComment}";
				}
			}
		}
		
		if ($bSelectionDispoFeatures)
		{
			?>
			<br><!--<small><u>Selection:</u></small><br>-->
			<form action="dispos.php" method="get">
			<input type="hidden" name="user" value="<?=$aRowJ['id']?>">
			<input type="hidden" name="event" value="<?=$aRow['id']?>">
			<select style="font-size:<?=$iFontSize?>pt;border:0px;background-color:#000;color:#AAA;" name="selection" onChange='form.submit()'>
			<OPTION value=""></OPTION>
			<OPTION value="j" <?=(strstr(";".$aRow['joueurs'].";", ";".$aRowJ['id'].";"))?"SELECTED":""?>>Joueur</OPTION>
			<OPTION value="c" <?=($aRow['coach'] == $aRowJ['id'])?"SELECTED":""?>>Coach</OPTION>
			<OPTION value="mc" <?=($aRow['mc'] == $aRowJ['id'])?"SELECTED":""?>>MC</OPTION>
			<OPTION value="a" <?=($aRow['arbitre'] == $aRowJ['id'])?"SELECTED":""?>>Arbitre</OPTION>
			<OPTION value="r" <?=($aRow['regisseur'] == $aRowJ['id'])?"SELECTED":""?>>R�gisseur</OPTION>
			<OPTION value="cai" <?=($aRow['caisse'] == $aRowJ['id'])?"SELECTED":""?>>Caisse</OPTION>
			<OPTION value="cat" <?=($aRow['catering'] == $aRowJ['id'])?"SELECTED":""?>>Catering</OPTION>
			</select>
			<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
			</form>
			<?
		}
		
		echo "</td>";
	}
	echo "</tr>";
}
echo "</table>";


/*

$ical = new iCal();
echo "<h1>(test) Calendrier Google</h1>";
$aEvents = $ical->iCalDecoder("http://www.google.com/calendar/ical/webmaster%40improcite.com/public/basic.ics");
$sDateActuelle = date("YmdHis") ;
$aData = array();
foreach($aEvents as $aEvent)
{
	$aData[$aEvent['DTSTART']] = $aEvent;
}
ksort($aData);

foreach($aData as $sData => $aEvent)
{
	$sDate = str_replace("T", "", $aEvent['DTSTART']);
	$bHasTime = true;
	if (strlen($sDate) == 8) { $sDate .= "000000"; $bHasTime = false; }
	if (strlen($sDate) == 14)
	{
		if ($sDate > $sDateActuelle)
		{
			$aData[$sDate] = $aEvent;
			echo affiche_date($sDate)." ".($bHasTime ? affiche_heure($sDate) : "")." : ".$aEvent['SUMMARY']."<br>";
		}
	}
}

*/

# Fermeture du corps de la page
echo "</div>\n" ;

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
