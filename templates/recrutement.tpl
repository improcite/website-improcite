<div class="card my-3">
  <div class="card-body text-center">
    <h1 class="text-center my-3"><i class="fa fa-handshake"></i> Recrutement</h1>
    <div class="text-center"><img src="/assets/images/recrutement.png" class="img-fluid" /></div>
    <p class="text-center my-3 fs-5">Rejoins la famille Improcité !</p>
  </div>
</div>

{if $error}
<div class="alert alert-danger mb-3" role="alert">
    {if $error eq 'nocaptcha'}
    La saisie du captcha est obligatoire
    {/if}
    {if $error eq 'nocaptchasession'}
    Problème de session captcha, merci de réessayer
    {/if}
    {if $error eq 'badcaptcha'}
    A priori tu ne sais pas bien lire ou écrire, retente de mettre le bon captcha
    {/if}
</div>
{/if}

{if $action eq "presentation"}
<div class="card">
  <div class="card-header text-center"><h3>Participer au recrutement</h3></div>
  <div class="card-body">
    <p class="card-text">
    Tu as déjà fait de l'impro (+/- 2 ans) ou du théâtre et tu recherches une troupe pour t'entraîner, jouer et t'épanouir ?<br />
    Tu aimes les challenges, jouer différents types de spectacles dans différentes salles, et avec d'autres équipes ?<br />
    Tu es motivé(e) pour t'impliquer dans le fonctionnement de la troupe et participer à tous les postes liés à un spectacle (joueur, régie, communication, MC, caisse) ?<br />
    Tu es disponible les jeudis soirs pour les entrainements et à d'autres moments en fonction des spectacles ?<br />
    Tu es friand(e) d'apéros, sorties et cohésion déjantés, et qu'un fabuleux weekend d'intégration avec une quinzaine de nouveaux amis ne te fait pas peur {if $date_wei}(date prévisionelle : {$date_wei}) {/if}?
    </p>
    <h4 class="card-text text-center"><i class="fa fa-hand-point-right"></i> Alors tente ta chance pour la saison {get_saison_string id_saison={$saison_recrutement}} !</h4>
  </div>
  <div class="card-header text-center"><h3>Comment ça marche ?</h3></div>
  <div class="card-body">
    <p class="card-text">
    Tu viens à nos deux séances "test" ou tu pourras t'entraîner avec nous ! (une première sélection aura lieu pour revenir en deuxième semaine) :
    <ul>
    {foreach $dates_recrutement as $date_recrutement}
      <li>{$date_recrutement}</li>
    {/foreach}
    </ul>
    Le lieu de rendez-vous est à La Cordée Villeurbanne (71 rue Francis Pressensé - 69100 Villeurbanne). L'entrée se fait sur la rue Colin.<br />
    Tu peux venir à partir de 19h30 pour que nous puissions démarrer à l'heure !
    </p>
  </div>
  <div id="map" class="card-img-bottom" style="width: 100%; height: 400px;"></div>
  <div class="card-header text-center"><h3>Inscription</h3></div>
  <div class="card-body">
    <h4>On aurait besoin de savoir ça pour t'inscrire :</h4>
    <form class="row g-3" method="post" action="/?p=recrutement">
    <div class="col-md-3">
      <label for="inputNom" class="form-label">Nom</label>
      <input type="text" class="form-control border border-danger" id="inputNom" autocomplete="family-name" name="nom" required>
    </div>
    <div class="col-md-3">
      <label for="inputPrenom" class="form-label">Prénom</label>
      <input type="text" class="form-control border border-danger" id="inputPrenom" autocomplete="given-name" name="prenom" required>
    </div>
    <div class="col-md-3">
      <label for="inputEmail" class="form-label">Email</label>
      <input type="email" class="form-control border border-danger" id="inputEmail" autocomplete="email" name="mail" required>
    </div>
    <div class="col-md-3">
      <label for="inputTelephone" class="form-label">Téléphone</label>
      <input type="tel" class="form-control border border-danger" id="inputTelephone" autocomplete="tel" name="telephone" required>
    </div>
    <hr />
    <div class="col-md-6">
      <label for="inputExperience" class="form-label">Quelle est ton expérience en improvisation ?</label>
      <textarea class="form-control border border-danger" id="inputExperience" rows="3" name="experience" required></textarea>
    </div>
    <div class="col-md-6">
      <label for="inputEnvie" class="form-label">Quelles sont tes envies ?</label>
      <textarea class="form-control border border-danger" id="inputEnvie" rows="3" name="envie" required></textarea>
    </div>
    <h4>Tu peux aussi nous dire si tu veux :</h4>
    <div class="col-md-6">
      <label for="inputAdresse" class="form-label">Ton adresse</label>
      <textarea class="form-control" id="inputAdresse" rows="2" autocomplete="street-address" name="adresse"></textarea>
    </div>
    <div class="col-md-6">
      <label for="inputDateNaissance" class="form-label">Ta date de naissance</label>
      <input type="date" class="form-control" id="inputDateNaissance" autocomplete="bday" name="datenaissance">
    </div>
    <hr />
    <div class="col-md-6">
      <label for="inputSource" class="form-label">Comment as-tu connu Improcité ?</label>
      <textarea class="form-control" id="inputSource" rows="3" name="source"></textarea>
    </div>
    <div class="col-md-6">
      <label for="inputDisponibilite" class="form-label">Quelles sont tes disponibilités sur l'année ?</label>
      <textarea class="form-control" id="inputDisponibilite" rows="3" name="disponibilite"></textarea>
    </div>
    <hr />
    <div class="col-md-6">
        <p>On vérifie que tu sais lire et écrire (mais c'est surtout parce qu'on reçoit beaucoup de spams...). Peux-tu recopier le code dans la case d'à côté ? Tu peux aussi démarrer une improvisation avec ce thème...</p>
    </div>
    <div class="col-md-3">
      <img src="{$captcha_image}" width="100%" />
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control border border-danger" id="inputPhrase" autocomplete="no" name="phrase" required>
    </div>
    <input type="hidden" name="action" value="inscription" />
    <button type="submit" class="btn btn-primary">Je m'inscris !</button>
    </form>
  </div>
</div>

<script src="/assets/leaflet/leaflet.js"></script>
<script type="text/javascript">
var coordonnees = "18/45.772339/4.873973".split("/");
var nom = "Cordée Villeurbanne";
var adresse = "71 rue Francis Pressensé - 69100 Villeurbanne";
{literal}
var map = L.map('map').setView([coordonnees[1], coordonnees[2]], coordonnees[0]);
var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
var marker = L.marker([coordonnees[1], coordonnees[2]]).addTo(map);
marker.bindPopup("<b>"+nom+"</b><br />" + adresse).openPopup();
{/literal}
</script>

{/if}


{if $action eq "inscription"}

<div class="card">
  <div class="card-header text-center"><h3>Félicitations {$participant.prenom} !</h3></div>
  <div class="card-body">
  <p class="card-text">Ton inscription a bien été prise en compte, merci !</p>
  <p>Un mail de confirmation a été envoyé à {$participant.mail}, tu devrais le recevoir dans les prochaines minutes. Si ce n'est pas le cas, pense à vérifier tes spams !</p>
  <p>À très bientôt !</p>
  </div>
</div>

{/if}

<div class="pb-3"></div>
