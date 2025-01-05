<h3><i class="fa fa-chart-pie me-3"></i>Statistiques</h3>
<hr />

<h4>Sélections depuis le début de la saison</h4>
<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
    <th></th>
    {foreach from=$roles item=role}
    <th class="text-center"><span class="badge py-2 px-2 text-bg-primary"><i class="fa-solid fa-star me-2"></i>{$role}</span></th>
    {/foreach}
  </thead>
  <tbody>
    {foreach from=$joueurs item=joueur}
    <tr>
      <td>{$joueur.prenom} <span class="fw-light">{$joueur.nom}</span></td>
      {foreach from=$roles item=role}
      <td class="text-center">{$statistiques.{$joueur.id}.$role}</td>
      {/foreach}
    </tr>
    {/foreach}
  </tbody>
</table>
</div>
