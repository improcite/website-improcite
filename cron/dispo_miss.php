#!/usr/local/bin/php
<?

// ! SET FILE PERMISSIONS TO 700

@require_once ( "../config.inc.php" ) ;
@require_once ( "../fonctions.inc.php" ) ;
@require_once ( "../connexion_mysql.php" ) ;
@require_once ( "../fxDB.php" );

//error_reporting(E_ALL);

// http://improcite.com/work/wip_mat
$urlbase =  str_replace("/cron/dispo_miss.php", "", $_SERVER['SCRIPT_URI']);

$nbmois = 2;
$date_debut = date("YmdHis");
$date_fin = unixToDate(time() + 3600*24*30*$nbmois);

//$date_debut_saison = date("YmdHis", mktime(0, 0, 0, 8, 1, 2004+$iCurrentSaisonNumber)) ;

	
$sql = "SELECT c.id as cid, c.email, e.Date as edate, e.id as eid, ce.nom as cenom, l.nom as lnom "
				. " FROM impro_comediens c, impro_evenements e, impro_categories_evenements ce, impro_lieux as l "
				. " WHERE "
				. " NOT EXISTS (SELECT * FROM impro_dispo d WHERE d.id_spectacle = e.id AND d.id_personne = c.id)"
				. " AND e.categorie = ce.id"
				. " AND e.lieu = l.id"
				. " AND c.notif_email = 1"
				. " AND ce.publique = 1"
				. " AND e.date > '".$date_debut."'"
				. " AND e.date < '".$date_fin."'"
				. " AND c.saison & ". (1 << $iCurrentSaisonNumber) ." <> 0"
				. " ORDER BY c.email"
				;
				
				
$q = fxQuery($sql);

$s = getp("send");


function sendml($email, $ml)
{
	global $urlbase;
	
	//if($email != "matfrem@gmail.com") return;
	
	$ml = "Yop !<br/>"
		. "Tu as des spectacles dans les deux mois à venir dont tu n'as pas rempli les dispos.<br/>"
		. $ml
		. "Tu peux cliquer ci-dessus pour accéder à l'espace membre.<br/>"
		. "<br/>"
		. "<br/>"
		. "Tu peux désactiver ces notifications dans l'<a href=".$urlbase."/membres/infos.php>espace membre</a>, sur la page profil.<br/>"
		;
		
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: Improcite <contact@improcite.com>' . "\r\n";
	//$headers .= 'Cc: myboss@example.com' . "\r\n";

	mail($email, "Dispos Impro", $ml, $headers);		
	
	echo "------------------"."<br/>";
	echo $email."<br/>";
	echo $ml;
	echo "------------------"."<br/>";
	echo "<br/>";


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

	$ml .= "<a href=".$urlbase."/membres/dispos2.php?event=".$row['eid'].">".$row['cenom']." - ".affiche_date($row['edate'])." - ".$row['lnom']."</a><br/>";
}

if($ml && $email)
{
	sendml($email, $ml);
}







//


?>