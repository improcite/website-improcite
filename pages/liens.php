
<h1>Nos liens</h1>
<h2>Improcit&eacute; veut vous faire conna&icirc;tre&nbsp;:</h2>

<?

$requete_liens = fxQuery("SELECT * FROM impro_liens ORDER BY DATE DESC");

# Boucle sur chaque resultat

while ( $resultat_liens = @mysql_fetch_array ( $requete_liens ) ) {

	$id = $resultat_liens[ "id" ] ;
	$lien = $resultat_liens[ "lien" ] ;
	$nom = $resultat_liens[ "nom" ] ;
	$description = affiche_texte ( $resultat_liens[ "description" ] ) ;
		
	# Affichage du surnom

	echo "<h3><a href=\"$lien\" title=\"$nom\">$nom</a></h3>\n" ;
	echo "$description\n" ;
	
	$photo = "photos/liens/$id.jpg";
	if ( file_exists( $photo ) )
	{
		echo "<center><img style=\"margin:10px;\" src=$photo></center>\n";
	}
	
	echo "<br><br>\n";

}

# Liberation de la memoire MySQL

@mysql_free_result ( $requete_liens ) ;

?>
