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

if ($bDisplayTrain)
{
	echo "<h1>Disponibilités <b>entrainements</b></h1>\n" ;
}
else
{
	echo "<h1>Disponibilités <b>spectacles</b></h1>\n" ;
}

# Mois et année
$month = 0;
$year = 0;
if (getp("month") && getp("year")) {
	$year = getp("year");
       	$month = getp("month");
} else {
	# On recupere la date actuelle
	$year = date("Y");
	$month = date("m");
}


$month_before = 0;
$month_after = 0;
$year_before = 0;
$year_after = 0;

if ($month === "01") {
	$month_before = "12";
	$month_after = "02";
	$year_before = intval($year) - 1;
	$year_after = intval($year);
} elseif ($month === "12") {
	$month_before = "11";
	$month_after = "01";
	$year_before = intval($year);
	$year_after = intval($year) + 1;
} else { 
	$month_before = intval($month) -1;
	$month_after = intval($month) + 1;
	$year_before = intval($year);
	$year_after = intval($year);
}

if ( strlen( $month_before ) == 1) { $month_before = "0" . $month_before; }
if ( strlen( $month_after ) == 1) { $month_after = "0" . $month_after; } 

# Liens pour avant et apres
echo "<div id='choixdate' class='text-center'>";
echo "<div class='btn-group'>";
echo '<a class="btn btn-default" href="dispos.php?train='.$bDisplayTrain.'&month='.$month_before.'&year='.$year_before.'"><i class="glyphicon glyphicon-chevron-left"></i> <span class="hidden-xs">Mois pr&eacute;c&eacute;dent</span></a>';
echo "<div class='btn btn-default'>$month/$year</div>";
echo '<a class="btn btn-default" href="dispos.php?train='.$bDisplayTrain.'&month='.$month_after.'&year='.$year_after.'"><span class="hidden-xs">Mois suivant</span> <i class="glyphicon glyphicon-chevron-right"></i></a>';
echo "</div>";
echo "</div>";

echo "<hr />\n";

# Proprietes du tableau
$iFontSize = 9;
$sStyl = " valign=\"top\" style=\"text-align:center\"";
$sTableHeader  .= "<table class=\"grid table\">";
$sColumnHeader .= "<tr bgcolor=\"#888\" style=\"font-weight:bold\">";
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

//-------------------------------- 

# Affichage des evenements
# Seulement pour le mois en cours
$filtredate = "date>'".$year.$month."01000000' AND date<'".$year.$month."31235959'";
$sWhereTrain = $bDisplayTrain ? " AND e.categorie = $category_train " : " AND e.categorie <> $category_train ";
$sSQL = "SELECT e.id as id, l.nom as lnom, c.nom as nom, e.date as date, UNIX_TIMESTAMP(e.date) as unixdate, e.joueurs as joueurs, e.mc as mc, e.arbitre as arbitre, e.coach as coach, e.commentaire as ecommentaire, e.regisseur as regisseur, e.caisse as caisse, e.catering as catering, e.ovs as ovs "
		."FROM $t_eve e, $t_cat c, $t_lieu l "
		."WHERE e.categorie=c.id AND $filtredate AND e.lieu=l.id $sWhereTrain"
		."ORDER BY date ASC";
$requete_prochains = fxQuery($sSQL) ;

# En tete
echo "<div class='table-responsive'>\n";
echo $sTableHeader;
echo $sColumnHeader;

while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
{
	$date = affiche_date($aRow["date"]);
	
	$sOutDated = ($aRow["unixdate"] < time()) ? "class=\"outdated\"":"";
	echo "<tr $sOutDated>";
	$nbMembresDispos = fxQuerySingleValue( "SELECT COUNT(*) FROM impro_dispo WHERE id_spectacle = ? AND dispo_pourcent = 100", $aRow['id'] ) ;
?>

<td  <?=$sStyl?>><?=$date?></td>

<?
//data-toggle="tooltip" title="'.$t
//ecommentaire
?>

<td <?=$sStyl?> >
	<u><?=$aRow["nom"]?></u><br />
	<?=$aRow["lnom"]?><br />
	<i><?=$aRow["ecommentaire"]?></i>
	
</td>

<td <?=$sStyl?>><?=$nbMembresDispos?></td>

<?
	
	foreach($aMembres as $aRowJ)
	{
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
				<input type="hidden" name="month" value="<?=$month?>">
				<input type="hidden" name="year" value="<?=$year?>">
				</form>
				
				<?
			}
			else
			{
				$sCancel = "";
				if ($aRowJ['id'] == $_SESSION['id_impro_membre']) $sCancel = "&nbsp;<a href=dispos.php?user={$aRowJ['id']}&event={$aRow['id']}&train={$bDisplayTrain}&month={$month}&year={$year}&dispo=><small>[x]</small></a>";
				if ($sComment) $sComment = "<br><font size=-2>$sComment</font>";
				
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
		
		if ($bSelectionDispoFeatures)
		{
			?>
			<br />
			<form action="dispos.php" method="get">
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
			<input type="hidden" name="month" value="<?=$month?>">
			<input type="hidden" name="year" value="<?=$year?>">
			</form>
			<?
		}
		
		echo "</td>";
	}
	echo "</tr>";
}

# Pied
echo $sColumnHeader;

echo "</table>";
echo "</div>";

# Options administrateur/selectionneur
if (!isPrintMode()  &&  !$bDisplayTrain)
{
	if ($bIsAdmin)
	{
		?>
		<p>Activation des fonctionnalités <b>administrateur</b> sur cette page:
		<form style="display:inline;" action="dispos.php" method="get">
		<select name="adminfeatures" onChange="form.submit()">
		<OPTION value="1" <?=$bAdminDispoFeatures?"SELECTED":""?>>Activé</OPTION>
		<OPTION value="0" <?=$bAdminDispoFeatures?"":"SELECTED"?>>Désactivé</OPTION>
		</select>
		<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
		<input type="hidden" name="month" value="<?=$month?>">
		<input type="hidden" name="year" value="<?=$year?>">
		</form></p>
		<?
	}
	if ($bIsSelectionneur)
	{
		?>
		<p>Activation des fonctionnalités <b>sélectionneur</b> sur cette page:
		<form style="display:inline;" action="dispos.php" method="get">
		<select name="selectfeatures" onChange="form.submit()">
		<OPTION value="1" <?=$bSelectionDispoFeatures?"SELECTED":""?>>Activé</OPTION>
		<OPTION value="0" <?=$bSelectionDispoFeatures?"":"SELECTED"?>>Désactivé</OPTION>
		</select>
		<input type="hidden" name="train" value="<?=$bDisplayTrain?>">
		<input type="hidden" name="month" value="<?=$month?>">
		<input type="hidden" name="year" value="<?=$year?>">
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
