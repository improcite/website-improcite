<div class="card text-white mb-3">
  <img src="/assets/images/photo-header.png" class="card-img" />
  <div class="card-img-overlay">
    <h2 class="card-title">Bienvenue sur le site d'Improcité</h2>
    <p class="card-text fs-5">Troupe amatrice d'improvisation théâtrale depuis 2003&nbsp;!</p>
  </div>
</div>

<div class="alert alert-success">
<i class="fa-solid fa-circle-question"></i> Improcité est une troupe amatrice d'improvisation théâtrale de Lyon et Villeurbanne.
Elle a été créée en 2003 et continue son aventure depuis&nbsp;!<br />
<i class="fa fa-calendar"></i> Vous pouvez nous retrouver lors de nos nombreux spectacles, consultez notre <a href="?p=agenda">agenda</a> pour en savoir plus&nbsp;!
</div>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
{include file="date.tpl" date=$dates.$date_id}
{/for}
</div>
{/if}

