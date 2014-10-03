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
# 2004-2005 : 1
# 2005-2006 : 2
# 2006-2007 : 4
# 2007-2008 : 8
# 2008-2009 : 16
# 2009-2010 : 32
# 2010-2011 : 64
# 2011-2012 : 128 
# Par defaut : 2004-2005 (1)
# La saison est aussi donnee par le parametre POST saison
$saison = getp("saison", 1 << $iCurrentSaisonNumber);

echo "<form method=\"get\">\n";

echo "<p style=\"text-align: center\">\n";
echo "<select name=\"saison\">\n";
for($i=0;$i<=$iCurrentSaisonNumber;$i++)
{
		echo "<option value=\"".(1 << $i)."\"";
			if ($saison == 1 << $i) {echo "selected ";}
		echo ">Saison ".(2004+$i)."-".(2005+$i)."</option>\n";
}
echo "</select>\n";

echo "<input type=\"submit\" value=\"Afficher\" /></p>\n";

echo "</form>\n";

# On determine le filtre de la requete SQL


$filtresql = "saison & ".($saison)." <> 0";
$requete_membres = mysql_query ( "SELECT * FROM $table_comediens WHERE $filtresql ORDER BY nom" ) ;

$nb_membres = @mysql_num_rows( $requete_membres ) ;

if ( $nb_membres > 0 )
{
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


		echo "<h2>$prenom $nom</h2>\n" ;
		
		$photo = "../photos/comediens/$id.jpg";
		if (!file_exists($photo)) { $photo = "../photos/comediens/defaut.jpg"; }
		?><table><tr><td><?
		echo "<img  class='img-thumbnail' style='width:150px;' src=\"$photo\">";
		?></td><td><div style="margin-left:20px;"><?
		echo "<span class=\"intitules\">Adresse mail&nbsp;:</span> ".@affiche_texte($email)."<br>\n";
		echo "<span class=\"intitules\">Date de naissance&nbsp;:</span> $jour/$mois/$annee<br>\n";
		echo "<span class=\"intitules\">Portable&nbsp;:</span> $portable<br>\n";
		echo "<span class=\"intitules\">Adresse&nbsp;:</span> ".@affiche_texte($adresse)."<br>\n";
		
		if (fxUserHasRight("admin"))
		{
			echo "<p>";		
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
				<form style="display:inline" action="membres.php" method="post">
				<input type="hidden" name="modright" value="<?=$sRightId?>">
				<input type="hidden" name="user" value="<?=$id?>">
				<?=$sRightLib?><input type="checkbox" <?=$bCheck?"CHECKED":""?> onClick="form.submit()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</form>
				<?
			}
			//echo "<p><span class=\"intitules\">Adresse&nbsp;:</span> ".@affiche_texte($adresse)."</p>\n";
			echo "</p>";

		}
		?></div></td></tr></table><?
	}
}
else
{
	echo "<p>Pas de membres</p>" ;
}

# Fermeture du corps de la page
echo "</div>\n" ;

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
