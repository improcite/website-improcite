  <div class="col-lg-6">

    <div class="card mb-3 shadow">
      <div class="row g-0">
      <div class="col-sm-5 text-center">
        <a href="/?p=evenement&id={$date.id}"><img src="{$date.photo}" class="img-fluid rounded-start" alt="{$date.nom}"/></a>
      </div>
      <div class="col-sm-7">
        <div class="card-body">
        <h5 class="card-title">{$date.nom}</h5>
        <p class="card-text"><small class="text-body-secondary"><i class="fa fa-calendar-days"></i> {$date.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"} | <i class="fa fa-location-dot"></i> {$date.lnom}</small></p>
        <p class="card-text">
        {if $date.ecommentaire}
        {$date.ecommentaire}
        {else}
        {$date.description}
        {/if}
        </p>
        {include file="joueurs.tpl" joueurs=[{$date.joueurs},{$date.mc},{$date.arbitre},{$date.animateurs}]|join:';'}
        </div>
      </div>
      </div>
    </div>

  </div>
