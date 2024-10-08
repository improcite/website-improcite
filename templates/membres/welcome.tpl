<h3>Bienvenue {$membre.prenom} !</h3>
<hr />

<div class="row">
{for $interne=0 to 1}
<div class="col-md-6">

<h3 class="mb-3"><i class="fa fa-calendar me-2"></i>Prochaines dates {if $interne}internes{else}publiques{/if}</h3>

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
{if $dates.$date_id.interne == $interne}
    <tr>
      <td>{$dates.$date_id.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"}</td>
      <td>{$dates.$date_id.nom}</td>
      <td>{$dates.$date_id.lnom}</td>
      <td><span title="{$dates.$date_id.commentairei|unescape:'html'}">{$dates.$date_id.commentaire|truncate:60}</span></td>
      <td class="text-center">
      {if $dates.$date_id.dispo_pourcent == 0}
      <span role='button' class="badge py-2 px-3 text-bg-danger border border-2" data-bs-toggle="modal" data-bs-target="#dispo-{$dates.$date_id.id}-{$membre.id}">
        {if $dates.$date_id.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$dates.$date_id.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-xmark me-3"></i>
        {/if}
        Non
      </span>
      {else if $dates.$date_id.dispo_pourcent == 50}
      <span role='button' class="badge py-2 px-3 text-bg-light border border-2" data-bs-toggle="modal" data-bs-target="#dispo-{$dates.$date_id.id}-{$membre.id}">
        {if $dates.$date_id.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$dates.$date_id.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-question me-3"></i>
        {/if}
        ???
      </span>
      {else if $dates.$date_id.dispo_pourcent == 100}
      <span role='button' class="badge py-2 px-3 text-bg-success border border-2" data-bs-toggle="modal" data-bs-target="#dispo-{$dates.$date_id.id}-{$membre.id}">
        {if $dates.$date_id.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$dates.$date_id.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-check me-3"></i>
        {/if}
        Oui
      </span>
      {/if}
      </td>
      {if $dates.$date_id.selection}
      <td class="text-center">
      <span class="badge py-2 px-2 text-bg-primary"><i class="fa-solid fa-star me-2"></i>{$dates.$date_id.selection}</span>
      </td>
      {else}
      <td></td>
      {/if}
    </tr>
{/if}
{/for}
  </tbody>
</table>
</div>

{/if}
</div>
{/for}
</div>

{for $date_id = 0 to count($dates)-1}
{include 'modal-dispo.tpl' idModal="dispo-{$dates.$date_id.id}-{$membre.id}" date=$dates.$date_id dispo_pourcent=$dates.$date_id.dispo_pourcent dispo_commentaire=$dates.$date_id.dispo_commentaire membre_id=$membre.id backURL="index.php?p=welcome"}
{/for}
