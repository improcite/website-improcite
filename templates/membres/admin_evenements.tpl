<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-calendar me-2"></i>Événements</h3>
  {if $action == "consultation"}
  <div class="float-end">
    <a href="index.php?p=admin_evenements&action=creer" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i>Nouvel événement</a>
  </div>
  {/if}
  {if $action == "afficher"}
  <div class="float-end btn-group">
    <a href="index.php?p=admin_evenements" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des événements</a>
    <a href="index.php?p=admin_evenements&action=editer&id={$evenement.id}" class="btn btn-primary"><i class="fa fa-pen me-2"></i>Modifier</a>
    <span data-bs-toggle="modal" data-bs-target="#delete-eve-{$evenement.id}"class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</span>
  </div>
  <div class="modal fade" id="delete-eve-{$evenement.id}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer l'événement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Veux-tu vraiment supprimer l'événement {$evenement.nom} du {$evenement.unixdate|date_format:"%d/%m"} ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <a role="button" href="index.php?p=admin_evenements&action=supprimer&id={$evenement.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
        </div>
      </div>
    </div>
  </div>
  {/if}
  {if $action == "editer"}
  <div class="float-end btn-group">
    <a href="index.php?p=admin_evenements" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des événements</a>
    <a href="index.php?p=admin_evenements&action=afficher&id={$evenement.id}" class="btn btn-secondary"><i class="fa fa-eye me-2"></i>Afficher</a>
    <span data-bs-toggle="modal" data-bs-target="#delete-eve-{$evenement.id}"class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</span>
  </div>
  <div class="modal fade" id="delete-eve-{$evenement.id}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer l'événement</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Veux-tu vraiment supprimer l'événement {$evenement.nom} du {$evenement.unixdate|date_format:"%d/%m"} ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <a role="button" href="index.php?p=admin_evenements&action=supprimer&id={$evenement.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
        </div>
      </div>
    </div>
  </div>
  {/if}
  {if $action == "creer"}
  <div class="float-end">
    <a href="index.php?p=admin_evenements" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des événements</a>
  </div>
  {/if}
</div>
<hr />

{if $action == "consultation"}
<div class="alert alert-success" role="alert">
  {count($evenements)} événements trouvés
</div>
{if count($evenements)}
<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Photo</th>
      <th>Date</th>
      <th>Catégorie</th>
      <th>Lieu</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
{for $id = 0 to count($evenements)-1}
    <tr>
      <td>{$evenements.$id.id}</td>
      <td>{if $evenements.$id.photo}<i class="fa fa-image" role="button" data-bs-toggle="modal" data-bs-target="#img-eve-{$evenements.$id.id}"></i>{/if}</td>
      <td>{$evenements.$id.unixdate|date_format:"%d/%m/%Y"}</td>
      <td>{$evenements.$id.nom}</td>
      <td>{$evenements.$id.lnom}</td>
      <td>{if $evenements.$id.ecommentaire}<span data-bs-toggle="tooltip" data-bs-title="{$evenements.$id.ecommentaire|escape}">{$evenements.$id.ecommentaire|truncate}</span>{/if}</td>
      <td>
        <div class="btn-group" role="group">
        <a role="button" class="btn btn-secondary" href="index.php?p=admin_evenements&action=afficher&id={$evenements.$id.id}" title="Afficher"><i class="fa fa-eye"></i></a>
        <a role="button" class="btn btn-primary" href="index.php?p=admin_evenements&action=editer&id={$evenements.$id.id}" title="Modifier"><i class="fa fa-pen"></i></a>
        <span role="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-eve-{$evenements.$id.id}" title="Supprimer"><i class="fa fa-trash"></i></span>
        </div>
      </td>
    </tr>
    {if $evenements.$id.photo}
    <div class="modal fade" id="img-eve-{$evenements.$id.id}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <img src="{$evenements.$id.photo}" />
        </div>
      </div>
    </div>
    {/if}
    <div class="modal fade" id="delete-eve-{$evenements.$id.id}" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Supprimer l'événement</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Veux-tu vraiment supprimer l'événement {$evenements.$id.nom} du {$evenements.$id.unixdate|date_format:"%d/%m"} ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <a role="button" href="index.php?p=admin_evenements&action=supprimer&id={$evenements.$id.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
          </div>
        </div>
      </div>
    </div>
{/for}
  </tbody>
</table>
</div>
{/if}
{/if}


{if $action == "afficher"}
<div class="row">
  <div class="col-md-4">
    {if $evenement.photo}<img src="{$evenement.photo}" class="img-fluid shadow" alt="{$evenement.nom}"/>{/if}
  </div>
  <div class="col-md-8">
    <div class="card shadow mb-3">
      <div class="card-body">
        <h5 class="card-title">{$evenement.nom}</h5>
        <p class="card-text">
          <b>Date</b><br />
          {$evenement.unixdate|date_format:"%d/%m/%Y - %Hh%M"}
        </p>
        <p class="card-text">
          <b>Description</b><br />
          {$evenement.ecommentaire}
        </p>
        <p class="card-text">
          <b>Lieu</b><br />
          {$evenement.lnom}
        </p>
        <p class="card-text">
          <b>Tarif</b><br />
          {$evenement.tarif}
        </p>
        <p class="card-text">
          <b>Places</b><br />
          {$evenement.places}
        </p>
        <p class="card-text">
          <b>Joueurs</b><br />
          {include file="liste_membres.tpl" membres={$evenement.joueurs}}
        </p>
        <p class="card-text">
          <b>MC</b><br />
          {include file="liste_membres.tpl" membres={$evenement.mc}}
        </p>
        <p class="card-text">
          <b>Arbitre</b><br />
          {include file="liste_membres.tpl" membres={$evenement.arbitre}}
        </p>
        <p class="card-text">
          <b>Régie</b><br />
          {include file="liste_membres.tpl" membres={$evenement.regisseur}}
        </p>
        <p class="card-text">
          <b>Animateurs</b><br />
          {include file="liste_membres.tpl" membres={$evenement.animateurs}}
        </p>
        <p class="card-text">
          <b>Caisse</b><br />
          {include file="liste_membres.tpl" membres={$evenement.caisse}}
        </p>
      </div>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body">
      {foreach from=$membres item=membre}
      {if $membre.dispo.dispo_pourcent == 0}
      <span class="badge py-2 px-2 text-bg-danger mb-2">
        {if $membre.dispo.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$membre.dispo.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-xmark me-3"></i>
        {/if}
        {$membre.prenom} {$membre.nom}
      </span>
      {else if $membre.dispo.dispo_pourcent == 50}
      <span class="badge py-2 px-2 text-bg-light border border-2 mb-2">
        {if $membre.dispo.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$membre.dispo.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-question me-3"></i>
        {/if}
        {$membre.prenom} {$membre.nom}
      </span>
      {else if $membre.dispo.dispo_pourcent == 100}
      <span class="badge py-2 px-2 text-bg-success mb-2">
        {if $membre.dispo.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$membre.dispo.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-check me-3"></i>
        {/if}
        {$membre.prenom} {$membre.nom}
      </span>
      {/if}
      {/foreach}
      </div>
  </div>
</div>
{/if}

{if $action == "editer" or $action == "creer"}
<div class="row">
  <div class="col-md-4">
    {if $evenement.photo}<img src="{$evenement.photo}" class="img-fluid shadow" alt="{$evenement.nom}"/>{/if}
  </div>
  <div class="col-md-8">
    <div class="card shadow mb-3">
      <div class="card-body">
      <form method="post" action="index.php?p=admin_evenements&action=enregistrer&id={$evenement.id}">
        <div class="mb-3">
          <select class="form-select" aria-label="Liste des catégories" name="categorie">
          {foreach from=$categories item=categorie}
            <option value="{$categorie.id}"{if $evenement.categorie == $categorie.id} selected{/if}>{$categorie.nom}</option>
          {/foreach}
          <select>
        </div>
        <div class="mb-3">
          <label for="inputDate" class="form-label">Date et heure</label>
          <input class="form-control" id="inputDate" name="date" type="datetime-local" value="{$evenement.unixdate|date_format:"%Y-%m-%dT%H:%M"}" />
        </div>
        <div class="mb-3">
          <select class="form-select" aria-label="Liste des lieux" name="lieu">
          {foreach from=$lieux item=lieu}
            <option value="{$lieu.id}"{if $evenement.lieu == $lieu.id} selected{/if}>{$lieu.nom}</option>
          {/foreach}
          <select>
        </div>
        <div class="mb-3">
          <label for="inputCommentaire" class="form-label">Commentaire</label>
          <textarea class="form-control" id="inputDescription" name="commentaire" row="5">{$evenement.ecommentaire}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
      </div>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body">
      {foreach from=$membres item=membre}
      {if $membre.dispo.dispo_pourcent == 0}
      <span class="badge py-2 px-2 text-bg-danger mb-2">
        {if $membre.dispo.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$membre.dispo.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-xmark me-3"></i>
        {/if}
        {$membre.prenom} {$membre.nom}
      </span>
      {else if $membre.dispo.dispo_pourcent == 50}
      <span class="badge py-2 px-2 text-bg-light border border-2 mb-2">
        {if $membre.dispo.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$membre.dispo.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-question me-3"></i>
        {/if}
        {$membre.prenom} {$membre.nom}
      </span>
      {else if $membre.dispo.dispo_pourcent == 100}
      <span class="badge py-2 px-2 text-bg-success mb-2">
        {if $membre.dispo.dispo_commentaire}
        <span data-bs-toggle="tooltip" data-bs-title="{$membre.dispo.dispo_commentaire}"><i class="fa-regular fa-comment me-3"></i></span>
        {else}
        <i class="fa fa-circle-check me-3"></i>
        {/if}
        {$membre.prenom} {$membre.nom}
      </span>
      {/if}
      {/foreach}
      </div>
    </div>
  </div>
</div>
{/if}
