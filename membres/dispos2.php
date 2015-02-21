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

?>
<style>
.dispo_comment
{
	border:1px solid #DDD;
	font-size: 75%;
	color:#888;
	padding-top : 2px;
	padding-bottom : 2px;
	padding-left:10px;
	padding-right:10px;
	border-radius: 6px;
	margin-left:30px;
}

.details_spectacle
{
	border:1px solid #DDD;
	background:#EFEFEF;
	padding-top : 2px;
	padding-bottom : 2px;
	padding-left:10px;
	padding-right:10px;
	border-radius: 6px;
	margin-bottom:8px;
}
</style>
<?


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

# Mois et année
$event = getp("event");
if(!$event)
{
	die("No event requested");
}


# Proprietes du tableau
$iFontSize = 9;
$sStyl = " valign=\"top\" style=\"text-align:center\"";

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
	$aStats[$aRowJ['id']] = array('joueur' => 0, 'coach'=>0, 'mc'=>0, 'arbitre'=>0, 'regisseur'=>0, 'caisse'=>0, 'catering'=>0, 'ovs'=>0);
}

//-------------------------------- 

$filtredate = "e.id = ".$event;
$sWhereTrain = $bDisplayTrain ? " AND e.categorie = $category_train " : " AND e.categorie <> $category_train ";
$sSQL = "SELECT e.id as id, l.nom as lnom, c.nom as nom, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.regisseur as regisseur, e.caisse as caisse, e.catering as catering, e.ovs as ovs "
		."FROM $t_eve e, $t_cat c, $t_lieu l "
		."WHERE e.categorie=c.id AND $filtredate AND e.lieu=l.id $sWhereTrain"
		."ORDER BY date ASC";
$requete_prochains = fxQuery($sSQL) ;

