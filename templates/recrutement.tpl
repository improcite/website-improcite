<h1 class="text-center my-3"><i class="fa fa-handshake"></i> Recrutement</h1>
<div class="text-center"><img src="/assets/images/recrutement.png" class="img-fluid" /></div>
<p class="text-center my-3 fs-5">Rejoins la famille Improcité !</p>

{if $action eq "presentation"}
<div class="card">
  <div class="card-header text-center"><h3>Participer au recrutement</h3></div>
  <div class="card-body">
    <p class="card-text">
    Tu as déjà fait de l'impro (+/- 2 ans) ou du théâtre et tu recherches une troupe pour t'entraîner, jouer et t'épanouir ?<br />
    Tu aimes les challenges, jouer différents types de spectacles dans différentes salles, et avec d'autres équipes ?<br />
    Tu es motivé(e) pour t'impliquer dans le fonctionnement de la troupe et participer à tous les postes liés à un spectacle (joueur, régie, communication, MC, caisse) ?<br />
    Tu es disponible les jeudis soirs pour les entrainements et à d'autres moments en fonction des spectacles ?<br />
    Tu es friand(e) d'apéros, sorties et cohésion déjantés, et qu'un fabuleux weekend d'intégration avec une quinzaine de nouveaux amis ne te fait pas peur ?
    </p>
    <h4 class="card-text text-center"><i class="fa fa-hand-point-right"></i> Alors tente ta chance pour la saison 2024-2025 !</h4>
    <div class="alert alert-warning" role="alert">
    <i class="fa fa-venus-mars"></i> Afin de maintenir un équilibre dans la troupe, sache que nous recherchons en priorité cette année des <b>improvisatrices</b>. Cependant toutes les candidatures sont bien entendu acceptées et nous serons heureux de tous vous rencontrer lors du recrutement !
    </div>
  </div>
  <div class="card-header text-center"><h3>Comment ça marche ?</h3></div>
  <div class="card-body">
    <p class="card-text">
    Vous devrez participer à nos deux sessions de recrutement :
    <ul>
      <li>Jeudi 5 septembre 2024 à 20h</li>
      <li>Jeudi 12 septembre 2024 à 20h</li>
    </ul>
    Le lieu de rendez-vous est à la salle Théodore (8 rue Saint Théodore - 69003 Lyon)
    </p>
  </div>
  <div id="map" class="card-img-bottom" style="width: 100%; height: 400px;"></div>
  <div class="card-header text-center"><h3>Inscription</h3></div>
  <div class="card-body">
    <form class="row g-3" method="post" action="/?p=recrutement">
    <div class="col-md-4">
      <label for="inputNom" class="form-label">Nom</label>
      <input type="text" class="form-control" id="inputNom" autocomplete="family-name" name="nom" required>
    </div>
    <div class="col-md-4">
      <label for="inputPrenom" class="form-label">Prénom</label>
      <input type="text" class="form-control" id="inputPrenom" autocomplete="given-name" name="prenom" required>
    </div>
    <div class="col-md-4">
      <label for="inputEmail" class="form-label">Email</label>
      <input type="email" class="form-control" id="inputEmail" autocomplete="email" name="mail" required>
    </div>
    <div class="col-md-4">
      <label for="inputAdresse" class="form-label">Adresse</label>
      <textarea class="form-control" id="inputAdresse" rows="2" autocomplete="street-address" name="adresse" required></textarea>
    </div>
    <div class="col-md-4">
      <label for="inputDateNaissance" class="form-label">Date de naissance</label>
      <input type="date" class="form-control" id="inputDateNaissance" autocomplete="bday" name="datenaissance" required>
    </div>
    <div class="col-md-4">
      <label for="inputTelephone" class="form-label">Téléphone</label>
      <input type="tel" class="form-control" id="inputTelephone" autocomplete="tel" name="telephone" required>
    </div>
    <hr />
    <div class="col-md-6">
      <label for="inputExperience" class="form-label">Quelle est ton expérience en improvisation ?</label>
      <textarea class="form-control" id="inputExperience" rows="3" name="experience" required></textarea>
    </div>
    <div class="col-md-6">
      <label for="inputEnvie" class="form-label">Quelles sont tes envies ?</label>
      <textarea class="form-control" id="inputEnvie" rows="3" name="envie" required></textarea>
    </div>
    <hr />
    <div class="col-md-6">
      <label for="inputSource" class="form-label">Comment as-tu connu Improcité ?</label>
      <textarea class="form-control" id="inputSource" rows="3" name="source" required></textarea>
    </div>
    <div class="col-md-6">
      <label for="inputDisponibilite" class="form-label">Quelles sont tes disponibilités sur l'année ?</label>
      <textarea class="form-control" id="inputDisponibilite" rows="3" name="disponibilite" required></textarea>
    </div>
    <input type="hidden" name="action" value="inscription" />
    <button type="submit" class="btn btn-primary">Je m'inscris !</button>
    </form>
  </div>
</div>

<script src="/assets/leaflet/leaflet.js"></script>
<script type="text/javascript">
var coordonnees = "18/45.74943/4.86350".split("/");
var nom = "Salle Théodore";
var adresse = "8 rue Saint Théodore - 69003 Lyon";
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
  <p>Un mail de confirmation a été envoyé à {$participant.mail}, tu devrais le recevoir dans les prochaines minutes.</p>
  <p>À très bientôt !</p>
  </div>
</div>

{/if}

<div class="pb-3"></div>
