<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-calendar-check me-3"></i>Disponibilités</h3>
  <div class="btn-group float-end" role="group">
    <a href="index.php?p=dispos&month={$month_before}&year={$year_before}" class="btn btn-secondary"><i class="fa-solid fa-caret-left"></i></a>
    <button type="button" class="btn btn-secondary">{$month} / {$year}</button>
    <a href="index.php?p=dispos&month={$month_after}&year={$year_after}" class="btn btn-secondary"><i class="fa-solid fa-caret-right"></i></a>
  </div>
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
