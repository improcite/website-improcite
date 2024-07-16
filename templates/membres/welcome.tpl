<h3>Bienvenue {$membre.prenom} !</h3>
<hr />
<h3 class="mb-3"><i class="fa fa-calendar me-2"></i>Prochaines dates</h3>

{if count($dates)}
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Date</th>
      <th>Evénement</th>
      <th>Lieu</th>
      <th class="mw-50">Description</th>
      <th>Disponible</th>
    </tr>
  </thead>
  <tbody>
{for $date_id = 0 to count($dates)-1}
    <tr>
      <td>{$dates.$date_id.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"}</td>
      <td>{$dates.$date_id.nom}</td>
      <td>{$dates.$date_id.lnom}</td>
      <td><span title="{$dates.$date_id.commentaire}">{$dates.$date_id.description|truncate:60}</span></td>
      {if $dates.$date_id.dispo_pourcent == 0}
      <td class="text-bg-danger"><i class="fa fa-circle-xmark me-2"></i> Non</td>
      {else if $dates.$date_id.dispo_pourcent == 50}
      <td class="text-bg-warning"><i class="fa fa-circle-question me-2"></i> Ne sait pas</td>
      {else if $dates.$date_id.dispo_pourcent == 100}
      <td class="text-bg-success"><i class="fa fa-circle-check me-2"></i>Oui</td>
      {/if}
    </tr>
{/for}
  </tbody>
</table>
{/if}
