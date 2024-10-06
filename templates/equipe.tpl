<h1 class="text-center my-3"><i class="fa fa-users"></i> Les membres d'Improcité</h1>
<p class="text-center my-3 fs-5">Saison {get_saison_string id_saison={$id_saison}}</p>

{if count($membres)}
<div class="row">
{for $membre_id = 0 to count($membres)-1}
  <div class="col-md-3 mb-4">
    <div class="card shadow">
      <a href="?p=membre&id={$membres.$membre_id.id}"><img src="{photo_membre id_membre={$membres.$membre_id.id} id_saison={$id_saison}}" class="card-img-top" alt="Photo de {$membres.$membre_id.prenom}" title="{$membres.$membre_id.prenom}" /></a>
      <div class="card-body">
        <div class="card-text text-center">{$membres.$membre_id.prenom}</div>
      </div>
    </div>
  </div>
{/for}
</div>
{/if}

