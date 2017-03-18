#!/usr/bin/env php
<?php

// Do not allow to run this script from outside
if ( isset($_SERVER['REMOTE_ADDR']) ) { return; }

// ! SET FILE PERMISSIONS TO 700

require_once ( __DIR__ . "/../config.inc.php" ) ;
require_once ( __DIR__ . "/../fonctions.inc.php" ) ;
require_once ( __DIR__ . "/../connexion_mysql.php" ) ;
require_once ( __DIR__ . "/../fxDB.php" );

//error_reporting(E_ALL);

$urlbase = "https://www.improcite.com";

$nbmois = 2;
$date_debut = date("YmdHis");
$date_fin = unixToDate(time() + 3600*24*30*$nbmois);

$sql = "SELECT c.id as cid, c.email, e.Date as edate, e.id as eid, ce.nom as cenom, l.nom as lnom "
				. " FROM impro_comediens c, impro_evenements e, impro_categories_evenements ce, impro_lieux as l "
				. " WHERE "
				. " NOT EXISTS (SELECT * FROM impro_dispo d WHERE d.id_spectacle = e.id AND d.id_personne = c.id)"
				. " AND e.categorie = ce.id"
				. " AND e.lieu = l.id"
				. " AND c.notif_email = 1"
				. " AND e.date > '".$date_debut."'"
				. " AND e.date < '".$date_fin."'"
				. " AND c.saison & ". (1 << $iCurrentSaisonNumber) ." <> 0"
				. " ORDER BY c.email"
				;
				
$q = fxQuery($sql);

function sendml($email, $ml)
{
	global $urlbase;
	global $nbmois;
	
	if($email != "clem.oudot@gmail.com") return;
	
	$ml = "<p>Salut !</p>"
		. "<p>Certaines de tes disponibilités n'ont pas été remplies pour les $nbmois prochains mois :</p>"
		. "<ul>$ml</ul>"
		. "<p>Merci de les remplir au plus vite !</p>"
                . "<hr />"
		. "<p><i>Note : tu peux désactiver ces notifications dans l'<a href=".$urlbase."/membres/infos.php>espace membre</a> sur ta page profil.<small></i></p>"
		;

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: Improcité <contact@improcite.com>' . "\r\n";

	mail($email, "[Rappel] Disponibilités non renseignées", $ml, $headers);
	
}

$email = "";
$ml = "";
while($row = fxFetch($q))
{
	if($email != $row['email'])
	{
		if($ml && $email)
		{
			sendml($email, $ml);
			$ml = "";
		}
		$email = $row['email'];
	}

	$ml .= "<li><a href=".$urlbase."/membres/dispos2.php?event=".$row['eid'].">[".$row['cenom']."] ".affiche_date($row['edate'])." - ".$row['lnom']."</a></li>";
}

if($ml && $email)
{
	sendml($email, $ml);
}

?>
