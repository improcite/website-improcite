<div class="clearfix">
  <h3 class="float-start me-3"><i class="fa fa-calendar-check me-3"></i>Disponibilités</h3>
  <div class="btn-group" role="group">
    <a href="index.php?p=dispos&month={$month_before}&year={$year_before}" class="btn btn-secondary"><i class="fa-solid fa-caret-left"></i></a>
    <a href="index.php?p=dispos" class="btn btn-secondary">{$month} / {$year}</a>
    <a href="index.php?p=dispos&month={$month_after}&year={$year_after}" class="btn btn-secondary"><i class="fa-solid fa-caret-right"></i></a>
  </div>
</div>
<hr />

{for $interne=0 to 1}
<h4><i class="fa fa-calendar me-2"></i>Dates {if $interne}internes{else}publiques{/if}</h4>

<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
    <th>Date</th>
    {foreach from=$joueurs item=joueur}
    <th class="text-center"><img src="{photo_membre id_membre={$joueur.id} id_saison={$id_saison} path=".."}" class="img-fluid img-thumbnail" width="60px" alt="Photo de {$joueurprenom}" /><br />{$joueur.prenom}<br /><span class="fw-light">{$joueur.nom}</span></th>
    {/foreach}
  </thead>
  <tbody>
    {foreach from=$dates item=date}
    {if $date.interne == $interne}
    <tr>
      <th data-bs-toggle="tooltip"  data-bs-html="true" data-bs-title="<span class='fw-light'>{$date.nom}</span><br /><span class='fw-light fst-italic'>{$date.lnom}</span><br />{$date.ecommentaire|escape:'html'}">
          {$date.unixdate|date_format:"%d/%m"}<br />
          {$date.unixdate|date_format:"%Hh%M"}<br />
          <span class="fw-light">{$date.nom}</span>
      </th>
      {foreach from=$joueurs item=joueur}
      {get_dispo_user mysqli=$mysqli t_dispo=$t_dispo id_eve=$date.id id=$joueur.id infos="infos"}
      {assign var="role" value={get_selection_user mysqli=$mysqli t_eve=$t_eve id_eve=$date.id id=$joueur.id}}
      <td class="text-center">
      {if !$infos or $infos.dispo_pourcent==50}
        <span class="badge py-2 px-3 mb-2 text-bg-light border border-2"{if $joueur.id == $membre.id} data-bs-toggle="modal" data-bs-target="#dispo-{$date.id}-{$joueur.id}" role="button"{/if}>
        {if $infos.commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$infos.commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-question me-3"></i>
        {/if}
        ???
        </span>
        {if $role}<br /><span class="badge py-2 px-2 text-bg-primary"><i class="fa-solid fa-star me-2"></i>{$role}</span>{/if}
      {else if $infos.dispo_pourcent==100}
        <span class="badge py-2 px-3 mb-2 text-bg-success border border-2" {if $joueur.id == $membre.id} data-bs-toggle="modal" data-bs-target="#dispo-{$date.id}-{$joueur.id}" role="button"{/if}>
        {if $infos.commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$infos.commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-check me-3"></i>
        {/if}
        Oui
        </span>
        {if $role}<br /><span class="badge py-2 px-2 text-bg-primary"><i class="fa-solid fa-star me-2"></i>{$role}</span>{/if}
      {else if $infos.dispo_pourcent==0}
        <span class="badge py-2 px-3 mb-2 text-bg-danger border border-2" {if $joueur.id == $membre.id} data-bs-toggle="modal" data-bs-target="#dispo-{$date.id}-{$joueur.id}" role="button"{/if}>
        {if $infos.commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$infos.commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-xmark me-3"></i>
        {/if}
        Non
        </span>
        {if $role}<br /><span class="badge py-2 px-2 text-bg-primary"><i class="fa-solid fa-star me-2"></i>{$role}</span>{/if}
      {/if}
      </td>
      {/foreach}
    <tr>
    {/if}
    {/foreach}
  </tbody>
</table>
</div>

<hr />
{/for}

{foreach from=$joueurs item=joueur}
{get_dispo_user mysqli=$mysqli t_dispo=$t_dispo id_eve=$date.id id=$joueur.id infos="infos"}
{foreach from=$dates item=date}
{include 'modal-dispo.tpl' idModal="dispo-{$date.id}-{$joueur.id}" date=$date dispo_pourcent=$infos.dispo_pourcent dispo_commentaire=$infos.commentaire membre_id=$joueur.id backURL="index.php?p=dispos&year={$year}&month={$month}"}
{/foreach}
{/foreach}
