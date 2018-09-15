<?

$CURRENT_MENU_ITEM = "bdd";
include ( "tete.php" );
include ( "../fxFields.php" );

@session_start();

fxFieldsInit(isset($_GET['tab']) &&  $_GET['tab'] != "sql");

//---------------------------------------------------------------------------
// Identifcation 'espace membre' nécessaire
//---------------------------------------------------------------------------
if (!$_SESSION[ "id_impro_membre" ])
{
	echo "Identification membre nécessaire.";
	die(0);
}

//---------------------------------------------------------------------------
// Récup des droits
//---------------------------------------------------------------------------
$bIsAdmin = fxUserHasRight("admin");
$bIsSelectionneur = fxUserHasRight("selection");
$bIsComArtistic = fxUserHasRight("artistik");

//---------------------------------------------------------------------------

//$data = file_get_contents("admin_bdd.php");
//$data = preg_replace('~\\$aPreFill\\[(.*?)\\]~is', 'fxPreFill($1)', $data);
//$f = fopen("out.txt", "wt+");fwrite($f, $data);fclose($f);

//---------------------------------------------------------------------------

function fxDispTable($table)
{
	fxDispRequest("SELECT * FROM $table ORDER BY id DESC", "tbl_name=$table&do=delete", "tbl_name=$table&do=edit" );
}

fix_magic_quotes();


// constante
$iSaisonEnCours = 1 ;

