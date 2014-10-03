<?php

# ID OMERTA
$id = $_GET["id"];

if (isset ( $id )) {

	# Fiche OMERTA
	$rqPerso = @mysql_fetch_array(mysql_query ( "SELECT * FROM $t_omerta WHERE id=$id" ));

	echo "<div id=\"perso_omerta\">\n";
	echo "<h1>OMERTA</h1>\n";

	if ( $rqPerso ) {
		$nom = $rqPerso[ "nom" ] ;
		$idc = $rqPerso[ "id_comedien" ] ;
		$surnom = $rqPerso[ "surnom" ] ;
		$description = $rqPerso[ "description" ] ;

		$photo = $sPhotoOmerta.$id.".jpg";
		
		echo "<h2>$nom ($surnom)</h2>\n";
		echo "<p>". affiche_texte($description) ."</p>\n";

		if ( !file_exists( $photo ) ) { $photo = $sPhotoOmerta."default.jpg"; }
		if ( $idc) { echo "<a href=\"index.php?p=comediens&id=$idc\">"; }
		echo "<img class=\"photo_fiche\" src=\"$photo\" alt=\"Photo de $nom\" title=\"$nom\" />" ;
		if ( $idc) { echo "</a>"; }
	}

	echo "</div>\n";
}

else {
	# Description OMERTA
	echo "<div id=\"presentation_omerta\">\n";

	echo "<h1>OMERTA</h1>\n";


	# Description spectacle OMERTA
	$query_omerta_spec = @mysql_query( "SELECT * FROM $t_cat WHERE id=$category_omerta" );
	$count_omerta_spec = @mysql_num_rows( $query_omerta_spec );

	if ( $count_omerta_spec ) {
		$description = @mysql_result( $query_omerta_spec, 0, "description" );

		echo "<img src=\"images/knode2.png\" alt=\"journal\" class=\"logo\"/>\n";
		echo "<p>". affiche_texte($description) ."</p>\n";
	}


	# Liste personnages
	$query_omerta_perso = @mysql_query( "SELECT * FROM $t_omerta ORDER BY nom" );
	$count_omerta_perso = @mysql_num_rows( $query_omerta_perso );

	if ( $count_omerta_perso ) {

		echo "<h2>Les personnages</h2>\n";

		echo "<ul class='comediens'>\n";

		while ($res = mysql_fetch_array ( $query_omerta_perso ) ) {
			$id = $res[ "id" ];
			$nom = $res[ "nom" ];
			$surnom = $res[ "surnom" ];
			$photo = $sPhotoOmerta.$id.".jpg";
			if ( !file_exists( $photo ) ) { $photo = $sPhotoOmerta."default.jpg"; }

			echo "<li><a href=\"?p=omerta&id=$id\" title=\"$nom\">\n";
			echo "<img class=\"photo_comedien\" src=\"$photo\" alt=\"Photo de $nom ($surnom)\" />\n";
			echo "</a></li>\n";

		}

		echo "</ul>\n";

	}

	echo "</div>\n";

}

?>
