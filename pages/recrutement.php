<h1>Participer au recrutement</h1>

<?php 

# On verifie l'action
$action = getp("action");

if ( $action === "inscription" ) {

	# Enregistrement de l'inscription en base
	$recrut_sql = "INSERT INTO $t_recrutement (nom, prenom, datenaissance, adresse, mail, telephone, source, experience, envie, disponibilite, date) VALUES('".getp("nom")."','".getp("prenom")."','".getp("datenaissance")."','".getp("adresse")."','".getp("mail")."','".getp("tel")."','".getp("source")."','".getp("experience")."','".getp("envie")."','".getp("disponibilite")."','".date('Y-m-d H:i:s')."')";

	$recrut_query = mysql_query($recrut_sql);

	# Envoi d'un mail
	$mail  = "Nom : ".getp("nom")."\n";
	$mail .= "Prénom : ".getp("prenom")."\n";
	$mail .= "Date de naissance : ".getp("datenaissance")."\n";
	$mail .= "Adresse : ".getp("adresse")."\n";
	$mail .= "Mail;Tel : ".getp("mail").";".getp("tel")."\n";
	$mail .= "Connaissance d'improcité : ".getp("source")."\n";
	$mail .= "Expérience en impro : ".getp("experience")."\n";
	$mail .= "Envies : ".getp("envie")."\n";
	$mail .= "Disponibilités : ".getp("disponibilite")."\n";

	mail("jossssss@gmail.com","Nouvelle inscription au recrutement !",utf8_encode($mail), "MIME-Version: 1.0\r\nContent-type: text/plain; charset=UTF-8\r\nFrom: Webmaster Improcite <clem.oudot@gmail.com>\r\n");

?>

<p>Ton inscription a bien été prise en compte, merci !</p>


<?php } else { ?>

<div class="panel panel-default">
  <div class="panel-heading">Recrutement 2016-2017</div>
  <div class="panel-body">
  	Les deux séances de recrutement auront lieu les <b>jeudis 8 et 15 septembre 2016</b>, puisque c'est le jeudi soir que nous nous entraînons.<br><br>

    Aucune expérience en impro n'est exigée (mais avouons-le, ça aide quand même).<br><br>

    Pour participer, suffit de remplir le formulaire ci-dessous.
  </div>
</div>

<form method="post" id="recrutement">

<input type="hidden" name="action" value="inscription" />

<div class="row">
  <div class="col-xs-12 col-md-6">
  	
<fieldset>
<legend>Qui es-tu ?</legend>
<label for="nom">Nom : </label><input name="nom" type="text" class="required" /><br />
<label for="prenom">Prénom : </label><input name="prenom" type="text" class="required" /><br />
<label for="mail">Email : </label><input name="mail" type="text" class="required email" /><br />
<label for="adresse">Adresse : </label><input name="adresse" type="text" class="required" /><br />
<label for="tel">Téléphone : </label><input name="tel" type="text" class="required" /><br />
<label for="datenaissance">Date de naissance : </label><input name="datenaissance" type="text" class="required date" /><br />
</fieldset>

  </div>
  <div class="col-md-6">
  	
<fieldset>
<legend>Improvisation</legend>
<label for="experience">Quelle est ton expérience en improvisation ?</legend><br />
<textarea name="experience" class="required" ></textarea><br />
<label for="envie">Quelles sont tes envies ?</legend><br />
<textarea name="envie" class="required" ></textarea><br />
</fieldset>

<fieldset>
<legend>Improcité</legend>
<label for="source">Comment as-tu connu Improcité ?</legend><br />
<textarea name="source" class="required" ></textarea><br />
<label for="disponibilite">Quelles sont tes disponibilités sur l'année ?</legend><br />
<textarea name="disponibilite" class="required" ></textarea><br />
</fieldset>


  </div>
</div>




<button>Inscription</button>

</form>

<?php } ?>
