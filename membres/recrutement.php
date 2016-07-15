<?php

#====================================================================
# Credits du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

include ( "tete.php" ) ;

# Verification de la disponibilite de MySQL
if ( ! $connexion || ! $db )
{
	echo "<div id=\"alerte\">La connexion avec la base de donn&eacute;es est indisponible. Merci de r&eacute;essayer plus tard.</div>\n" ;
	die();
}

//TODO $bIsSelectionneur = fxUserHasRight("selection");


else {

	# MySQL est disponible, on continue !

	# Ouverture du corps de la page

	echo "<div id=\"corps\">\n" ;
	echo "<h1>Liste des inscriptions au recrutement</h1>\n" ;

	$date_actuelle = date("YmdHis") ;

	$recrutement_sql = "SELECT * from impro_recrutement ORDER BY date ASC";

	$recrutement_resultat = mysql_query($recrutement_sql) or die('Erreur SQL !<br />'.$recrutement_sql.'<br />'.mysql_error());

	$nb_inscrits = @mysql_num_rows($recrutement_resultat);

	if ($nb_inscrits = 0)
	{
			echo "<p>Personne n'est encore inscrit au recrutement ... :'-(</p>" ;
	}
	else
	{
	?>
		
	<div class='table-responsive'>
		<table id="table"
			   data-height="460"
               data-detail-view="true"
               data-detail-formatter="detailFormatter"
               data-striped = "true"
			   data-sort-name="nom"
               data-sort-order="desc"
               data-click-to-select="true"
               >
			<thead>
				<tr>
            		<th data-field="nom" data-sortable="true">Nom</th>
            		<th data-field="telephone" data-sortable="true">Téléphone</th>
            		<th data-field="mail" data-sortable="true">E-mail</th>
            		<th data-field="adresse" data-sortable="true">Adresse</th>
            		<th data-field="mail" data-sortable="true">Date</th>
            	    <th data-field="state" data-checkbox="true"></th>	
        		</tr>
			</thead>
		</table>
	</div>

	</div>

	<?php

	}
}

DisplayPrintButton();

$nb_inscrits = @mysql_num_rows($recrutement_resultat);

echo "<script>\n";
echo " var data = [";
	
		$counter = 0;

		while ($row = mysql_fetch_array($recrutement_resultat, MYSQL_ASSOC)) {

			echo "{\n";
			echo "\"nom\" : \"".$row["nom"]." ".$row["prenom"]."\",\n";
			echo "\"telephone\" : \"".$row["telephone"]."\",\n";
			echo "\"mail\" : \"".$row["mail"]."\",\n";
			echo "\"adresse\" : \"".$row["adresse"]."\",\n";
			echo "\"date\" : \"".$row["date"]."\",\n";
			echo "\"source\" : \"".$row["source"]."\",\n";
			echo "\"experience\" : \"".$row["experience"]."\",\n";
			echo "\"envie\" : \"".$row["envie"]."\",\n";
			echo "\"disponibilite\" : \"".$row["disponibilite"]."\"\n";			
			echo "}";

			if (++$counter < $nb_inscrits) echo ",\n";
		}

echo "];\n";
?>

$(function () {
    $('#table').bootstrapTable({
        data: data
    });
});
</script>
<script>
    function detailFormatter(index, row) {
        var html = [];
        html.push('<p><b>A connu Improcité :</b><br>' + row['source']);
        html.push('</p><p><b>Son expérience en impro :</b><br>' + row['experience']);
        html.push('</p><p><b>Ses envies :</b><br>' + row['envie']);
        html.push('</p><p><b>Ses disponibilités :</b><br>' + row['disponibilite'] + '</p>');
        return html.join('');
        }
</script>
<?php

mysql_free_result($inscrits);

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
