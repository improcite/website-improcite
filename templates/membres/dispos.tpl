<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-calendar-check me-3"></i>Disponibilités</h3>
  <div class="btn-group float-end" role="group">
    <a href="index.php?p=dispos&month={$month_before}&year={$year_before}" class="btn btn-secondary"><i class="fa-solid fa-caret-left"></i></a>
    <button type="button" class="btn btn-secondary">{$month} / {$year}</button>
    <a href="index.php?p=dispos&month={$month_after}&year={$year_after}" class="btn btn-secondary"><i class="fa-solid fa-caret-right"></i></a>
  </div>
</div>
<hr />

<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
    <th>Date</th>
    {foreach from=$joueurs item=joueur}
    <th class="text-center">{$joueur.prenom}<br /><span class="fw-light">{$joueur.nom}</span></th>
    {/foreach}
  </thead>
  <tbody>
    {foreach from=$dates item=date}
    <tr>
      <th>
          {$date.unixdate|date_format:"%d/%m | %Hh%M"}<br />
          <span class="fw-light">{$date.nom}</span><br />
          <span class="fw-light fst-italic">{$date.lnom}</span>
      </th>
      {foreach from=$joueurs item=joueur}
      {get_dispo_user mysqli=$mysqli t_dispo=$t_dispo id_eve=$date.id id=$joueur.id infos="infos"}
      <td class="text-center">
      {if !$infos}
        <br />
      {else if $infos.dispo_pourcent==100}
        <span class="badge py-2 px-3 text-bg-success"><i class="fa fa-circle-check me-3"></i>Oui</span>
      {else if $infos.dispo_pourcent==0}
        <span class="badge py-2 px-3 text-bg-danger"><i class="fa fa-circle-xmark me-3"></i>Non</span>
      {/if}
      </td>
      {/foreach}
    <tr>
    {/foreach}
  </tbody>
</table>
</div>
