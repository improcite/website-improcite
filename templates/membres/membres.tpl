<h3><i class="fa fa-users"></i> Les membres d'Improcité - Saison {get_saison_string id_saison={$id_saison}}</h3>
<hr />

{if count($membres)}
<div class="row">
{for $membre_id = 0 to count($membres)-1}
  <div class="col-md-6 mb-4">
    <div class="card">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="{photo_membre id_membre={$membres.$membre_id.id} id_saison={$id_saison} path=".."}" class="card-img-top" alt="Photo de {$membres.$membre_id.prenom}" title="{$membres.$membre_id.prenom}" />
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <div class="card-text">
          <h5>{$membres.$membre_id.prenom} {$membres.$membre_id.nom}</h5>
          <p><i class="fa fa-envelope me-2"></i>{mailto address=$membres.$membre_id.email}</p>
          <p><i class="fa fa-phone me-2"></i>{$membres.$membre_id.portable}</p>
          <p><i class="fa fa-cake me-2"></i>{$membres.$membre_id.jour}/{$membres.$membre_id.mois}/{$membres.$membre_id.annee}</p>
          <p><i class="fa fa-location-dot me-2"></i>{$membres.$membre_id.adresse|regex_replace:"/[\r\n]/" : "<br />"}</p>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
{/for}
</div>
{/if}

