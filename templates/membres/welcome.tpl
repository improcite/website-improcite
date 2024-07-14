<h3>Bienvenue {$membre.prenom} !</h3>
<hr />
<h3><i class="fa fa-calendar me-2"></i>Prochaines dates</h3>

{if count($dates)}
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Date</th>
      <th>Evénement</th>
      <th>Lieu</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
{for $date_id = 0 to count($dates)-1}
    <tr>
      <td>{$dates.$date_id.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"}</td>
      <td>{$dates.$date_id.nom}</td>
      <td>{$dates.$date_id.lnom}</td>
      <td>{if $dates.$date_id.ecommentaire}{$dates.$date_id.ecommentaire}{else}{$dates.$date_id.description}{/if}</td>
    </tr>
{/for}
  </tbody>
</table>
{/if}
