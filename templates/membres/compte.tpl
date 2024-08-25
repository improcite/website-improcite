<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-user me-2"></i>Mon compte</h3>
  <a href="/index.php?p=membre&id={$membre.id}" target="_blank" class="btn btn-success float-end ms-3" type="button"><i class="fa fa-map me-2"></i>Voir sur le site public</a>
  {if $action == "consultation"}
  <a href="?p=compte&action=editer" class="btn btn-primary float-end" type="button"><i class="fa fa-pen me-2"></i>Modifier mes informations</a>
  {/if}
  {if $action == "editer"}
  <a href="?p=compte&action=consultation" class="btn btn-secondary float-end" type="button"><i class="fa fa-eye me-2"></i>Voir mes informations</a>
  {/if}
</div>
<hr />

{if $result == "infosupdated"}
<div class="alert alert-success" role="alert">
  Tes informations ont bien été modifiées
</div>
{/if}
{if $result == "infosnotupdated"}
<div class="alert alert-danger" role="alert">
  Erreur lors de la modification de tes informations
</div>
{/if}

{if $action == "consultation"}

<div class="card mb-3">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="{photo_membre id_membre={$membre.id} id_saison={$id_saison} path=".."}" class="img-fluid rounded-start" alt="Photo actuelle">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Informations principales</h5>
        <table class="table table-hover">
          <tbody>
            <tr>
              <th class="w-25"><i class="fa fa-user me-2"></i>Prénom et nom</th>
              <td>{$infos.prenom} {$infos.nom}</td>
            </tr>
            <tr>
              <th><i class="fa fa-mask me-2"></i>Surnom</th>
              <td>{$infos.surnom}</td>
            </tr>
            <tr>
              <th><i class="fa fa-envelope me-2"></i>Email</th>
              <td>{mailto address=$infos.email}</td>
            </tr>
            <tr>
              <th><i class="fa fa-phone me-2"></i>Téléphone</th>
              <td>{$infos.portable}</td>
            </tr>
            <tr>
              <th><i class="fa fa-cake me-2"></i>Date de naissance</th>
              <td>{$infos.jour}/{$infos.mois}/{$infos.annee}</td>
            </tr>
            <tr>
              <th><i class="fa fa-location-dot me-2"></i>Adresse</th>
              <td>{$infos.adresse|regex_replace:"/[\r\n]/" : "<br />"}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="card mb-3">
  <div class="card-header text-center"><h4>Ton parcours</h4></div>
  <div class="card-body row">
    {assign var=items value=['debut' => "Début dans l'improvisation", 'envie' => "Comment as-tu eu envie de faire de l'improvisation&nbsp;?", 'apport' => "Que t'apporte l'improvisation ?", 'debutimprocite' => "Ton arrivée à Improcité ?", 'improcite' => "Pour toi Improcité c'est quoi ?",'qualite' => "Qualité en impro", 'defaut' => "Défaut en impro"]}
    {foreach $items as $item => $label}
    <div class="col-md-4">
      <div class="mb-2 me-2 p-3 rounded border border-secondary">
      <h5>{$label}</h5>
      <p>{$infos.$item}</p>
      </div>
    </div>
   {/foreach}
  </div>
</div>
{/if}

{if $action == "editer"}

<form method="post" action="?p=compte">
<input type="hidden" name="action" value="modifier" />

<div class="card mb-3">
  <div class="card-header">
    Informations principales
  </div>
  <div class="card-body">

    <div class="row mb-3">
      <label for="inputPrenom" class="col-sm-2 col-form-label">Prénom</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputPrenom" name="prenom" value="{$infos.prenom}">
      </div>
    </div>

    <div class="row mb-3">
      <label for="inputNom" class="col-sm-2 col-form-label">Nom</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputNom" name="nom" value="{$infos.nom}">
      </div>
    </div>

    <div class="row mb-3">
      <label for="inputSurnom" class="col-sm-2 col-form-label">Surnom</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputSurnom" name="surnom" value="{$infos.surnom}">
      </div>
    </div>

    <div class="row mb-3">
      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="inputEmail" name="email" value="{$infos.email}">
      </div>
    </div>

    <div class="row mb-3">
      <label for="inputTelephone" class="col-sm-2 col-form-label">Téléphone</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputTelephone" name="portable" value="{$infos.portable}">
      </div>
    </div>

    <div class="row mb-3">
      <label for="inputJour" class="col-sm-2 col-form-label">Date de naissance (jour/mois/année)</label>
      <div class="col-sm-10">
        <div class="input-group">
        <input type="text" class="form-control" id="inputJour" name="jour" value="{$infos.jour}">
        <span class="input-group-text">/</span>
        <input type="text" class="form-control" id="inputMois" name="mois" value="{$infos.mois}">
        <span class="input-group-text">/</span>
        <input type="text" class="form-control" id="inputAnnee" name="annee" value="{$infos.annee}">
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <label for="inputAdresse" class="col-sm-2 col-form-label">Adresse</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="inputAdresse" name="adresse">{$infos.adresse}</textarea>
      </div>
    </div>

  </div>
</div>

<div class="card mb-3">
  <div class="card-header">
    Mon parcours
  </div>
  <div class="card-body">
    {assign var=items value=['debut' => "Début dans l'improvisation", 'envie' => "Comment as-tu eu envie de faire de l'improvisation&nbsp;?", 'apport' => "Que t'apporte l'improvisation ?", 'debutimprocite' => "Ton arrivée à Improcité ?", 'improcite' => "Pour toi Improcité c'est quoi ?",'qualite' => "Qualité en impro", 'defaut' => "Défaut en impro"]}
    {foreach $items as $item => $label}

    <div class="row mb-3">
      <label for="input{$item}" class="col-sm-2 col-form-label">{$label}</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="input{$item}" name="{$item}">{$infos.$item}</textarea>
      </div>
    </div>

   {/foreach}

  </div>
</div>

<input type="submit" value="Modifier mes information" class="btn btn-success">

</form>
{/if}
