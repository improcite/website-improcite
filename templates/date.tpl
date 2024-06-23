  <div class="col-lg-6">

    <div class="card mb-3">
      <div class="row g-0">
      <div class="col-sm-4 text-center">
        <img src="{$date.photo}" class="img-fluid rounded-start" alt="{$date.nom}"/>
      </div>
      <div class="col-sm-8">
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
        </div>
      </div>
      </div>
    </div>

  </div>
