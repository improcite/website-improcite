<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-user"></i> Mon compte</h3>
  <a href="/index.php?p=membre&id={$membre.id}" target="_blank" class="btn btn-primary float-end" type="button"><i class="fa fa-globe me-2"></i>Voir sur le site public</a>
</div>
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

<div class="card mb-3">
  <div class="card-header text-center"><h4>Ton parcours</h4></div>
  <div class="card-body row">
    {assign var=items value=['debut' => "Début dans l'improvisation", 'envie' => "Comment as-tu eu envie de faire de l'improvisation&nbsp;?", 'apport' => "Que t'apporte l'improvisation ?", 'debutimprocite' => "Ton arrivée à Improcité ?", 'improcite' => "Pour toi Improcité c'est quoi ?",'qualite' => "Qualité en impro", 'defaut' => "Défaut en impro"]}
    {foreach $items as $item => $label}
    <div class="col-md-4">
      <div class="mb-2 me-2 p-3 rounded border border-secondary">
      <h5>{$label}</h5>
      <p>{$infos.$item}</p>
      </div>
    </div>
   {/foreach}
  </div>
</div>
{/if}