// Style de la page
?>
<!-- <style>
	table { font-family: Tahoma; font-size: 10pt; }
	h1 { text-align:center;background-color:#EEEEEE; color:black; font-size: 150%; border:1px solid #AAAAAA; }
	input, textarea { color:black; background-color:#FFFFEE; border: 1px solid black; font-family: Tahoma; font-size: 10pt; }
	input[type="submit"] { color:white; background-color:#888; }
</style> -->

<?
//---------------------------------------------------------------------------
// Lecture des paramètres envoyés à la page
//---------------------------------------------------------------------------
// Contrcution "a la mano" du champ "fld_joueurs"
if (getp("tbl_name") == $t_eve)
{
	$_REQUEST["fld_joueurs"] = implode(";", array(getp("fld_j1"),getp("fld_j2"),getp("fld_j3"),getp("fld_j4"),getp("fld_j5"),getp("fld_j6")));
	for($i=0;$i<=6;$i++) { unset($_REQUEST["fld_j$i"]);unset($_POST["fld_j$i"]);unset($_GET["fld_j$i"]); }
}

fxHandleRequests();

$tab = getp("tab");
if (!$tab) $tab = $fxH_tbl_name;
if (!$tab) $tab = "SQL";





//---------------------------------------------------------------------------
// Définition des données
//---------------------------------------------------------------------------

	$aJoueurs = array_values(array_filter(explode(";", fxPreFill('joueurs'))));

	$aColumnData = 
		array(
		"impro_news"=>array(
			"table"=>"impro_news",
			"name"=>"News",
			"fields"=>array(
				array("Texte", "memo", "texte", ""),
				array("Date", "date", "date", date("YmdHis")),
				array("Activer", "check", "active", 1)
				)
			)
		,
		$table_comediens=>array(
			"table"=>$table_comediens,
			"name"=>"Comédiens",
			"listrequest" => "SELECT id, nom, prenom, surnom, email, portable, adresse, (((saison & $currentSaisonBit) >> $iCurrentSaisonNumber) * (2005 + $iCurrentSaisonNumber)) as annee FROM {$table_comediens} ORDER BY annee DESC, Nom",
			"fields"=>array(
				array("Login", "text", "login", ""),
				array("Nom", "text", "nom", ""),
				array("Prénom", "text", "prenom", ""),
				array("Email", "text", "email", ""),
				array("Portable", "text", "portable", ""),
				array("Saison", "bitfield|".$saisonAdminString, "saison", 1 << $iSaisonEnCours)
				)
			)
		,
		$t_eve=>array(
			"table"=>$t_eve,
			"name"=>"Événements",
			"listrequest" => "SELECT {$t_eve}.id as id, {$t_eve}.date as date, impro_categories_evenements.nom as categorie, impro_lieux.nom as lieu, {$t_eve}.commentaire as commentaire, tarif FROM {$t_eve}, impro_lieux, impro_categories_evenements WHERE impro_lieux.id = {$t_eve}.lieu AND impro_categories_evenements.id = {$t_eve}.categorie ORDER BY date DESC",
			"fields"=>array(
				array("Type", "otherlist|impro_categories_evenements|id|nom", "categorie", ""),
				array("Date", "date", "date", date("YmdHis")),
				array("Commentaire", "memo", "commentaire", ""),
				array("Lieu", "otherlist|impro_lieux|id|nom", "lieu", ""),
				array("Prix", "text", "tarif", ""),
				array("Nombre de places", "text", "places", ""),
				array("Joueur 1", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "j1", isset($aJoueurs[0])?$aJoueurs[0]:"", $bIsSelectionneur|$bIsAdmin),
				array("Joueur 2", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "j2", isset($aJoueurs[1])?$aJoueurs[1]:"", $bIsSelectionneur|$bIsAdmin),
				array("Joueur 3", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "j3", isset($aJoueurs[2])?$aJoueurs[2]:"", $bIsSelectionneur|$bIsAdmin),
				array("Joueur 4", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "j4", isset($aJoueurs[3])?$aJoueurs[3]:"", $bIsSelectionneur|$bIsAdmin),
				array("Joueur 5", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "j5", isset($aJoueurs[4])?$aJoueurs[4]:"", $bIsSelectionneur|$bIsAdmin),
				array("Joueur 6", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "j6", isset($aJoueurs[5])?$aJoueurs[5]:"", $bIsSelectionneur|$bIsAdmin),
				array("Coach", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "coach", "", $bIsSelectionneur|$bIsAdmin),
				array("MC", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "mc", "", $bIsSelectionneur|$bIsAdmin),
				array("Arbitre", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "arbitre", "", $bIsSelectionneur|$bIsAdmin),
				array("Régisseur", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "regisseur", "", $bIsSelectionneur|$bIsAdmin),
				array("Caisse", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "caisse", "", $bIsSelectionneur|$bIsAdmin),
				array("Catering", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "catering", "", $bIsSelectionneur|$bIsAdmin),
				array("Ovs", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "ovs", "", $bIsSelectionneur|$bIsAdmin)
				)
			)
		,
		$t_lieu=>array(
			"table"=>$t_lieu,
			"name"=>"Lieux",
			"fields"=>array(
				array("Nom", "text", "nom", ""),
				array("Adresse|(pour Google Maps)", "text", "adresse", ""),
				array("Adresse|(complément texte)", "text", "adresse2", "")
				)
			)
		,
		$t_cat=>array(
			"table"=>$t_cat,
			"name"=>"Catégories",
			"listrequest" => "SELECT id, nom, description, publique FROM {$t_cat} ORDER BY nom",
			"fields"=>array(
				array("Nom", "text", "nom", ""),
				array("Description", "memo", "description", ""),
				array("Visible sur le site", "check", "publique", ""),
				array("Couleur", "text", "couleur", "orange")
				)
			)	
		,
		"impro_liens"=>array(
			"table"=>"impro_liens",
			"name"=>"Liens",
			"listrequest" => "SELECT id, date, nom, lien, description FROM impro_liens ORDER BY date DESC",
			"fields"=>array(
				array("Créateur", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "id_createur", ""),
				array("Date", "date", "date", date("YmdHis")),
				array("Nom textuel", "text", "nom", ""),
				array("Lien", "text", "lien", ""),
				array("Description", "memo", "description", "")
				)
			)	
		,
		$t_omerta=>array(
			"table"=>"$t_omerta",
			"name"=>"Omerta",
			#"listrequest" => "SELECT id_omerta, id_comedien, nom, surnom, description FROM $t_omerta",
			"fields"=>array(
				array("Comédien", "otherlist|$table_comediens|id|CONCAT(nom,' ',prenom)", "id_comedien", ""),
				array("Nom", "text", "nom", ""),
				array("Surnom", "text", "surnom", ""),
				array("Description", "memo", "description", ""),
				)
			)	
		,
/*		$table_fanclub=>array(
			"table"=>$table_fanclub,
			"name"=>"Fan club",
			"fields"=>array(
				array("Surnom", "text", "surnom", ""),
				array("Qui c'est?", "text", "qui", ""),
				array("Fonction", "text", "fonction", ""),
				array("Qualité", "text", "qualite", ""),
				array("Défaut", "text", "defaut", "")
				)
			)
			
		,
		"impro_nimportequoi"=>array(
			"table"=>"impro_nimportequoi",
			"name"=>"Nimp'",
			"fields"=>array(
				array("Type", "list|boulettes,phrases", "categorie", ""),
				array("Titre", "text", "titre", ""),
				array("Description", "memo", "description", ""),
				array("Rang|(0-10)", "text", "rang", ""),
				)
			)	
		,
		$table_intervenants=>array(
			"table"=>$table_intervenants,
			"name"=>"Intervenants",
			"fields"=>array(
				array("Nom", "text", "nom", ""),
				array("Prénom", "text", "prenom", ""),
				array("Description", "memo", "description", ""),
				array("Au travail", "memo", "travail", ""),
				array("Sa phrase", "memo", "phrase", ""),
				array("Année de dours", "text", "annee", ""),
				)
			) */	
		);
		

	
//---------------------------------------------------------------------------
// Calcul des tabs
//---------------------------------------------------------------------------

$aTabs = array();
foreach($aColumnData as $k=>$v)
{
	if ($k == "impro_news" 			&&  (!$bIsAdmin)) continue;
	if ($k == $table_comediens		&&  (!$bIsAdmin)) continue;
	if ($k == $t_eve			&&  (!$bIsAdmin)) continue;
	if ($k == $t_cat			&&  (!$bIsAdmin)) continue;
	if ($k == $t_lieu			&&  (!$bIsAdmin)) continue;
	if ($k == "impro_liens"			&&  (!$bIsAdmin)) continue;
	if ($k == $t_omerta			&&  (!$bIsAdmin)) continue;
	//if ($k == "impro_nimportequoi"	&&  (!$bIsAdmin)) continue;
	//"impro_liens"
	//$t_eve
	//$table_fanclub
	//$table_intervenants
	$aTabs[$k] = $v["name"];
}
$aTabs["sql"] = "SQL";
	
	
//---------------------------------------------------------------------------
// Affichage des onglets
//---------------------------------------------------------------------------

if (!isPrintMode())
{
	?>
	<br/>
	<div class="menubar">
	  <ul class="nav nav-pills">
		<? foreach($aTabs as $k=>$v) { ?>
		<li class="<?=(($k==$tab)?'active':'')?>"><a href="?tab=<?=$k?>"><?=$v?></a></li>
		<? } ?>
	  </ul> <!-- /tabs -->
	</div> <!-- /example -->	
	<?

	/*foreach($aTabs as $k=>$v)
	{
		?><a href=?tab=<?=$k?> style="border:1px solid white;text-decoration:none;margin:3px;padding-left:5px;padding-right:5px;<?
		if ($k==$tab) echo "padding-bottom:1px;background-color:#000000;"; else echo "background-color:#444444;";
		?>border-bottom:0px;"><?=$v?></a> <?
	}*/
}
?><div style="font-family: Tahoma; width: auto; font-size: 10pt;border:1px solid white;padding:2px;">
<h1><?=(isset($aTabs[$tab]) ? $aTabs[$tab] : '')?></h1>

<?
//---------------------------------------------------------------------------
// ONGLET REQUETE SQL
//---------------------------------------------------------------------------

if ($tab == "sql")
{
	if (!$bIsAdmin) { echo "Vous devez être admin"; exit(0); }
	
	?>
	<a href="?tab=sql&do=sql&query=SHOW TABLES">Tables</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM impro_news">News</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM <?=$table_comediens?>">Comediens</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM <?=$t_eve?>">Evenements</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM <?=$t_lieu?>">Lieux</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM <?=$t_cat?>">Categories</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM impro_liens">Liens</a>
<!--	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM <?=$table_fanclub?>">Tamere</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM <?=$table_intervenants?>">Intervenants</a>
	<a href="?tab=sql&do=sql&query=SHOW FIELDS FROM impro_nimportequoi">Nimp'</a> */
-->
	<form method="post">
	<input type=hidden name="do" value="sql">
	<input type=hidden name="tab" value="<?=$tab?>">
	<textarea cols="80" rows="10" name="query" value=""><?=getp("query")?></textarea>
	<br><input type="submit" value="Exécuter!">
	</form>
	<?
	if ($fxH_do == "sql"  &&  $_REQUEST["query"])
	{
		fxDispRequest($_REQUEST["query"]);
		echo "<hr>";
		$sErr = mysql_error();
		if ($sErr)
			echo "Erreur:$sErr<br>";
		else
			echo "Succès !<br>";
	}
}


if (isset($aColumnData[$tab]))
{
	$aData = $aColumnData[$tab];
	fxDispFields($aData);
	
	if (isset($aData['listrequest']))
	{
		fxDispRequest($aData['listrequest'], "tbl_name=".$aData['table']."&do=delete", "tbl_name=".$aData['table']."&do=edit" );
	}
	else
	{
		fxDispTable($aData['table']);
	}
}
DisplayPrintButton();
?>
</div>