# En tete
while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
{

	list($eventNext, $eventNextDate) = fxQueryMultiValues("SELECT e.id, e.date FROM $t_eve e WHERE e.lieu > 0 AND e.date > '".$aRow["date"]."'". $sWhereTrain." ORDER BY e.date ASC LIMIT 1");
	list($eventPrev, $eventPrevDate) = fxQueryMultiValues("SELECT e.id, e.date FROM $t_eve e WHERE e.lieu > 0 AND e.date < '".$aRow["date"]."'". $sWhereTrain." ORDER BY e.date DESC LIMIT 1");
	
	# Liens pour avant et apres
	echo "<div id='choixdate' class='text-center'>";
	echo "<div class='btn-group'>";
	# <span class="hidden-xs">
	if($eventPrev) echo '<a class="btn btn-default" href="dispos2.php?train='.$bDisplayTrain.'&event='.$eventPrev.'"><i class="glyphicon glyphicon-chevron-left"></i> '.affiche_date($eventPrevDate, true).'</a>';
	//echo "<div class='btn btn-default'>$month/$year</div>";
	if($eventNext) echo '<a class="btn btn-default" href="dispos2.php?train='.$bDisplayTrain.'&event='.$eventNext.'">'.affiche_date($eventNextDate, true).' <i class="glyphicon glyphicon-chevron-right"></i></a>';
	echo "</div>";
	echo "</div>";	
	
	$date = affiche_date($aRow["date"]);
	$sOutDated = ($aRow["unixdate"] < time()) ? "class=\"outdated\"":"";
	
	echo "<h1>".$date."</h1>" ;
?>
<div class="details_spectacle">
- <?=$aRow["nom"]?><br/>
- <?=$aRow["lnom"]?><br/>
<? if($aRow["ecommentaire"]) { ?><?=(" - ".$aRow["ecommentaire"])?><? } ?>
</div>

<table class="table table-condensed">
<?
	foreach($aMembres as $aRowJ)
	{
		$id = $aRowJ['id'];
		
		echo "<tr><td>";
		
		$photo = "../".$sPhotoRelDir . $currentSaisonBit . "/" ."$id.jpg";
		if (!file_exists($photo)) { $photo = "../".$sPhotoRelDir."$id.jpg"; }
		if (!file_exists($photo)) { $photo = "../".$sPhotoRelDir."defaut.jpg"; }
		echo "<img style=\"height:30px;\" src=\"$photo\" />\n";
		
		echo "</td><td>";
		
		echo "<div style=\"line-height:30px;\">";
		if ($aRowJ['id'] == $_SESSION['id_impro_membre']) echo "<b>";
		echo $aMemberIdToName[$id];
		if ($aRowJ['id'] == $_SESSION['id_impro_membre']) echo "</b>";
		echo "</div>";
		echo "</td><td>";
	
		list($iDispo,$sComment) = fxQueryMultiValues("SELECT dispo_pourcent, commentaire FROM impro_dispo WHERE id_spectacle = ? AND id_personne = ?", array($aRow['id'], $aRowJ['id']));
		
		$sClrOui = "#BBFFBB"; $sClrNon = "#FFBBBB"; $sClrSel = "#FFFFBB";
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
		
			if ($bAdminDispoFeatures
					||  ($aRowJ['id'] == $_SESSION['id_impro_membre']
					  &&  $iDispo=="") // avec cette option on peut rentrer ses dispos qu'une fois :)
					  )
			{
				?>
				<form action="dispos2.php" method="get">
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
				<input type="hidden" name="year" value="<?=$year?>">
				</form>
				
				<?
			}
			else
			{
				$sCancel = "";
				if ($aRowJ['id'] == $_SESSION['id_impro_membre'])
				{
					$sCancel = "&nbsp;<a href=dispos2.php?user={$aRowJ['id']}&event={$aRow['id']}&train={$bDisplayTrain}&dispo=>"
								."<span style=\"font-size:20px;line-height:30px;\">"
								."<i class=\"glyphicon glyphicon-remove\"></i></span></a>";
				}
				if ($sComment)
				{
					//$sComment = "<br><font size=-2>".
					//			"<div data-html=\"true\" data-toggle=\"tooltip\" title=\"".$sComment."\" style=\"cursor:help\">".
					//			cutIfWider($sComment, 10).
					//			"</div></font>";
				}
				
				$bSelection = strstr(";".$aRow['joueurs'].";", ";".$aRowJ['id'].";")
					||  $aRow['coach'] == $aRowJ['id']
					||  $aRow['mc'] == $aRowJ['id']
					||  $aRow['arbitre'] == $aRowJ['id']
					||  $aRow['regisseur'] == $aRowJ['id']
					||  $aRow['caisse'] == $aRowJ['id']
					||  $aRow['catering'] == $aRowJ['id']
					||  $aRow['ovs'] == $aRowJ['id'];
				if ($bSelection)
				{
					$sName = "Joueur";
					if ($aRow['coach'] == $aRowJ['id']) $sName = "Coach";
					if ($aRow['mc'] == $aRowJ['id']) $sName = "MC";
					if ($aRow['arbitre'] == $aRowJ['id']) $sName = "Arbitre";
					if ($aRow['regisseur'] == $aRowJ['id']) $sName = "Régisseur";
					if ($aRow['caisse'] == $aRowJ['id']) $sName = "Caisse";
					if ($aRow['catering'] == $aRowJ['id']) $sName = "Catering";
					if ($aRow['ovs'] == $aRowJ['id']) $sName = "OVS";
				
					if (!$bSelectionDispoFeatures)
					{
						echo "<span style=\"line-height:30px;\">".$sImgSel . $sName . $sCancel."</span>";
					}
				}
				else
				{
					if ($iDispo == "") echo "{$sImgUnk}";
					if ($iDispo == "0") echo "{$sImgNon}{$sCancel}";
					if ($iDispo == "100") echo "{$sImgOui}{$sCancel}";
				}
			}
		
		if ($bSelectionDispoFeatures)
		{
			?>
			<br />
			<form action="dispos2.php" method="get">
			<input type="hidden" name="user" value="<?=$aRowJ['id']?>">
			<input type="hidden" name="event" value="<?=$aRow['id']?>">
			<select style="font-size:<?=$iFontSize?>pt;border:0px;background-color:#000;color:#AAA;" name="selection" onChange='form.submit()'>
			<OPTION value=""></OPTION>
			<OPTION value="j" <?=(strstr(";".$aRow['joueurs'].";", ";".$aRowJ['id'].";"))?"SELECTED":""?>>Joueur</OPTION>
			<OPTION value="c" <?=($aRow['coach'] == $aRowJ['id'])?"SELECTED":""?>>Coach</OPTION>
			<OPTION value="mc" <?=($aRow['mc'] == $aRowJ['id'])?"SELECTED":""?>>MC</OPTION>
			<OPTION value="a" <?=($aRow['arbitre'] == $aRowJ['id'])?"SELECTED":""?>>Arbitre</OPTION>
			<OPTION value="r" <?=($aRow['regisseur'] == $aRowJ['id'])?"SELECTED":""?>>Régisseur</OPTION>
			<OPTION value="cai" <?=($aRow['caisse'] == $aRowJ['id'])?"SELECTED":""?>>Caisse</OPTION>
			<OPTION value="cat" <?=($aRow['catering'] == $aRowJ['id'])?"SELECTED":""?>>Catering</OPTION>
			<OPTION value="ovs" <?=($aRow['ovs'] == $aRowJ['id'])?"SELECTED":""?>>OVS</OPTION>
			</select>
			<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
			</form>
			<?
		}
		
		echo "</td></tr>";
		
		if($sComment)
		{
			?><tr><td style="border-top:none;padding-top:0px;" colspan="3"><div class="dispo_comment"><?=$sComment?></div></td></tr><?
		}
	}
	break;
}

echo "</table>";
echo "</div>";

# Options administrateur/selectionneur
if (!isPrintMode()  &&  !$bDisplayTrain)
{
	if ($bIsAdmin)
	{
		?>
		<form style="display:inline;" action="dispos2.php" method="get">
		<select name="adminfeatures" onChange="form.submit()">
		<OPTION value="1" <?=$bAdminDispoFeatures?"SELECTED":""?>>Mode admin activé</OPTION>
		<OPTION value="0" <?=$bAdminDispoFeatures?"":"SELECTED"?>>Mode admin désactivé</OPTION>
		</select>
		<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
		<input type="hidden" name="event" value="<?=$event?>">
		</form></p>
		<?
	}
	if ($bIsSelectionneur)
	{
		?>
		<form style="display:inline;" action="dispos2.php" method="get">
		<select name="selectfeatures" onChange="form.submit()">
		<OPTION value="1" <?=$bSelectionDispoFeatures?"SELECTED":""?>>Mode sélectionneur activé</OPTION>
		<OPTION value="0" <?=$bSelectionDispoFeatures?"":"SELECTED"?>>Mode sélectionneur désactivé</OPTION>
		</select>
		<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
		<input type="hidden" name="event" value="<?=$event?>">
		</form></p>
		<?
	}
}

DisplayPrintButton();

# Fermeture du corps de la page
echo "</div>\n" ;

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
