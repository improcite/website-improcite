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
	$recrutement_resultat = @mysql_query($recrutement_requete);

	$recrutement_resultat = mysql_query($recrutement_sql) or die('Erreur SQL !<br />'.$recrutement_sql.'<br />'.mysql_error());

	$nb_inscrits = @mysql_num_rows($recrutement_sql);

	if ($nb_inscrits = 0)
	{
			echo "<p>Personne n'est encore inscrit au recrutement ... :'-(</p>" ;
	}
	else
	{
	// En-tête de la table
	?>
		
	<div class='table-responsive'>
		<table class='table table-striped'>
			<thead>
				<tr>
					<th>Nom</th>
					<th>Téléphone</th>
					<th>E-mail</th>					
					<th>Adresse</th>
					<th>Source</th>
					<th>Experiencev</th>
					<th>Envie</th>
					<th>Disponibilite</th>
					<th>Date</th>
					<?php 	if(isPrintMode() == true) echo "<th>Commentaire</th>"; ?>
				</tr>
			</thead>
			<tbody>

	<?php	

		// Contenu
		while ($row = mysql_fetch_array($recrutement_resultat, MYSQL_ASSOC)) {
   	//		printf("ID : %s  Nom : %s", $row["nom"], $row["prenom"]);

			echo "<tr>";
			echo "<td>".$row["nom"]." ".$row["prenom"]."</td>";
			echo "<td>".$row["telephone"]."</td>";
			echo "<td>".$row["mail"]."</td>";
			echo "<td>".$row["adresse"]."</td>";
			echo "<td>".$row["source"]."</td>";
			echo "<td>".$row["experience"]."</td>";
			echo "<td>".$row["envie"]."</td>";
			echo "<td>".$row["disponibilite"]."</td>";
			echo "<td>".$row["date"]."</td>";
			if(isPrintMode() == true) echo "<th>&emsp;&emsp;&emsp;</th>";
			echo "</tr>";

		}

	?>
			</tbody>
		</table>
	</div>

	<?php





		
	?>


	<?php

	}
	mysql_free_result($inscrits);
}

DisplayPrintButton();
# Affichage du pied de page
@include ( "pied.php" ) ;

?>
