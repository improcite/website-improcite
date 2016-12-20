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

?>

<!DOCTYPE html>
<html lang="fr">
<head>
        <title>Improcite - Espace membres</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="../js/improcite.js"></script>
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/smoothness/jquery-ui.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<?php
if (!isPrintMode()) {
        echo "\t<link rel=\"stylesheet\" href=\"../css/improcite2.css\" type=\"text/css\" />\n";
} else {
        echo "\t<link rel=\"stylesheet\" href=\"../css/print.css\" type=\"text/css\" />\n";
}
?>
        <meta name="author" content="Clement OUDOT & Mathieu FREMONT" />
</head>
<body>
	<div class="container">
	<div id="pagemembres" class="panel panel-body">

<?php
# Ouverture du corps de la page

$login = getp("login");
$password = getp("password");
$backURL = getp("backURL");
$rememberme = getp("rememberme");

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
	# Recherche du login dans la base
	$requete_membre = mysql_query( "SELECT * FROM $table_comediens WHERE login='$login' AND password='$md5password' AND saison  & ".($currentSaisonBit)." <> 0") ;

	$nb = @mysql_num_rows ( $requete_membre ) ;
	if ( $nb > 0 )
	{
		$resultat_membre = @mysql_fetch_array ( $requete_membre ) ;

		$id = $resultat_membre[ "id" ] ;
		$surnom = $resultat_membre[ "surnom" ] ;
		$prenom = $resultat_membre[ "prenom" ] ;
		
		echo "<h1>Bienvenue $surnom&nbsp;!</h1>\n" ;
		
		$_SESSION[ "id_impro_membre" ] = $id ;
		$_SESSION[ "prenom_impro_membre" ] = $prenom ;

		echo "<div class=\"text-center\">\n";
		echo "<a href=\"index.php\" class=\"btn btn-primary\" role=\"button\" title=\"Espace membres\">Clique ici si tu n'entres pas automatiquement dans 1s</a>\n" ;
		echo "</div>\n";
		
		if (!$backURL)
		{
			$backURL = "index.php";
		}
		else
		{
			$backURL = base64_decode($backURL);
		}
		
		if ($rememberme && isset($login) && isset($password))
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
	
		echo "<div class=\"alert alert-danger\">Identifiant ou mot de passe incorrect&nbsp;!</div>\n" ;
		echo "<div class=\"text-center\">\n";
		echo "<a href=\"identification.php\" class=\"btn btn-primary\" role=\"button\">Recommencer l'identification</a>\n" ;
		echo "</div>\n";
	}
}
else
{
	# Formulaire d'identification

	?>
	<h1>Espace membres - Identification obligatoire</h1>

	<form method="post" action="identification.php">
	
	<div class="form-group input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
	<input name="login" type="text" class="form-control" placeholder="Identifiant" required />
	</div>

	<div class="form-group input-group">
	<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
	<input name="password" type="password" class="form-control" placeholder="Mot de passe" required />
	</div>

	<div class="checkbox">
	<label for="rememberme">
	<input type="checkbox" id="rememberme" name="rememberme" checked value="1" />
	Se rappeler de moi
	</label>
	</div>

	<input type="hidden" name="backURL" value="<?=$backURL?>" />

	<div class="text-center">
	<button type="submit" class="btn btn-success" >
	M'identifier
	</button>
	</div>

	<hr />

	<div class="text-center">
	<a href="../" title="Retour" class="btn btn-primary" role="button">Revenir au site public</a>
	</div>

	</form>
	<?

}


# Fermeture du cadre maitre

echo "</div>\n" ;
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
