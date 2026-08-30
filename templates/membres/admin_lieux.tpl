<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-map-marker me-2"></i>Lieux</h3>
  {if $action == "consultation"}
  <div class="float-end">
    <a href="index.php?p=admin_lieux&action=creer" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i>Nouveau lieu</a>
  </div>
  {/if}
  {if $action == "afficher"}
  <div class="float-end btn-group">
    <a href="index.php?p=admin_lieux" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des lieux</a>
    <a href="index.php?p=admin_lieux&action=editer&id={$lieu.id}" class="btn btn-primary"><i class="fa fa-pen me-2"></i>Modifier</a>
    <span data-bs-toggle="modal" data-bs-target="#delete-lieu-{$lieu.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</span>
  </div>
  <div class="modal fade" id="delete-lieu-{$lieu.id}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer le lieu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Veux-tu vraiment supprimer le lieu {$lieu.nom} ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <a role="button" href="index.php?p=admin_lieux&action=supprimer&id={$lieu.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
        </div>
      </div>
    </div>
  </div>
  {/if}
  {if $action == "editer"}
  <div class="float-end btn-group">
    <a href="index.php?p=admin_lieux" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des lieux</a>
    <a href="index.php?p=admin_lieux&action=afficher&id={$lieu.id}" class="btn btn-secondary"><i class="fa fa-eye me-2"></i>Afficher</a>
    <span data-bs-toggle="modal" data-bs-target="#delete-lieu-{$lieu.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</span>
  </div>
  <div class="modal fade" id="delete-lieu-{$lieu.id}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer le lieu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Veux-tu vraiment supprimer le lieu {$lieu.nom} ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <a role="button" href="index.php?p=admin_lieux&action=supprimer&id={$lieu.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
        </div>
      </div>
    </div>
  </div>
  {/if}
  {if $action == "creer"}
  <div class="float-end">
    <a href="index.php?p=admin_lieux" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des lieux</a>
  </div>
  {/if}
</div>
<hr />

{if $action == "consultation"}
<div class="alert alert-success" role="alert">
  {count($lieux)} lieux trouvés
</div>
{if count($lieux)}
<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Adresse</th>
      <th>Coordonnées</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
{for $id = 0 to count($lieux)-1}
    <tr>
      <td>{$lieux.$id.id}</td>
      <td>{$lieux.$id.nom}</td>
      <td>{$lieux.$id.adresse}</td>
      <td>{$lieux.$id.coordonnees}</td>
      <td>
        <div class="btn-group" role="group">
        <a role="button" class="btn btn-secondary" href="index.php?p=admin_lieux&action=afficher&id={$lieux.$id.id}" title="Afficher"><i class="fa fa-eye"></i></a>
        <a role="button" class="btn btn-primary" href="index.php?p=admin_lieux&action=editer&id={$lieux.$id.id}" title="Modifier"><i class="fa fa-pen"></i></a>
        <span role="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-lieu-{$lieux.$id.id}" title="Supprimer"><i class="fa fa-trash"></i></span>
        </div>
      </td>
    </tr>
{/for}
  </tbody>
</table>
</div>
{for $id = 0 to count($lieux)-1}
<div class="modal fade" id="delete-lieu-{$lieux.$id.id}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Supprimer le lieu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Veux-tu vraiment supprimer le lieu {$lieux.$id.nom} ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <a role="button" href="index.php?p=admin_lieux&action=supprimer&id={$lieux.$id.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
      </div>
    </div>
  </div>
</div>
{/for}
{/if}
{/if}


{if $action == "afficher"}
<div class="row">
  <div class="col-md-12">
    <div class="card shadow">
      <div class="card-body">
        <h5 class="card-title">{$lieu.nom}</h5>
        <p class="card-text">
          <b>Adresse</b><br />
          {$lieu.adresse}<br />
          {if $lieu.adresse2}{$lieu.adresse2}<br />{/if}
        </p>
        <p class="card-text">
          <b>Coordonnées GPS</b><br />
          {$lieu.coordonnees}
        </p>
      </div>
    </div>
  </div>
</div>
{/if}

{if $action == "editer" or $action == "creer"}
<div class="row">
  <div class="col-md-12">
    <div class="card shadow">
      <div class="card-body">
      <form method="post" action="index.php?p=admin_lieux&action=enregistrer&id={$lieu.id}">
        <div class="mb-3">
          <label for="inputNom" class="form-label">Nom</label>
          <input type="text" class="form-control" id="inputNom" name="nom" value="{$lieu.nom}">
        </div>
        <div class="mb-3">
          <label for="inputAdresse" class="form-label">Adresse</label>
          <textarea class="form-control" id="inputAdresse" name="adresse" rows="3">{$lieu.adresse}</textarea>
        </div>
        <div class="mb-3">
          <label for="inputAdresse2" class="form-label">Adresse (complément)</label>
          <textarea class="form-control" id="inputAdresse2" name="adresse2" rows="2">{$lieu.adresse2}</textarea>
        </div>
        <div class="mb-3">
          <label for="inputCoordonnees" class="form-label">Coordonnées GPS</label>
          <input type="text" class="form-control" id="inputCoordonnees" name="coordonnees" value="{$lieu.coordonnees}">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
      </div>
    </div>
  </div>
</div>
{/if}
