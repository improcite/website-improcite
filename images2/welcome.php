<?php

include(dirname(__FILE__)."/../fxJoueurs.php");

// Trouver une photo de comédien à afficher parmi la saison actuelle
$rowMax = @mysql_fetch_array(mysql_query("SELECT MAX(id) as mx FROM $table_comediens WHERE saison & $currentSaisonBit <> 0"));
srand();
$iMax = $rowMax['mx'];
$iSecure = 10;
$rowComedien = array();
$sRandImage = "";

while ($iSecure--)
{
	$id = rand()%$iMax;
	$rowComedien = @mysql_fetch_array(mysql_query ( "SELECT * FROM $table_comediens WHERE (saison & ".(1<<$iCurrentSaisonNumber).") <> 0 AND id=".$id ));
	if ($rowComedien)
	{
		$sRandImage = $sPhotoRelDir.$rowComedien['id'].".jpg";
		if (!file_exists($sRandImage)) $sRandImage = $sPhotoRelDir."defaut.jpg";
		break;
	}
}

$oRqLastNews = mysql_query("SELECT * FROM impro_news WHERE active = 1 ORDER BY date desc");

$sRandComment = "Un adorable membre...";
if (rand()%2  &&  $rowComedien['defaut'])
{
	
	$sRandComment = "<u>Default de ".$rowComedien['prenom'].":</u> ".$rowComedien['defaut'];
}
else if ($rowComedien['qualite'])
{
	$sRandComment = "<u>Qualit&eacute; de ".$rowComedien['prenom'].":</u> ".$rowComedien['qualite'];
}
else
{
	$sRandComment = "<u>".$rowComedien['prenom']."</u>";
}

if (strlen($sRandComment)>100) $sRandComment = substr($sRandComment, 0, 100). "...";

$aPhotosRand = array(
				array("images/tontons.jpg","Retrouvez Improcité le 1er et le 3ème mardi du mois aux Tontons Flingueurs")
				);
$iRand = floor(rand(0, sizeof($aPhotosRand)-0.5));
$aInfo = $aPhotosRand[$iRand];
$sRandImage2 = $aInfo[0];
$sRandComment2 = $aInfo[1];

?>
	<table width=100%>
	<tr>
	<td style="vertical-align:top;">
	
		<div id="welcome">Bienvenue sur le site d'<a href=?p=improcite>Improcité</a>, la troupe d'improvisation théâtrale de Lyon et Villeurbanne</div>
		<?
		$bFirst = true;
		while ($aRowNews = @mysql_fetch_array($oRqLastNews))
		{
			if ($bFirst) { ?><h1>Dernières nouvelles</h1><? $bFirst = false; }
			
			?><div class="nouvelle"><h2>Le <?=affiche_date($aRowNews['date'])?></h2><?
			
			?><?
			echo affiche_texte($aRowNews['texte']);
			?></div><?
		}
		?>
		<h1>Prochains spectacles</h1>
		<p class="annonce">Retrouvez Improcité dans OMERTA les 1er et 3ème mardi du mois aux Tontons Flingueurs </p>
		<?
		$bFirst = true;
		$iCount = 0;
		$date_actuelle = date("YmdHis") ;
		$requete_prochains = fxQuery( "SELECT e.id as eid, c.id as cid, l.id as lid, e.commentaire as ecommentaire, c.description as cdescription, l.nom as lnom, c.nom as nom, e.date as date, e.joueurs as joueurs, e.places as places FROM $t_eve e, $t_cat c, $t_lieu l WHERE c.publique=1 AND e.categorie=c.id AND e.date>$date_actuelle AND e.lieu=l.id ORDER BY date ASC LIMIT 0,3" ) ;
		while ($aRow = mysql_fetch_array($requete_prochains,MYSQL_ASSOC))
		{
			$iCount++;
			$date = affiche_date($aRow["date"]);
		?>
			<div class="spectacle">
			<? // Affiche la photo de l'evenement ou de la categorie

				$photoEvenement = $sPhotoEvenement.$aRow["eid"].".jpg";
				$photoCategorie = $sPhotoCategorie.$aRow["cid"].".jpg";
				if ( file_exists($photoEvenement) ) {
					echo "<img src=\"$photoEvenement\" alt=\"$aRow[nom]\" class=\"affiche\"/>\n";
				}
				if ( file_exists($photoCategorie) ) {
					echo "<img src=\"$photoCategorie\" alt=\"$aRow[nom]\" class=\"affiche\"/>\n";
				}
			?>

			<p><a href="?p=agenda" title="<?=$aRow["cdescription"]?>"><?=$aRow["nom"]?></a>
			- <?=$date?> 
			- <a href="?p=lieux&id=<?=$aRow["lid"]?>"><?=$aRow["lnom"]?></a>
			&nbsp;&nbsp;
			</p>

			<table border="0" width="auto">
				<tr><td>
				<? fxDispJoueurArray(explode(";", $aRow['joueurs']), "width:40px;height:30px;"); ?>
				</td></tr>
				<tr><td valign="top">
				<? if ($aRow["ecommentaire"])
				{
				echo "<div style=\"padding:2px;\">";
				echo affiche_texte($aRow['ecommentaire']);
				echo "</div>";
				}
				?>
				</td></tr>
			</table>
			<? if ($aRow["places"]) { ?>
				<a href="?p=agenda"><img src="images/reserver.jpg" border="0" alt="Reserver"></a><br>
			<? }?>
			<hr style="clear:both"/>
			</div>
		<? } ?>
		
		<? if ($iCount == 0) { ?>
			<br>
			Au bar 'Le Trokson' sur la presqu'ile chaque dernier mercredi du mois !
			<div align="center"><a href="?p=agenda"><img SRC="images/reserver.jpg" border="0"></a></div>
		<? } ?>
		
		<h2>Nous vous pr&eacute;venons des prochains spectacles&nbsp;:</h2>
		<? afficher_inscription_newsletter(); ?>
		<br />
		</td>
	
	</td>
	<td style="vertical-align:top;">
		<table cellpadding=10>
		<tr><td>
		
			<table width="191" height="172" class="layertable" style="background-image:url(images/img_jour.jpg);">
			<tr height="45"><td colspan="3"></td></tr>
			<tr><td width="20"></td><td width="163"><a href="?p=comediens"><img border="0" src="<?=$sRandImage?>" width="163" height="121"></a></td><td></td></tr>
			<tr><td colspan="3"></td></tr>
			</table>
			<div class="smalltext" style="display:block;width:163px;margin-left:20px;text-align:center;"><?=$sRandComment?></div>
		
		</td></tr><tr><td>
	
			<table width="191" height="172" class="layertable" style="background-image:url(images/actu_spec.jpg);">
			<tr height="45"><td colspan="3"></td></tr>
			<tr><td width="20"></td><td width="163"><a href="?p=agenda"><img border="0" src=<?=$sRandImage2?> width="163" height="121"></a></td><td></td></tr>
			<tr><td colspan="3"></td></tr>
			</table>
			<div class="smalltext" style="display:block;width:163px;margin-left:20px;text-align:center;"><?=$sRandComment2?></div>
			
		</td></tr>
		<tr><td>
			<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
		new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 4,
  interval: 6000,
  width: 200,
  height: 300,
  theme: {
    shell: {
      background: '#333333',
      color: '#ffffff'
    },
    tweets: {
      background: '#000000',
      color: '#ffffff',
      links: '#ebe007'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    hashtags: true,
    timestamp: true,
    avatars: false,
    behavior: 'all'
  }
}).render().setUser('improcite').start();
</script>	
		</td></tr>
		</table>
	</td></tr>
	</table>
	
