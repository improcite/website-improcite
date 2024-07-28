<h3><i class="fa fa-handshake me-2"></i>Candidats pour la prochaine saison</h3>
<hr />
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
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.experience}">{$candidats.$id.experience|truncate}</span></td>
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.envie}">{$candidats.$id.envie|truncate}</span></td>
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.source}">{$candidats.$id.source|truncate}</span></td>
      <td><span data-bs-toggle="tooltip" data-bs-title="{$candidats.$id.disponibilite}">{$candidats.$id.disponibilite|truncate}</span></td>
    </tr>
{/for}
  </tbody>
</table>
</div>
{/if}
