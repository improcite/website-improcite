<h3>Bienvenue {$membre.prenom} !</h3>
<hr />
<h3 class="mb-3"><i class="fa fa-calendar me-2"></i>Prochaines dates</h3>

{if count($dates)}
<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Date</th>
      <th>Evénement</th>
      <th>Lieu</th>
      <th>Description</th>
      <th class="text-center">Disponible</th>
      <th class="text-center">Sélection</th>
    </tr>
  </thead>
  <tbody>
{for $date_id = 0 to count($dates)-1}
    <tr>
      <td>{$dates.$date_id.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"}</td>
      <td>{$dates.$date_id.nom}</td>
      <td>{$dates.$date_id.lnom}</td>
      <td><span title="{$dates.$date_id.commentaire}">{$dates.$date_id.description|truncate:60}</span></td>
      <td class="text-center">
      {if $dates.$date_id.dispo_pourcent == 0}
      <span class="badge py-2 px-3 text-bg-danger"><i class="fa fa-circle-xmark me-3"></i>Non</span>
      {else if $dates.$date_id.dispo_pourcent == 50}
      <span class="badge py-2 px-4 text-bg-light"><i class="fa fa-circle-question"></i></span>
      {else if $dates.$date_id.dispo_pourcent == 100}
      <span class="badge py-2 px-3 text-bg-success"><i class="fa fa-circle-check me-3"></i>Oui</span>
      {/if}
      </td>
      {if $dates.$date_id.selection}
      <td class="text-center">
      <span class="badge py-2 px-3 text-bg-secondary"><i class="fa-solid fa-star me-3"></i>{$dates.$date_id.selection}</span>
      </td>
      {else}
      <td></td>
      {/if}
    </tr>
{/for}
  </tbody>
</table>
</div>
{/if}
