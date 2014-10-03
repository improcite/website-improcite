
<?
if ($_SERVER['SERVER_ADDR'] == "127.0.0.1")
{
	?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAATxJOcliJacUltDs1jjDSRRSz2vH4xAFjq6tTeuPblkbUWrkp1RSLKhhSQd_zukLo73lRzoagbn89FQ" type="text/javascript"></script>
	<?
} else
{
	?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyBUg611_V3i8TVw0PYvieV2OR2ylThdDb4" type="text/javascript"></script>
	<?
}
?>

<script type="text/javascript">
var geocoder;
var map;
    function load()
    {
      if (GBrowserIsCompatible())
      {
      	map = new GMap2(document.getElementById("map"));
		geocoder = new GClientGeocoder();

		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());

        
		//map.openInfoWindow(map.getCenter(),
        //           document.createTextNode("Ici !"));
      }
    }
    
function showAddress(title, address) {
  geocoder.getLatLng(
    address,
    function(point)
    {
      if (!point)
      {
      	// not found...
      	showAddress(title, "France");
      }
      else
      {
        map.setCenter(point, 15);
        var marker = new GMarker(point);
        map.addOverlay(marker);
        marker.openInfoWindowHtml('<font color=black>'+title+'</font>');
      }
    }
  );
}
</script>
<style>
#map { text-color: black; }
</style>
<?
# Recuperation de l'id par la methode GET
$id = $_GET["id"];

# Si un id a ete precise on affiche le plan
# Sinon c'est la liste qu'on affiche

if (isset ( $id ))
{
	# la variable $id est remplie. Recherche de la fiche du comedien.
	$requete_lieu = @mysql_query ( "SELECT * FROM $t_lieu WHERE id=$id" ) ;

	if ( $resultat_lieu = @mysql_fetch_array ( $requete_lieu ) ) 
	{			
		# Une fiche a ete trouvee -> Recuperation des informations
		$nom = @affiche_texte ( $resultat_lieu[ "nom" ] ) ;
		$adresse = @affiche_texte ( $resultat_lieu[ "adresse" ] );
		if ($resultat_lieu[ "adresse2" ])
		{
			$adresse .= "<br><br> (".affiche_texte ( $resultat_lieu[ "adresse2" ] ).")";
		}
			
		# Liberation de la memoire MySQL
		@mysql_free_result( $resultat_lieu ) ;

		# Plan
		$plan = "$sPhotoLieuRelDir$id.gif" ;

		echo "<h1>$nom</h1>\n" ;
		
		echo "<p><span class=\"intitules\">Adresse&nbsp;:</span> <br />$adresse</p>\n" ;
		
		function cleanchars($msg)
		{
			$msg = str_replace("\r", " ", $msg);			
			$msg = str_replace("\n", " ", $msg);			
		
			$msg = str_replace("<br />", " ", $msg);
			$msg = str_replace("<br />", " ", $msg);
			$msg = strip_tags($msg);
			$msg = str_replace("\"", "", $msg);
			$msg = str_replace("'", " ", $msg);
			if ($_SERVER['SERVER_ADDR'] == "127.0.0.1")
			{
				$msg = utf8_decode($msg);
			}
			$msg = str_replace("&Atilde;&copy;", "e", $msg);
			$msg = str_replace("&Atilde;&uml;", "e", $msg);
			$msg = str_replace("&Atilde;&ordf;", "e", $msg);
			$msg = str_replace("&Atilde;&laquo;", "e", $msg);
			$msg = str_replace("&Atilde;&nbsp;", "a", $msg);
			$msg = str_replace("&Atilde;&curren;", "a", $msg);
			$msg = str_replace("&Atilde;&cent;", "a", $msg);
			$msg = str_replace("&Atilde;&sup1;", "u", $msg);
			$msg = str_replace("&Atilde;&raquo;", "u", $msg);
			$msg = str_replace("&Atilde;&frac14;", "u", $msg);
			$msg = str_replace("&Atilde;&acute;", "o", $msg);
			$msg = str_replace("&Atilde;&para;", "o", $msg);
			$msg = str_replace("&Atilde;&reg;", "i", $msg);
			$msg = str_replace("&Atilde;&macr;", "i", $msg);
			$msg = str_replace("&Atilde;&sect;", "c", $msg);
			
			$msg = html_entity_decode($msg);
			return $msg;
		}

		?><center><div id="map" style="text-color: black;width: 600px; height: 500px"></div></center>
		<script type="text/javascript">load();</script><?
		
		?>
		<script type="text/javascript">showAddress("<?="<u>".$nom."</u><br>".cleanchars($adresse)?>", "<?=cleanchars($resultat_lieu[ "adresse" ])?>");</script>
		<?
		
		/*
		if ( file_exists( $plan ) )
		{
			echo "<div style=\"text-align: center\">\n";
			# Si la photo existe on l'affiche
			echo "<img class=\"plan\" src=\"$plan\" alt=\"Plan $nom\" title=\"$nom\" />\n" ;
			echo "</div>\n" ;
		}
		*/
	} 
	else
	{
		# La fiche n'a pas ete trouvee
		echo "<h1>Le lieu demand&eacute; est introuvable</h1>\n" ;
	}
}
else
{
	# On affiche le tableau de tous les lieux

	?><h1>Les lieux o&ugrave; croiser Improcit&eacute;</h1><?
		
	$requete_tous_lieux = @mysql_query ( "SELECT * FROM $t_lieu ORDER BY nom" );
	
	# Boucle sur chaque resultat
	while ( $resultat_tous_lieux = @mysql_fetch_array ( $requete_tous_lieux ) )
	{
		$id = $resultat_tous_lieux[ "id" ];
		$nom = $resultat_tous_lieux[ "nom" ];

		echo "<p>$nom (<a href=\"?p=lieux&id=$id\" title=\"Voir le plan\">voir le plan</a>)</p>\n";
	}

	# Liberation de la memoire MySQL
	@mysql_free_result ( $requete_tous_lieux ) ;
}

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
