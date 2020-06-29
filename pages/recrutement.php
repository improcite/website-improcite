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
	$mysql_nom = mysql_real_escape_string(getp("nom"));
	$mysql_prenom = mysql_real_escape_string(getp("prenom"));
	$mysql_datenaissance = mysql_real_escape_string(getp("datenaissance"));
	$mysql_adresse = mysql_real_escape_string(getp("adresse"));
	$mysql_mail = mysql_real_escape_string(getp("mail"));
	$mysql_tel = mysql_real_escape_string(getp("tel"));
	$mysql_source = mysql_real_escape_string(getp("source"));
	$mysql_experience = mysql_real_escape_string(getp("experience"));
	$mysql_envie = mysql_real_escape_string(getp("envie"));
	$mysql_disponibilite = mysql_real_escape_string(getp("disponibilite"));
	$recrut_sql = "INSERT INTO $t_recrutement (nom, prenom, datenaissance, adresse, mail, telephone, source, experience, envie, disponibilite, date) VALUES('$mysql_nom','$mysql_prenom','$mysql_datenaissance','$mysql_adresse','$mysql_mail','$mysql_tel','$mysql_source','$mysql_experience','$mysql_envie','$mysql_disponibilite','".date('Y-m-d H:i:s')."')";

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

<div class="panel panel-default">
  <div class="panel-heading text-center">Recrutement</div>
  <div class="panel-body">
<p>Ton inscription a bien été prise en compte, merci !</p>
<p>Tu recevras un mail dans 1 min 13s qui te donnera toutes les informations nécessaires. A partir de 1:14, tu peux vérifier tes spams ;-)</p>
<p>Résumé des détails pratiques :
<ul>
<li>Session de recrutement : jeudi 3 septembre et jeudi 10 septembre au collège Jean Jaurès.</li>
<li>Entraînements les jeudis soirs de 20h à 22h à Villeurbanne (collège Jean Jaurès).</li>
<li>Spectacles dans différents bars et salles de Lyon et certains déplacements dans l'année.</li>
<li>Cotisation 225 euros l'année.</li>
</ul>
</p>
  </div>
</div>
<div class="text-center">
  <a role="button" class="btn btn-info btn-lg" href="/"><i class="fa fa-home"></i> Retour au site</a>
</div>

<?php } else { ?>

<div class="panel panel-default">
  <div class="panel-heading text-center">Recrutement</div>
  <div class="panel-body">
<p>
Parce que tu as déjà fait de l'impro (+/- 2 ans) ou du théâtre et que tu recherches une troupe pour t'entraîner, jouer et t'épanouir !<br />
Parce que tu aimes les challenges, jouer différents types de spectacles dans différentes salles, et avec d'autres équipes !<br />
Parce que tu es motivé(e) pour t'impliquer dans le fonctionnement de la troupe et investir tous les postes liés à un spectacle (joueur, régie, communication, MC, caisse, ...) !<br />
Parce que tu es friand(e) d'apéros, sorties et cohésion déjantés, et qu'un fabuleux weekend d'intégration avec une quinzaine de nouveaux amis ne te fait pas peur !</p>
<div class="text-center">
<video width="300px" controls autoplay>
<source src="teaser_recrutement.mp4" type="video/mp4">
</video>
</div>
<p>Alors, IMPROCITE est faite pour toi !<br />
Pour participer à nos deux séances de recrutement les jeudis 3 et 10 septembre 2020, 20h-22h à Villeurbanne, il suffit de remplir le formulaire ci-dessous.
</p>
  </div>
</div>

<form method="post" id="recrutement">

<input type="hidden" name="action" value="inscription" />

<div class="row">
  <div class="col-xs-12 col-md-6">
  	
<fieldset>
<legend>Qui es-tu ?</legend>
<label for="nom">Nom : </label><input name="nom" type="text" class="required" required /><br />
<label for="prenom">Prénom : </label><input name="prenom" type="text" class="required" required /><br />
<label for="mail">Email : </label><input name="mail" type="text" class="required email" required /><br />
<label for="adresse">Adresse : </label><input name="adresse" type="text" class="required" required /><br />
<label for="tel">Téléphone : </label><input name="tel" type="text" class="required" required /><br />
<label for="datenaissance">Date de naissance : </label><input name="datenaissance" type="text" class="required date" required /><br />
</fieldset>

  </div>
  <div class="col-md-6">
  	
<fieldset>
<legend>Improvisation</legend>
<label for="experience">Quelle est ton expérience en improvisation ?</legend><br />
<textarea name="experience" class="required" required ></textarea><br />
<label for="envie">Quelles sont tes envies ?</legend><br />
<textarea name="envie" class="required" required ></textarea><br />
</fieldset>

<fieldset>
<legend>Improcité</legend>
<label for="source">Comment as-tu connu Improcité ?</legend><br />
<textarea name="source" class="required" required ></textarea><br />
<label for="disponibilite">Quelles sont tes disponibilités sur l'année ?</legend><br />
<textarea name="disponibilite" class="required" required ></textarea><br />
</fieldset>

  </div>
</div>

<input type="submit" class="btn btn-success btn-lg" value="Inscription">

</form>

<?php } ?>
