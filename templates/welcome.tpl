<div class="card text-white mb-3">
  <img src="/assets/images/photo-header.png" class="card-img" />
  <div class="card-img-overlay">
    <h2 class="card-title">Bienvenue sur le site d'Improcité</h2>
    <p class="card-text fs-5">Troupe amatrice d'improvisation théâtrale depuis 2003&nbsp;!</p>
  </div>
</div>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
{include file="date.tpl" date=$dates.$date_id}
{/for}
</div>
{/if}

