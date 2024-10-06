<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-handshake me-2"></i>Candidats pour la prochaine saison</h3>
  <div class="float-end">
    {if $action == "imprimer"}
    <a href="?p=recrutements" class="btn btn-secondary"><i class="fa fa-table me-2"></i>Version normale</a>
    {else}
    <a href="?p=recrutements&action=imprimer" class="btn btn-secondary"><i class="fa fa-print me-2"></i>Version imprimable</a>
    {/if}
  </div>
</div>
<hr />

{if $action == "imprimer"}
{if count($candidats)}
{for $id = 0 to count($candidats)-1}
<h3>{$candidats.$id.prenom} {$candidats.$id.nom} - Né(e) le {$candidats.$id.datenaissance|date_format:"%d/%m/%Y"}</h3>
<p>Contact : {$candidats.$id.telephone} / {$candidats.$id.mail}</p>
<p>Expérience : {$candidats.$id.experience}</p>
<p>Envies : {$candidats.$id.envie}</p>
<p>Connaissance d'Improcité : {$candidats.$id.source}</p>
<p>Disponibilités : {$candidats.$id.disponibilite}</p>
<hr />
{/for}
{/if}
{else}
<div class="alert alert-success" role="alert">
  {count($candidats)} inscriptions reçues !
</div>
{if count($candidats)}
<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Inscription</th>
      <th>Nom</th>
      <th>Date de naissance</th>
      <th>Téléphone</th>
      <th>Adresse</th>
      <th>Mail</th>
      <th>Expérience</th>
      <th>Envies</th>
      <th>Improcité</th>
      <th>Disponibilités</th>
    </tr>
  </thead>
  <tbody>
{for $id = 0 to count($candidats)-1}
    <tr>
      <td>{$candidats.$id.date|date_format:"%d/%m/%Y"}</td>
      <td>{$candidats.$id.prenom} {$candidats.$id.nom}</td>
      <td>{$candidats.$id.datenaissance|date_format:"%d/%m/%Y"}</td>
      <td>{$candidats.$id.telephone}</td>
      <td>{$candidats.$id.adresse}</td>
      <td>{mailto address=$candidats.$id.mail}</td>
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.experience|escape}">{$candidats.$id.experience|truncate}</span></td>
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.envie|escape}">{$candidats.$id.envie|truncate}</span></td>
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.source|escape}">{$candidats.$id.source|truncate}</span></td>
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.disponibilite|escape}">{$candidats.$id.disponibilite|truncate}</span></td>
    </tr>
{/for}
  </tbody>
</table>
</div>
{/if}
{/if}
