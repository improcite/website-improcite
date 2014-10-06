<?php

#====================================================================
# Page d'identification
# 2004 (c) Clement OUDOT
#====================================================================

# Demarrage des sessions
session_start();
session_save_path ('sessions');

# Chargement de la configuration

@require_once ( "../config.inc.php" ) ;

# Chargement des fonctions

@require_once ( "../fonctions.inc.php" ) ;

# Lancement de la connexion MySQL

@include ( "../connexion_mysql.php" ) ;

# XML
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n" ;

# Doctype 
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";

# Ouverture HTML
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n";

# Ouverture HEAD


echo "<head>\n";
echo "<title>Improcite - Espace membres</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n";
echo "<link rel=\"stylesheet\" href=\"../css/improcite2.css\" type=\"text/css\" />\n";
echo "<meta name=\"author\" content=\"Clement OUDOT\" />\n";

# Javascripts

echo "<script type=\"text/javascript\" src=\"../js/scripts.js\"></script>\n" ;

# Fermeture HEAD

echo "</head>\n" ;

# Ouverture BODY

echo "<body>\n";

# Ouverture Maitre

echo "<div id=\"pagemembres\">\n" ;

# Ouverture du corps de la page

$login = getp("login");
$password = getp("password");
$backURL = getp("backURL");
$rememberme = getp("rememberme");

$salt = "blobi123";

$requete_membre = false;
if (isset($_COOKIE['login']) && isset($_COOKIE['md5password']))
{
	$login = $_COOKIE['login'];
	$md5password = $_COOKIE['md5password'];
}
else if($login && $password)
{
	$md5password = md5($salt.$password);
}


if($md5password)
{
	$requete_membre = mysql_query ( "SELECT * FROM $table_comediens WHERE login='$login' AND MD5(CONCAT('$salt', password))='$md5password'" ) ;
	# Recherche du login dans la base

	$nb = @mysql_num_rows ( $requete_membre ) ;
	if ( $nb > 0 )
	{
		$resultat_membre = @mysql_fetch_array ( $requete_membre ) ;

		$id = $resultat_membre[ "id" ] ;
		$surnom = $resultat_membre[ "surnom" ] ;
		$prenom = $resultat_membre[ "prenom" ] ;
		
		echo "<p class=\"titre3\">Bienvenue $surnom&nbsp;!</p>\n" ;
		
		$_SESSION[ "id_impro_membre" ] = $id ;
		$_SESSION[ "prenom_impro_membre" ] = $prenom ;

		echo "<br />\n" ;
		
		echo "<a href=\"index.php\" title=\"Espace membres\"><p class=\"titre\">Clique ici si tu n'entres pas automatiquement dans 1s</p></a>\n" ;
		//echo "<p><span class=\"intitules\">Attention&nbsp;:</span> ton navigateur doit accepter les cookies&nbsp;!</p>\n" ;
		
		if (!$backURL)
		{
			$backURL = "index.php";
		}
		else
		{
			$backURL = base64_decode($backURL);
		}
		
		if (isset($rememberme) && isset($login) && isset($password))
		{
		
			/* Set cookie to last 1 year */
			setcookie('login', $login, time()+60*60*24*365);
			setcookie('md5password', $md5password, time()+60*60*24*365);
		}  			
		
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=$backURL\">";
	}
	else
	{
		setcookie('login', '', time()+60*60*24*365);
		setcookie('md5password', '', time()+60*60*24*365);
	
		echo "<p class=\"titre\">Identifiant ou mot de passe incorrect&nbsp;!</p>\n" ;
		echo "<br />\n" ;
		echo "<a href=\"identification.php\"><p class=\"titre2\">Recommencer l'identification</p></a>\n" ;
		
	}
}
else
{
	# Formulaire d'identification

	?>
	<h1>Espace membres - Identification obligatoire</h1>
	<form method="post" action="identification.php">
	<table>
	<tr><td>Identificant&nbsp;:</td><td><input name="login" type="text" /></td></tr>
	<tr><td>Mot de passe&nbsp;:</td><td><input name="password" type="password" /></td></tr>
	<tr><td>Se rappeler de moi</td><td><input type="checkbox" name="rememberme" value="1"></td></tr>
	</table>
	<input type="submit" value="M'identifier" />
	<input type="hidden" name="backURL" value="<?=$backURL?>" />
	</form>
	<p><a href="../" title="Retour">Revenir au site public</a></p>
	<?

}


# Fermeture du cadre maitre

echo "</div>\n" ;

# Fermeture BODY

echo "</body>\n";

# Fermeture HTML

echo "</html>\n" ;

# Fermeture de la connexion MySQL

if ( $connexion ) {

	# La connexion a MySQL existe, on la ferme

	@mysql_close ( $connexion ) ;

}

?>
