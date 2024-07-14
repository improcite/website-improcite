<h3>Bienvenue {$membre.prenom} !</h3>
<hr />
<h3><i class="fa fa-calendar me-2"></i>Prochaines dates</h3>

{if count($dates)}
<table class="table table-striped">
  <thead>
    <tr>
      <th>Date</th>
      <th>Evénement</th>
      <th>Lieu</th>
    </tr>
  </thead>
  <tbody>
{for $date_id = 0 to count($dates)-1}
    <tr>
      <td>{$dates.$date_id.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"}</td>
      <td>{$dates.$date_id.nom}</td>
      <td>{$dates.$date_id.lnom}</td>
    </tr>
{/for}
  </tbody>
</table>
{/if}
