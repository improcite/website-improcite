<div class="text-center"><img src="/assets/images/photo-header.png" class="w-100 img-fluid my-2" /></div>

<div class="alert alert-info text-center fs-5 fw-medium" role="alert">
  Bienvenue sur le site d'Improcité, troupe amatrice d'improvisation théâtrale depuis 2003&nbsp;!
</div>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
{include file="date.tpl" date=$dates.$date_id}
{/for}
</div>
{/if}

