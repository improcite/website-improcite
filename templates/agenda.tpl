<h1 class="text-center my-3"><i class="fa fa-calendar"></i> Agenda</h1>
<p class="text-center my-3 fs-5">Venez nous rencontrer lors d'une de nos prochaines dates&nbsp;!</p>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
{include file="date.tpl" date=$dates.$date_id}
{/for}
</div>
{/if}

