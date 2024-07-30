<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-tag me-2"></i>Catégories</h3>
  {if $action == "consultation"}
  <div class="float-end">
    <a href="index.php?p=admin_categories&action=creer" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i>Nouvelle catégorie</a>
  </div>
  {/if}
  {if $action == "afficher"}
  <div class="float-end btn-group">
    <a href="index.php?p=admin_categories" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des catégories</a>
    <a href="index.php?p=admin_categories&action=modifier&id={$categorie.id}" class="btn btn-primary"><i class="fa fa-pen me-2"></i>Modifier</a>
    <span data-bs-toggle="modal" data-bs-target="#delete-cat-{$categorie.id}"class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</span>
  </div>
  <div class="modal fade" id="delete-cat-{$categorie.id}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer la catégorie</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Veux-tu vraiment supprimer la catégorie {$categorie.nom} ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <a role="button" href="index.php?p=admin_categories&action=supprimer&id={$categorie.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
        </div>
      </div>
    </div>
  </div>
  {/if}
</div>
<hr />

{if $action == "consultation"}
<div class="alert alert-success" role="alert">
  {count($categories)} catégories trouvées
</div>
{if count($categories)}
<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Photo</th>
      <th>Nom</th>
      <th>Description</th>
      <th>Publique</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
{for $id = 0 to count($categories)-1}
    <tr>
      <td>{$categories.$id.id}</td>
      <td>{if $categories.$id.photo}<i class="fa fa-image" role="button" data-bs-toggle="modal" data-bs-target="#img-cat-{$categories.$id.id}"></i>{/if}</td>
      <td>{$categories.$id.nom}</td>
      <td>{if $categories.$id.description}<span data-bs-toggle="tooltip" data-bs-title="{$categories.$id.description|escape}">{$categories.$id.description|truncate}</span>{/if}</td>
      <td>{$categories.$id.publique}</td>
      <td>
        <div class="btn-group" role="group">
        <a role="button" class="btn btn-secondary" href="index.php?p=admin_categories&action=afficher&id={$categories.$id.id}" title="Afficher"><i class="fa fa-eye"></i></a>
        <a role="button" class="btn btn-primary" href="index.php?p=admin_categories&action=modifier&id={$categories.$id.id}" title="Modifier"><i class="fa fa-pen"></i></a>
        <span role="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-cat-{$categories.$id.id}" title="Supprimer"><i class="fa fa-trash"></i></span>
        </div>
      </td>
    </tr>
    {if $categories.$id.photo}
    <div class="modal fade" id="img-cat-{$categories.$id.id}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <img src="{$categories.$id.photo}" />
        </div>
      </div>
    </div>
    {/if}
    <div class="modal fade" id="delete-cat-{$categories.$id.id}" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Supprimer la catégorie</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Veux-tu vraiment supprimer la catégorie {$categories.$id.nom} ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <a role="button" href="index.php?p=admin_categories&action=supprimer&id={$categories.$id.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
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
    {if $categorie.photo}<img src="{$categorie.photo}" class="img-fluid shadow" alt="{$categorie.nom}"/>{/if}
  </div>
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body">
        <h5 class="card-title">{$categorie.nom}</h5>
        <p class="card-text">
          <b>Description</b><br />
          {$categorie.description}<br />
        </p>
        <p class="card-text">
          <b>Publique</b><br />
          {if $categorie.publique}Oui{else}Non{/if}
        </p>
      </div>
    </div>
  </div>
</div>
{/if}
