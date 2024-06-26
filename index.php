<?php
# Chargement de la configuration
@require_once ( "config.inc.php" ) ;

/* Messages d'erreur */
error_reporting(0);
if($debug) error_reporting(E_ALL);
# Chargement des fonctions
@require_once ( "fonctions.inc.php" ) ;
# Lancement de la connexion MySQL
@require_once ( "connexion_mysql.php" ) ;
@require_once ( "fxDB.php" );

fix_magic_quotes();

$promo_mode = false;

$sMailTo = "document.location='mai'+'lto:'+'contact'+'@'+'improcit'+'e.c'+'om';";

// Choix de la page@
$p = isset($_GET['p']) ? $_GET['p'] : "welcome";
// Protection des acces
$sPage = "pages/" . preg_replace("[^a-z]", "", $p) . ".php";
if (file_exists($sPage) == false)
{
	header("Location: /?p=notfound");
	die();
}

# Verification de la disponibilite de MySQL
if ( ! $connexion || ! $db ) {
	# La connexion a MySQL a echoue, affichage d'un message d'erreur comprehensible
	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
	break;
}
else
{
	$sRandImage = $sPhotoRelDir."defaut.jpg";
	# MySQL est disponible, on continue !
	// Trouver une photo de comédien à afficher parmi la saison actuelle
	$req_comediens =  mysql_query("SELECT id FROM $table_comediens WHERE (saison & ".(1<<$iCurrentSaisonNumber).") <> 0"); 
	$array_comediens = array();

	while ( $row_comediens = @mysql_fetch_array( $req_comediens ) ) {
		array_push( $array_comediens , $row_comediens['id'] );
	}
	$random_comediens = array_rand ( $array_comediens );
	$sRandComedienId = $array_comediens[$random_comediens ];
	if (file_exists($sPhotoRelDir. $sRandComedienId.".jpg"))
	{
		$sRandImage = $sPhotoRelDir. $sRandComedienId.".jpg";
	}
	if (file_exists($sPhotoRelDir. $currentSaisonBit . "/" . $sRandComedienId.".jpg"))
	{
		$sRandImage = $sPhotoRelDir. $currentSaisonBit . "/" . $sRandComedienId.".jpg";
	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>Improcité : troupe d'improvisation théâtrale de Lyon et Villeurbanne</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Generator" content="vi, metapad">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="window-target" content="_top">
	<meta name="Description" content="Improcité, troupe d'improvisation théâtrale est heureuse de vous accueillir ! Nous proposons des spectacles sur Lyon et Villeurbanne, au CCO, Trokson, Ninkasi... Vous aimez les émotions, le rire et les surprises ? Venez nous voir notre prochain spectacle !">
	<meta name="Keywords" content="improvisation, Lyon, spectacle, sortie, divertissement, Improcité, improvisation théâtrale, Villeurbanne, théâtre, CCO, Trokson, sortie, humour, Ninkasi">
	<meta name="Copyright" content="Improcité">
	<meta name="Subject" content="Improcité - improvisation théâtrale à Lyon et Villeurbanne">
	<meta name="Robots" content="index,follow">
	<meta name="Revisit-after" content="15 days">
	<meta name="Rating" content="general">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script> 	
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="js/improcite.js"></script>
	
	<link href="css/improcite.css" rel="stylesheet" type="text/css" />
	<link href="css/hover-min.css" rel="stylesheet" type="text/css" />
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

	<link rel="icon" type="image/png" href="favicon-improcite-fond.png">
	<link rel="shortcut icon" type="image/png" href="favicon-improcite-fond.png">
</head>
<body>
<div class="container">
<div id="page">

	<img src="images/photo-header.png" class="img-responsive center-block" />

	<a name="apage" name="apage"></a>

	<div id="menu">
	
		<? $aMenuItems = array(
			"recrutement" => "On recrute !"
			, "impro" => "L'impro"
			, "agenda" => "L'agenda"
			, "comediens" => "Comédiens"
			, "contact" => "Contact"
		); 
		?>
		<? $aMenuIcons = array(
			"recrutement" => "star"
			, "impro" => "info-circle"
			, "agenda" => "calendar"
			, "comediens" => "users"
			, "contact" => "envelope"
		); 
		?>
	
		<nav class="navbar navbar-inverse" role="navigation">
		<div class="container-fluid">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand hvr-bounce-in" href="?p=welcome#apage"><i class="fa fa-home"></i>  Accueil</a>
		</div>
		<div class="navbar-collapse collapse">

		<ul class="nav navbar-nav">
		<? foreach($aMenuItems as $k => $v) { ?>
			<li role="presentation" class="<?=(($k==$p)?'active':'')?> hvr-bounce-in"><a href="?p=<?=$k?>#apage"><i class="fa fa-<?=$aMenuIcons[$k]?>"></i> <?=$v?></a></li>
		<? } ?>
		</ul>

		<ul class="nav navbar-nav navbar-right">
		<li><a href="https://www.facebook.com/improcite"><i class="fa fa-facebook"></i></a></li>
		<li><a href="https://www.instagram.com/improcite/"><i class="fa fa-instagram"></i></a></li>
		<li><a href="https://www.twitter.com/improcite"><i class="fa fa-twitter"></i></a></li>
		</ul>
		</div>
		</div>	
	</div>  <!-- menu -->
  
	<div id="corps">
	
		<div id="corps_content">
			<?php
			if (file_exists($sPage))
			{
				include($sPage);
			}
			else
			{
				header("HTTP/1.0 404 Not Found");
				echo "<div id=\"alerte\">La page n'est pas disponible. Merci de r&eacute;essayer plus tard.</div>\n";
			}
			?>
		</div> <!-- corps_content-->
	</div><!-- corps -->
</div> <!-- page -->

	<div id="footer">
	<div class="row">
		<div class="text-ceneter">
		<a role="button" class="btn btn-danger btn-lg" href="/membres/"><i class="fa fa-user-secret"></i> Espace membres</a>
		</div> 
	</div>
	</div> <!-- footer -->

</div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-6584404-2']);
  _gaq.push(['_setDomainName', 'improcite.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
