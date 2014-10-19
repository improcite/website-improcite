<?php

#====================================================================
# Credits du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

$CURRENT_MENU_ITEM = "membres";

include ( "tete.php" ) ;

if ( ! $connexion || ! $db )
{
	# La connexion a MySQL a echoue, affichage d'un message d'erreur comprehensible
	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
	die();
}

if (fxUserHasRight("admin"))
{
	$mr = getp("modright");
	$usr = getp("user");
	if ($mr  &&  $usr)
	{
		global $aUserRights;
		$r = fxQuerySingleValue("SELECT rights FROM impro_comediens WHERE id = ?", array($usr));
		if (strpos($r, $mr) !== false)
		{
			$r = str_replace($mr, "", $r);
		}
		else
		{
			$r .= ";".$mr;
		}
		$r = str_replace(";;", ";", $r);
		$r = trim($r, ";");
		fxQuery("UPDATE impro_comediens SET rights = ? WHERE id = ?", array($r, $usr));
	}
}	


# MySQL est disponible, on continue !
# Ouverture du corps de la page

echo "<div id=\"corps\">\n" ;

echo "<h1>Liste des membres</h1>\n" ;

# On determine la saison
$saison = getp("saison", 1 << $iCurrentSaisonNumber);

echo "<form method=\"get\" role='form'>\n";
echo "<div class='text-center'>\n";
echo "<select name=\"saison\" onChange=\"this.form.submit()\" class=\"form-control text-center\">\n";
for($i=0;$i<=$iCurrentSaisonNumber;$i++)
{
	echo "<option value=\"".(1 << $i)."\"";
	if ($saison == 1 << $i) {echo "selected ";}
	echo ">Saison ".(2004+$i)."-".(2005+$i)."</option>\n";
}
echo "</select>\n";
echo "</div>\n";
echo "</form>\n";

# On determine le filtre de la requete SQL
$filtresql = "saison & ".($saison)." <> 0";
$requete_membres = mysql_query ( "SELECT * FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;

$nb_membres = @mysql_num_rows( $requete_membres ) ;

if ( $nb_membres > 0 )
{
	echo "<div class='row'>\n";

	for ( $i = 0 ; $i < $nb_membres ; $i++ )
	{
		$id = @mysql_result( $requete_membres , $i , "id" ) ;
		$nom = @mysql_result( $requete_membres , $i , "nom" ) ;
		$prenom = @mysql_result( $requete_membres , $i , "prenom" ) ;
		$email = @mysql_result( $requete_membres , $i , "email" ) ;
		$portable = @mysql_result( $requete_membres , $i , "portable" ) ;
		$adresse = @mysql_result( $requete_membres , $i , "adresse" ) ;
		$jour = @mysql_result( $requete_membres , $i , "jour" ) ;
		$mois = @mysql_result( $requete_membres , $i , "mois" ) ;
		$annee = @mysql_result( $requete_membres , $i , "annee" ) ;
		$rights = @mysql_result( $requete_membres , $i , "rights" ) ;

		echo "<div class='col-md-6'>\n";
		echo "<h2>$prenom $nom</h2>\n" ;
		
		$photo = "../photos/comediens/$saison/$id.jpg";
		if (!file_exists($photo)) { $photo = "../photos/comediens/$id.jpg"; }
		if (!file_exists($photo)) { $photo = "../photos/comediens/defaut.jpg"; }

		echo "<div class='row'>\n";
		echo "<div class='col-sm-4'>\n";
		echo "<img  class='img-thumbnail center-block' src=\"$photo\" alt=\"$prenom $nom\">";
		echo "</div>\n";
		echo "<div class='col-sm-8'>\n";
		echo "<ul class='list-group'>\n";
		echo "<li class='list-group-item'><i class='glyphicon glyphicon-envelope'></i> ".@affiche_texte($email)."</li>\n";
		echo "<li class='list-group-item'><i class='glyphicon glyphicon-user'></i> $jour/$mois/$annee</li>\n";
		echo "<li class='list-group-item'><i class='glyphicon glyphicon-earphone'></i> $portable</li>\n";
		echo "<li class='list-group-item'><i class='glyphicon glyphicon-home'></i> ".@affiche_texte($adresse)."</li>\n";
		echo "</ul>\n";
		
		if (fxUserHasRight("admin"))
		{
			foreach(fxGetExistingRights() as $sRightId=>$sRightLib)
			{
				$bCheck = false;
				foreach(explode(";", $rights) as $v)
				{
					if ($v == $sRightId)
					{
						$bCheck = true;
						break;
					}
				}
				?>
				<form style="display:inline" action="membres.php" method="post" role="form">
				<input type="hidden" name="modright" value="<?=$sRightId?>">
				<input type="hidden" name="user" value="<?=$id?>">
				<input type="checkbox" <?=$bCheck?"CHECKED":""?> onClick="form.submit()"><?=$sRightLib?>
				</form>
				<?
			}
			
			?>
			<a href="infos?id=<?=$id?>"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Edit</a>
			
			<?
			
			
			
		}
		echo "</div>\n";
		echo "</div>\n";
		echo "</div>\n";
	}
	echo "</div>\n";
}
else
{
	echo "<div class='alert alert-warning'>Pas de membres</div>" ;
}

DisplayPrintButton();

# Fermeture du corps de la page
echo "</div>\n" ;

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
