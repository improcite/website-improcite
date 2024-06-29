<!DOCTYPE html "-//w3c//dtd xhtml 1.0 transitional //en" "http://www.w3.org/tr/xhtml1/dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
        {literal}
        body {margin: 0; padding: 0; min-width: 100%!important; background: #eee; font-family: sans-serif;}
        .content {width: 100%; max-width: 600px; background: #fff; color: #000; font-weight: 500; padding: 10px; margin: 20px auto; border-radius: 30px;}
        .footer  {width: 100%; max-width: 600px; color:#454545; font-weight:300; margin: 0 10px;}
        {/literal}
        </style>
    </head>
    <body>
        <div class="content">
          <img src="http://www.improcite.com/assets/images/bandeau_recrutement_mail.png" alt="Bandeau recrutement" width="100%" />
          <p>Salut !</p>
          <p>Une nouvelle personne s'est inscrite au recrutement pour la saison prochaine :</p>
          <ul>
            <li>{$participant.prenom} {$participant.nom}</li>
            <li>{$participant.telephone}</li>
            <li>{$participant.mail}</li>
            <li>{$participant.adresse}</li>
            <li>Né(e) le {$participant.datenaissance}</li>
          </ul>
          <p>Expérience en impro : {$participant.experience}</p>
          <p>Envies : {$participant.envie}</p>
          <p>Connaissance d'Improcité : {$participant.source}</p>
          <p>Disponibilités : {$participant.disponibilite}</p>
        </div>
        <div class="footer">
          <p>Mail envoyé par <a href="https://www.improcite.com">Improcité</a></p>
        </div>
    </body>
</html>
