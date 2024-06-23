<div class="text-center"><img src="/assets/images/photo-header.png" class="w-100 img-fluid my-2" /></div>

<div class="alert alert-info text-center fs-5 fw-medium" role="alert">
  Bienvenue sur le site d'Improcité, troupe amatrice d'improvisation théâtrale depuis 2003&nbsp;!
</div>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
  <div class="col-md-6">

    <div class="card mb-3">
      <div class="row g-0">
      <div class="col-md-4">
        <img src="{$dates.$date_id.photo}" class="img-fluid rounded-start" alt="{$dates.$date_id.nom}"/>
      </div>
      <div class="col-md-8">
        <div class="card-body">
        <h5 class="card-title">{$dates.$date_id.nom}</h5>
        <p class="card-text">{$dates.$date_id.ecommentaire}</p>
        </div>
      </div>
      </div>
    </div>

  </div>
{/for}
</div>
{/if}

