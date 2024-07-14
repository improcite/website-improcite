<h3><i class="fa fa-user"></i> Mon compte</h3>
<hr />


{if $action == "consultation"}

<div class="card mb-3">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="{photo_membre id_membre={$membre.id} id_saison={$id_saison} path=".."}" class="img-fluid rounded-start" alt="Photo actuelle">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Informations principales</h5>
        <table class="table table-hover">
          <tbody>
            <tr>
              <th class="w-25"><i class="fa fa-user me-2"></i>Prénom et nom</th>
              <td>{$infos.prenom} {$infos.nom}</td>
            </tr>
            <tr>
              <th><i class="fa fa-mask me-2"></i>Surnom</th>
              <td>{$infos.surnom}</td>
            </tr>
            <tr>
              <th><i class="fa fa-envelope me-2"></i>Email</th>
              <td>{mailto address=$infos.email}</td>
            </tr>
            <tr>
              <th><i class="fa fa-phone me-2"></i>Téléphone</th>
              <td>{$infos.portable}</td>
            </tr>
            <tr>
              <th><i class="fa fa-cake me-2"></i>Date de naissance</th>
              <td>{$infos.jour}/{$infos.mois}/{$infos.annee}</td>
            </tr>
            <tr>
              <th><i class="fa fa-location-dot me-2"></i>Adresse</th>
              <td>{$infos.adresse|regex_replace:"/[\r\n]/" : "<br />"}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


{/if}
