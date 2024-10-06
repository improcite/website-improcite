<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-users me-2"></i>Membres</h3>
  {if $action == "consultation"}
  <div class="float-end">
    <a href="index.php?p=admin_users&action=creer" class="btn btn-success"><i class="fa fa-plus-circle me-2"></i>Nouveau membre</a>
  </div>
  {/if}
  {if $action == "afficher"}
  <div class="float-end btn-group">
    <a href="index.php?p=admin_users" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des membres</a>
    <a href="index.php?p=admin_users&action=editer&id={$user.id}" class="btn btn-primary"><i class="fa fa-pen me-2"></i>Modifier</a>
    <span data-bs-toggle="modal" data-bs-target="#delete-cat-{$user.id}"class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</span>
  </div>
  <div class="modal fade" id="delete-cat-{$user.id}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer le membre</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Veux-tu vraiment supprimer le compte de {$user.prenom} {$user.nom} ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <a role="button" href="index.php?p=admin_users&action=supprimer&id={$user.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
        </div>
      </div>
    </div>
  </div>
  {/if}
  {if $action == "editer"}
  <div class="float-end btn-group">
    <a href="index.php?p=admin_users" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des membres</a>
    <a href="index.php?p=admin_users&action=afficher&id={$user.id}" class="btn btn-secondary"><i class="fa fa-eye me-2"></i>Afficher</a>
    <span data-bs-toggle="modal" data-bs-target="#delete-cat-{$user.id}"class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</span>
  </div>
  <div class="modal fade" id="delete-cat-{$user.id}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Supprimer le membre</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Veux-tu vraiment supprimer le compte de {$user.prenom} {$user.nom} ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <a role="button" href="index.php?p=admin_users&action=supprimer&id={$user.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
        </div>
      </div>
    </div>
  </div>
  {/if}
  {if $action == "creer"}
  <div class="float-end">
    <a href="index.php?p=admin_users" class="btn btn-secondary"><i class="fa fa-home me-2"></i>Liste des membres</a>
  </div>
  {/if}
</div>
<hr />

{if $action == "consultation"}
<div class="alert alert-success" role="alert">
  {count($users)} membres trouvés
</div>
{if count($users)}
<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Photo</th>
      <th>Identifiant</th>
      <th>Prénom</th>
      <th>Nom</th>
      <th>Surom</th>
      <th>Email</th>
      <th>Téléphone</th>
      <th>Date de naissance</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
{for $id = 0 to count($users)-1}
    <tr>
      <td>{$users.$id.id}</td>
      <td>{if $users.$id.photo}<img src="{$users.$id.photo}" class="img-thumbnail" style="max-height: 50px;"/>{/if}</td>
      <td>{$users.$id.login}</td>
      <td>{$users.$id.prenom}</td>
      <td>{$users.$id.nom}</td>
      <td>{$users.$id.surnom}</td>
      <td>{mailto address=$users.$id.email}</td>
      <td>{$users.$id.portable}</td>
      <td>{$users.$id.jour}/{$users.$id.mois}/{$users.$id.annee}</td>
      <td>
        <div class="btn-group" role="group">
        <a role="button" class="btn btn-secondary" href="index.php?p=admin_users&action=afficher&id={$users.$id.id}" title="Afficher"><i class="fa fa-eye"></i></a>
        <a role="button" class="btn btn-primary" href="index.php?p=admin_users&action=editer&id={$users.$id.id}" title="Modifier"><i class="fa fa-pen"></i></a>
        <span role="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-cat-{$users.$id.id}" title="Supprimer"><i class="fa fa-trash"></i></span>
        </div>
      </td>
    </tr>
    <div class="modal fade" id="delete-cat-{$users.$id.id}" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Supprimer le membre</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Veux-tu vraiment supprimer le compte de {$users.$id.prenom} {$users.$id.nom} ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <a role="button" href="index.php?p=admin_users&action=supprimer&id={$users.$id.id}" class="btn btn-danger"><i class="fa fa-trash me-2"></i>Supprimer</a>
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
    {if $user.photo}<img src="{$user.photo}" class="img-fluid shadow" alt="{$user.prenom} {$user.nom}"/>{/if}
  </div>
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body">
        <h5 class="card-title">{$user.prenom} {$user.nom}</h5>
        <div class="row">
        <p class="card-text col-md-4">
          <b>Identifiant</b><br />
          {$user.login}<br />
        </p>
        <p class="card-text col-md-4">
          <b>Email</b><br />
          {mailto address=$user.email}<br />
        </p>
        <p class="card-text col-md-4">
          <b>Téléphone</b><br />
          {$user.portable}<br />
        </p>
        <p class="card-text col-md-4">
          <b>Surnom</b><br />
          {$user.surnom}<br />
        </p>
        <p class="card-text col-md-4">
          <b>Date de naissance</b><br />
          {$user.jour}/{$user.mois}/{$user.annee}<br />
        </p>
        <p class="card-text col-md-4">
          <b>Adresse</b><br />
          {$user.adresse}<br />
        </p>
        <p class="card-text col-md-12">
          <b>Saisons</b><br />
          {for $i = -1 to $id_saison + 1}
          <span class="badge py-2 px-2 mb-2 {if $user.saison & (2 ** $i)}text-bg-success{else}text-bg-secondary{/if}">{2004+$i} - {2004+$i+1}</span>
          {/for}
        </p>
        <p class="card-text col-md-12">
          <b>Droits</b><br />
          {foreach $user.rights_array as $right}
          <span class="badge py-2 px-2 text-bg-primary">{$rights_list.$right}</span>
          {/foreach}
        </p>
        <p class="card-text col-md-6">
          <b>Afficher le nom</b><br />
          {$user.affichernom}<br />
        </p>
        <p class="card-text col-md-6">
          <b>Notification email</b><br />
          {$user.notif_email}<br />
        </p>
        </div>
      </div>
    </div>
  </div>
</div>
{/if}

{if $action == "editer" or $action == "creer"}
<div class="row">
  <div class="col-md-4">
    {if $user.photo}<img src="{$user.photo}" class="img-fluid shadow" alt="{$user.prenom} {$user.nom}"/>{/if}
  </div>
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-body">
      <form method="post" action="index.php?p=admin_users&action=enregistrer&id={$user.id}">
      <div class="row">
        <div class="mb-3 col-md-4">
          <label for="inputNom" class="form-label">Prénom</label>
          <input type="text" class="form-control" id="inputPrenom" name="prenom" value="{$user.prenom}">
        </div>
        <div class="mb-3 col-md-4">
          <label for="inputNom" class="form-label">Nom</label>
          <input type="text" class="form-control" id="inputNom" name="nom" value="{$user.nom}">
        </div>
        <div class="mb-3 col-md-4">
          <label for="inputSurnom" class="form-label">Surnom</label>
          <input type="text" class="form-control" id="inputSurnom" name="surnom" value="{$user.surnom}">
        </div>
        <div class="mb-3 col-md-6">
          <label for="inputIdentifiant" class="form-label">Identifiant</label>
          <input type="text" class="form-control" id="inputIdentifiant" name="login" value="{$user.login}">
        </div>
        <div class="mb-3 col-md-6">
          <label for="inputPassword" class="form-label">Mot de passe</label>
          <input type="text" class="form-control" id="inputPassword" name="password">
        </div>
        <div class="mb-3 col-md-6">
          <label for="inputEmail" class="form-label">Email</label>
          <input type="email" class="form-control" id="inputEmail" name="email" value="{$user.email}">
        </div>
        <div class="mb-3 col-md-6">
          <label for="inputPortable" class="form-label">Téléphone</label>
          <input type="text" class="form-control" id="inputPortable" name="portable" value="{$user.portable}">
        </div>
        <div class="mb-3 col-md-12">
          <label for="inputAdresse" class="form-label">Adresse</label>
          <textarea class="form-control" id="inputAdresse" name="adresse">{$user.adresse}</textarea>
        </div>
        <div class="mb-3 col-md-4">
          <label for="inputJour" class="form-label">Jour de naissance</label>
          <input type="text" class="form-control" id="inputJour" name="jour" value="{$user.jour}">
        </div>
        <div class="mb-3 col-md-4">
          <label for="inputMois" class="form-label">Mois de naissance</label>
          <input type="text" class="form-control" id="inputMois" name="mois" value="{$user.mois}">
        </div>
        <div class="mb-3 col-md-4">
          <label for="inputAnnee" class="form-label">Année de naissance</label>
          <input type="text" class="form-control" id="inputAnnee" name="annee" value="{$user.annee}">
        </div>
        <div class="mb-3 col-md-12">
          <label for="inputRights" class="form-label">Saisons</label>
          <div class="row">
          {for $i = -1 to $id_saison + 1}
          <div class="form-check form-switch col-md-3">
            <input class="form-check-input" type="checkbox" role="switch" name="saison_{$i}" id="saison_{$i}"{if $user.saison & (2 ** $i)} checked{/if} >         
            <label class="form-check-label" for="saison_{$i}">{2004+$i} - {2004+$i+1}</label>
          </div>
          {/for}
          </div>
        </div>
        <div class="mb-3 col-md-12">
          <label for="inputRights" class="form-label">Droits</label>
          <div class="row">
          {foreach $rights_list as $right_key => $right_label}
          <div class="form-check form-switch col-md-4">
            <input class="form-check-input" type="checkbox" role="switch" name="right_{$right_key}" id="right_{$right_key}"{if $right_key|in_array:$user.rights_array} checked{/if} >
            <label class="form-check-label" for="right_{$right_key}">{$right_label}</label>
          </div>
          {/foreach}
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
      </div>
    </div>
  </div>
</div>
{/if}
