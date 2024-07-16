<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-calendar-check me-3"></i>Disponibilités</h3>
  <div class="btn-group float-end" role="group">
    <a href="index.php?p=dispos&month={$month_before}&year={$year_before}" class="btn btn-secondary"><i class="fa-solid fa-caret-left"></i></a>
    <a href="index.php?p=dispos" class="btn btn-secondary">{$month} / {$year}</a>
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
      {assign var="role" value={get_selection_user mysqli=$mysqli t_eve=$t_eve id_eve=$date.id id=$joueur.id}}
      <td class="text-center">
      {if !$infos}
        <span class="badge py-2 px-4 mb-2 text-bg-light"><i class="fa fa-circle-question"></i></span>
        {if $role}<br /><span class="badge py-2 px-3 text-bg-secondary"><i class="fa fa-star me-3"></i>{$role}</span>{/if}
      {else if $infos.dispo_pourcent==100}
        <span class="badge py-2 px-3 mb-2 text-bg-success"><i class="fa fa-circle-check me-3"></i>Oui</span>
        {if $role}<br /><span class="badge py-2 px-3 text-bg-secondary"><i class="fa-solid fa-star me-3"></i>{$role}</span>{/if}
      {else if $infos.dispo_pourcent==0}
        <span class="badge py-2 px-3 mb-2 text-bg-danger"><i class="fa fa-circle-xmark me-3"></i>Non</span>
        {if $role}<br /><span class="badge py-2 px-3 text-bg-secondary"><i class="fa-solid fa-star me-3"></i>{$role}</span>{/if}
      {/if}
      </td>
      {/foreach}
    <tr>
    {/foreach}
  </tbody>
</table>
</div>
