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

{if $result == "phototoobig"}
<div class="alert alert-danger" role="alert">
  La taille du fichier est trop grande
</div>
{/if}
{if $result == "photonotuploaded"}
<div class="alert alert-danger" role="alert">
  Erreur lors de la mise à jour de la photo
</div>
{/if}
{if $result == "photouploaded"}
<div class="alert alert-success" role="alert">
  La photo a bien été changée
</div>
{/if}

{if $action == "consultation"}
<div class="alert alert-success" role="alert">
  {count($lieux)} lieux trouvés
</div>
{if count($lieux)}
<div class="table-responsive">
<table class="table table-sm table-striped table-hover" id="table-lieux">
  <thead>
    <tr>
      <th>ID</th>
      <th>Photo</th>
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
      <td>{if $lieux.$id.photo}<i class="fa fa-image" role="button" data-bs-toggle="modal" data-bs-target="#img-lieu-{$lieux.$id.id}"></i>{/if}</td>
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
{if $lieux.$id.photo}
<div class="modal fade" id="img-lieu-{$lieux.$id.id}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <img src="{$lieux.$id.photo}" />
    </div>
  </div>
</div>
{/if}
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
  <div class="col-md-4">
    {if $lieu.photo}<img src="{$lieu.photo}" class="img-fluid shadow" alt="{$lieu.nom}"/>{/if}
  </div>
  <div class="col-md-8">
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
      {if $lieu.coordonnees}
      <div id="map" class="card-img-bottom" style="width: 100%; height: 400px;"></div>
      {/if}
    </div>
  </div>
</div>

{if $lieu.coordonnees}
<script src="/assets/leaflet/leaflet.js"></script>
<script type="text/javascript">
var coordonnees = "{$lieu.coordonnees}".split("/");
var nom = "{$lieu.nom}";
var adresse = "{$lieu.adresse}";
{literal}
var map = L.map('map').setView([coordonnees[1], coordonnees[2]], coordonnees[0]);
var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
var marker = L.marker([coordonnees[1], coordonnees[2]]).addTo(map);
marker.bindPopup("<b>"+nom+"</b><br />" + adresse).openPopup();
{/literal}
</script>
{/if}
{/if}

{if $action == "editer" or $action == "creer"}
<div class="row">
  <div class="col-md-4">
    {if $lieu.photo}<img src="{$lieu.photo}" class="img-fluid shadow mb-3" alt="{$lieu.nom}"/>{/if}
    {if $lieu.id}
    <form action="?p=admin_lieux" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="modifierphoto" />
    <input type="hidden" name="id" value="{$lieu.id}" />
    <div class="alert alert-info mb-3">Photo au format JPG et moins de 1 Mo.</div>
    <input class="form-control mb-3" type="file" id="photo" name="photo">
    <input type="submit" value="Modifier la photo" class="btn btn-success mb-3">
    </form>
    {/if}
  </div>
  <div class="col-md-8">
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
          <div class="input-group">
            <input type="text" class="form-control" id="inputCoordonnees" name="coordonnees" value="{$lieu.coordonnees}" placeholder="zoom/latitude/longitude">
            <button type="button" class="btn btn-outline-secondary" id="btnGeocode" title="Géolocaliser depuis l'adresse"><i class="fa fa-location-crosshairs me-1"></i>Géolocaliser</button>
          </div>
          <div id="geocodeResult" class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
      </div>
    </div>
  </div>
</div>
<script src="/assets/js/geolocalisation.js"></script>
{/if}
