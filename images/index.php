<?
# Chargement de la configuration
@require_once ( "config.inc.php" ) ;

# Chargement des fonctions
@require_once ( "fonctions.inc.php" ) ;

# Lancement de la connexion MySQL
@include ( "connexion_mysql.php" ) ;

@include ( "fxDB.php" );

fix_magic_quotes();

$sMailTo = "document.location='mai'+'lto:'+'contact'+'@'+'improcit'+'e.c'+'om';";

function afficher_inscription_newsletter($sEmail = "")
{
	?>
	<form action="http://groups.google.com/group/improcite-infos/boxsubscribe">
	Email&nbsp;: <input type="text" name="email" size="40" value="<?=$sEmail?>">
	<input type=submit name="sub" value="S&#39;inscrire">
	<?
}	

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title>ImproCité : La Troupe d'Improvisation Théâtrale de Lyon et Villeurbanne </title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Generator" content="vi, metapad">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="window-target" content="_top">
	<meta name="Description" content="Improcité, c'est la troupe d'improvisation théâtrale de Lyon et Villeurbanne">
	<meta name="Keywords" content="improvisation, Lyon, spectacle, sortie, divertissement, Improcité, improvisation théâtrale, Villeurbanne, théâtre">
	<meta name="Copyright" content="Improcité">
	<meta name="Subject" content="Improcité - improvisation théâtrale à Lyon et Villeurbanne">
	<meta name="Robots" content="index,follow">
	<meta name="Revisit-after" content="15 days">
	<meta name="Rating" content="general">
	<script type="text/javascript" src="jquery-1.3.2.min.js"></script> 	
	<script type="text/javascript" src="improcite.js"></script> 	
	<link href="improcite.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style></head>
<body bgcolor=#000000>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<table width="1281" height="438" border="0" align="center">
  <tr>
    <th width="1708" height="434" scope="col"><table width="1275" border="0">
      <tr align="left" valign="top">
        <th width="1269" height="381" scope="col"><img src="images/banniere.jpg" width="1264" height="379"></th>
      </tr>
    </table>
      <table width="1167" border="0">
        <tr>
          <th width="1161" height="43" scope="col"><table width="200" border="0" align="center">
            <tr>
              <th height="37" scope="col"><a href="index.php?p=welcome"><img alt="Accueil" src="images/t_accueil.gif" border="0" /></a></th>
              <th scope="col"><a href="index.php?p=agenda"><img alt="Agenda" src="images/t_agenda.gif" border="0" /></a><a href="index.php?p=welcome"></a></th>
              <th scope="col"><a href="index.php?p=comediens"><img alt="Comediens" src="images/t_comediens.gif" border="0" /></a></th>
              <th scope="col"><a href="/coppermine/"><img alt="Photos" src="images/t_photos.gif" border="0" /></a></th>
              <th scope="col"><a href="index.php?p=improcite"><img alt="Improcite" src="images/t_improcite.gif" border="0" /></a></th>
              <th scope="col"><a href="index.php?p=liens"><img alt="Liens" src="images/t_liens.gif" border="0" /></a></th>
              <th scope="col"><a href="index.php?p=contact"><img alt="Contact" src="images/t_contact.gif" border="0" /></a></th>
            </tr>
          </table></th>
        </tr>
    </table></th>
  </tr>
</table>
<table width="1266" border="0">
  <tr>
    <th width="192" height="511" scope="col"><table width="189" height="509" border="0" align="center">
      <tr>
        <th width="183" height="247" scope="col"><p><a href="?p=improcite"><img src="http://perso0.free.fr/cgi-bin/wwwcount.cgi?df=[improcite].dat&amp;dd=caligra&amp;display=counter&amp;ft=0&amp;pad=N" alt="Compteur" /></a></p>
          <p><small><a href="membres/">[membres]</a></small></p></th>
      </tr>
      <tr>
        <td height="229">&nbsp;</td>
      </tr>
    </table></th>
    <th width="1064" scope="col"><div id="corps">
      <?
		
		# Verification de la disponibilite de MySQL
		if ( ! $connexion || ! $db ) {
		
			# La connexion a MySQL a echoue, affichage d'un message d'erreur comprehensible
			echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
		}
		else
		{
			# MySQL est disponible, on continue !
			
			
			// Choix de la page
			$sPage = isset($_GET['p']) ? $_GET['p'] : "welcome";
			
			// Protection des acc&egrave;s
			$sPage = "pages/" . preg_replace("[^a-z]", "", $sPage) . ".php";
			
			if (file_exists($sPage))
			{
				// Inclusion de la sous-page
				include($sPage);
			}
			else
			{
				echo "<div id=\"alerte\">La page n'est pas disponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
			}
		}
		?>
    </div></th>
  </tr>
</table>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6584404-2");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
