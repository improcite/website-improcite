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

// Choix de la page
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
	<title>ImproCité : La Troupe d'Improvisation Théâtrale de Lyon et Villeurbanne </title>
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
	
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script> 	
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="js/improcite.js"></script>
	
	<link href="css/improcite.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
	<? if (!$promo_mode) { ?>
	<div id="header" style="cursor:pointer" onClick="window.location.href='?';">
			<div id="welcome">Bienvenue sur le site d'<a href=?p=improcite>Improcité</a>, la troupe d'improvisation théâtrale de Lyon et Villeurbanne</div>
	</div> <!-- header -->
	
	<?
	@require_once ( "carousel.inc.php" ) ;
	shuffle($aCaroussel);
	?>
    <div id="home-carousel">
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="6000">
        <ol class="carousel-indicators">
		<? $bf = 1; foreach($aCaroussel as $ix => $k) { ?>
			<li data-target="#carousel-example-generic" data-slide-to="<?=$ix?>" class="<?if($bf) echo 'active';$bf = 0; ?>"></li>
		<? } ?>
		
       </ol>
        <div class="carousel-inner">
		<? $bf = 1; foreach($aCaroussel as $k) { ?>
			  <div class="item <?if($bf) echo 'active';$bf = 0; ?>">
				<img class="carousel-img" src="photos/carousel/<?=$k?>.jpg">
			  </div>
		<? } // class="item active" ?>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev" style="width:30px;">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next" style="width:30px;">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>
    </div>
	
	<div id="menu">
		<a name="apage" name="apage"></a>	
	
		<? $aMenuItems = array(
			 "welcome" => "Accueil"
			, "impro" => "L'impro & nous"
			, "agenda" => "L'agenda"
			, "comediens" => "Comédiens"
			//, "photos" => "Photos"
			, "liens" => "Liens"
			, "contact" => "Contact"
		); ?>
	
		<div class="menubar">
		  <ul class="nav nav-pills">
			<? foreach($aMenuItems as $k => $v) { ?>
			<li class="<?=(($k==$p)?'active':'')?>"><a href="?p=<?=$k?>#apage"><?=$v?></a></li>
			<? } ?>
		  </ul> <!-- /tabs -->
		</div> <!-- /example -->		
		
  </div>  <!-- menu -->
  <? } // promo_mode ?>
  
  
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
		<form action="membres/" method="get"><input type=submit name="sub" value="Espace Membres"></form>		
	</div> <!-- footer -->

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
