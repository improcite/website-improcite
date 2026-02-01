<div class="card my-3">
  <div class="card-body text-center">
    <h1><i class="fa fa-calendar"></i> Agenda</h1>
    <p class="fs-5">Venez nous rencontrer lors d'une de nos prochaines dates&nbsp;!</p>
  </div>
</div>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
{include file="date.tpl" date=$dates.$date_id}
{/for}
</div>
{/if}

