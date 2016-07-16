<?php

#====================================================================
# Credits du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================
include ( "tete.php" ) ;

function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

# Verification de la disponibilite de MySQL
if ( ! $connexion || ! $db )
{
	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
	die();
}

else {

	# MySQL est disponible, on continue !

	$recrutement_sql_update = "";

	$inscrits = json_decode($_POST['inscrits'],true);

	foreach($inscrits as $inscrit)
	{
		$recrutement_sql = "UPDATE impro_recrutement SET mail = '".$inscrit["mail"]."', telephone = '".$inscrit["telephone"]."', selection ='".$inscrit['selection']."' WHERE id = '".$inscrit["id"]."';\n";

		$recrutement_resultat = mysql_query($recrutement_sql) or die('Erreur SQL !<br />'.$recrutement_sql.'<br />'.mysql_error());

	}

}

include ( "pied.php" ) ;

?>
