<?php

#====================================================================
# Credits du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

# Affichage de la tete de page

include ( "tete.php" ) ;

$viewtoolbar = (!isPrintMode() && (fxUserHasRight('recruteur') || fxUserHasRight('admin'))) ? true : false;

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
	<div id = "alert_placeholder"></div>

	<div class='table-responsive'>
	    <div id="toolbar">
			<?php if($viewtoolbar) echo  "<button id='button' class='btn btn-default'>Enregistrer</button>"; ?>
        </div>
		<table id="table"
			   data-height="460"
               data-detail-view="true"
               data-toolbar="#toolbar"
               data-detail-formatter="detailFormatter"
               data-striped = "true"
			   data-sort-name="nom"
               data-sort-order="desc"
               data-mobile-responsive="true"
               data-editable-emptytext="Non renseigné"
	          <?php if($viewtoolbar) echo "data-search='true'"; ?>
               >
			<thead>
				<tr>
            		<th data-field="id" data-sortable="true" data-visible="false">Id</th>
            		<th data-field="selection" data-sortable="true" data-formatter="selectionFormatter" data-align="center">On garde</th>
            		<th data-field="nom" data-sortable="true">Nom</th>
            		<th data-field="telephone" data-sortable="true" data-editable="true">Téléphone</th>
            		<th data-field="mail" data-sortable="true" data-editable="true">E-mail</th>
            		<th data-field="adresse" data-sortable="true" data-editable="true">Adresse</th>
            		<th data-field="date" data-sortable="true">Date</th>
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

?> 
<script type="text/javascript">

<?php

if ($viewtoolbar) 
	echo "var editable = true;\n\n";
else
	echo "var editable = false;\n\n";

echo " var data = [";
	
		$counter = 0;

		while ($row = mysql_fetch_array($recrutement_resultat, MYSQL_ASSOC)) {

			$date = substr($row["date"],8,2) . "/" . substr($row["date"],5,2) . "/" . substr($row["date"],0,4);
			echo "{\n";
			echo "\"id\" : ".json_encode($row["id"]).",\n";
			echo "\"nom\" : ".json_encode($row["nom"]." ".$row["prenom"]).",\n";
			echo "\"telephone\" : ".json_encode($row["telephone"]).",\n";
			echo "\"mail\" : ".json_encode($row["mail"]).",\n";
			echo "\"adresse\" : ".json_encode($row["adresse"]).",\n";
			echo "\"date\" : ".json_encode($date).",\n";
			echo "\"source\" : ".json_encode($row["source"]).",\n";
			echo "\"experience\" : ".json_encode($row["experience"]).",\n";
			echo "\"envie\" : ".json_encode($row["envie"]).",\n";
			echo "\"disponibilite\" : ".json_encode($row["disponibilite"]).",\n";
			echo "\"selection\" : ".json_encode($row["selection"])."\n";
			echo "}";

			if (++$counter < $nb_inscrits) echo ",\n";
		}

echo "];\n";
?>

$(function () {
    $('#table').bootstrapTable({
        data: data,
        onClickCell: function (field, value, row, $element)
        {
        	if (field == 'selection' && editable == true)
        	{
		        row.selection = row.selection == 0 ? 1 :0;
				$table.bootstrapTable('updateRow', {index: $element.attr('data-index'), row: row});
        	}
        }
    });

    <?php

    	if(isPrintMode()) echo "$('#table').bootstrapTable('expandAllRows')\n";
	?>
});

</script>
<script>
    function detailFormatter(index, row) {
        var html = [];
        html.push('<div class="row"><div class="col-xs-6">');
        html.push('<p><b>A connu Improcité :</b><br>' + row['source']);
		html.push('</div><div class="col-xs-6">');
        html.push('</p><p><b>Son expérience en impro :</b><br>' + row['experience']);
		html.push('</div></div><div class="row"><div class="col-xs-6">');
		html.push('</p><p><b>Ses envies :</b><br>' + row['envie']);
		html.push('</div><div class="col-xs-6">');
        html.push('</p><p><b>Ses disponibilités :</b><br>' + row['disponibilite'] + '</p>');
		html.push('</div></div>')

        return html.join('');
        }
</script>
<script>
/*function showalert(message,alerttype) {

    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + ' fade out"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')

  }*/

   function showalert(message,alerttype) {

    $('#alert_placeholder').append('<div id="alertdiv" class="alert ' +  alerttype + '"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')

    setTimeout(function() { // this will automatically close the alert and remove this if the users doesnt close it in 5 secs


      $("#alertdiv").remove();

    }, 2000);
  }

    var $table = $('#table'),
        $button = $('#button');


    $(function () {
        $button.click(
        	function () 
        	{
	       	    var $donnees = JSON.stringify($table.bootstrapTable('getData'));
	    		//start the ajax
		   		$.ajax({
		        url: "recrutement_maj.php",  
		        type: "POST",
		        data: {'inscrits' : $donnees},    
		        cache: false,
		        success: function(data) {  
		        	showalert("Les données ont bien été mises à jour","alert-success");
		    	},
		        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    showalert("Error: " + errorThrown, "alert-danger");
                	}
		        });
      		});
    });
</script>
<script type="text/javascript">
	
	    function selectionFormatter(value, row) {
    	var icon = row.selection == 0 ? 'fa-heart-o' : 'fa-heart';
	   	return '<i class="fa ' + icon + ' fa-lg" style="color:#CB0810;"></i> ';

		}
</script>
<?php

mysql_free_result($recrutement_resultat);

# Affichage du pied de page
@include ( "pied.php" ) ;

?>
