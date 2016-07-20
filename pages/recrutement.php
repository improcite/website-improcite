<h1>Participer au recrutement</h1>

<?php 

# On verifie l'action
$action = getp("action");

if ( $action === "inscription" ) {

	// Récupération des recruteurs
	$recruteur_sql = "SELECT `prenom`, `portable`, `email` FROM impro_comediens WHERE rights LIKE '%recruteur%'";
	$recruteur_query = mysql_query($recruteur_sql) or die('Erreur SQL !<br />'.$recruteur_sql.'<br />'.mysql_error());

	$nb_recruteurs = @mysql_num_rows($recruteur_query);

	$destinataires_mail = '';
	$signature_mail_inscrit = '';
	$counter = 0;

	while ($row = mysql_fetch_array($recruteur_query, MYSQL_ASSOC)) {

		$destinataires_mail .= $row['email'];
		if (++$counter < $nb_recruteurs) $destinataires_mail .= ",";

		$signature_mail_inscrit .= "<p><b>".$row['prenom']."</b><br>".$row['portable']."</p>";
	}

	mysql_free_result($recruteur_query);

	# Enregistrement de l'inscription en base
	$recrut_sql = "INSERT INTO $t_recrutement (nom, prenom, datenaissance, adresse, mail, telephone, source, experience, envie, disponibilite, date) VALUES('".getp("nom")."','".getp("prenom")."','".getp("datenaissance")."','".getp("adresse")."','".getp("mail")."','".getp("tel")."','".getp("source")."','".getp("experience")."','".getp("envie")."','".getp("disponibilite")."','".date('Y-m-d H:i:s')."')";

	$recrut_query = mysql_query($recrut_sql);

	# Envoi d'un mail d'information à Improcité
	$corps_mail  = "<p><b>Nom : </b><br>".getp("nom")."<br><br>\n";
	$corps_mail .= "<b>Prénom : </b><br>".getp("prenom")."<br><br>\n";
	$corps_mail .= "<b>Date de naissance : </b><br>".getp("datenaissance")."<br><br>\n";
	$corps_mail .= "<b>Adresse : </b><br>".getp("adresse")."<br><br>\n";
	$corps_mail .= "<b>E-mail : </b><br>".getp("mail")."<br><br>\n";
	$corps_mail .= "<b>Téléphone : </b><br>".getp("tel")."</p>\n";
	$corps_mail .= "<p><b>Connaissance d'improcité : </b><br>".getp("source")."</p>\n";
	$corps_mail .= "<p><b>Expérience en impro : </b><br>".getp("experience")."</p>\n";
	$corps_mail .= "<p><b>Envies : </b><br>".getp("envie")."</p>\n";
	$corps_mail .= "<p><b>Disponibilités : </b><br>".getp("disponibilite")."</p>\n";

	$mail_confirmation_interne = file_get_contents("template_mail_recrutement_interne.html");
	$mail_confirmation_interne = str_replace("_infos_",$corps_mail,$mail_confirmation_interne);

	mail($destinataires_mail,"[Improcité] Nouvelle inscription au recrutement !",$mail_confirmation_interne, "MIME-Version: 1.0\r\nContent-Type: text/html; charset=\"iso-8859-1\"\r\nFrom: Improcite <contact@improcite.com>\r\n");

	$mail_confirmation = file_get_contents("template_mail_recrutement.html");

	$mail_confirmation = str_replace("_inscrit_",getp("prenom"),$mail_confirmation);
	$mail_confirmation = str_replace("_recruteurs_",$signature_mail_inscrit,$mail_confirmation);


	// Mail de confirmation utilisateur
	mail(getp("mail"), "[Improcité] Tu es inscrit(e) au recrutement", $mail_confirmation, "MIME-Version: 1.0\r\nContent-Type: text/html; charset=\"iso-8859-1\"\r\nFrom: Improcite <contact@improcite.com>\r\n");
?>

<p>Ton inscription a bien été prise en compte, merci !</p>
<p>Tu recevras un mail dans 1 min 13s qui te donnera toutes les informations nécessaires. A partir de 1:14, tu peux vérifier tes spams ;-)</p>

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
