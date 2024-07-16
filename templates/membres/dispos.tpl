<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-calendar-check me-3"></i>Disponibilités</h3>
  <button class="btn btn-secondary float-end">{$month} / {$year}</button>
</div>
<hr />

<table class="table table-striped table-hover">
  <thead>
    <th>Date</th>
    {foreach from=$joueurs item=joueur}
    <th class="text-center">{$joueur.prenom}<br /><span class="fw-light">{$joueur.nom}</span></th>
    {/foreach}
  </thead>
  <tbody>
  </tbody>
</table>
