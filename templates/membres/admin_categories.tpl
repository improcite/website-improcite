<h3><i class="fa fa-label me-2"></i>Catégories</h3>
<hr />

{if $action == "consultation"}
<div class="alert alert-success" role="alert">
  {count($categories)} catégories trouvées
</div>
{if count($categories)}
<div class="table-responsive">
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Photo</th>
      <th class="w-25">Nom</th>
      <th class="w-50">Description</th>
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
      <td>{$categories.$id.description}</td>
      <td>{$categories.$id.publique}</td>
      <td><a type="button" class="btn btn-primary" href="index.php?p=admin_categories&action=modifier&id={$categories.$id.id}">Éditer</a> - Supprimer</td>
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
{/for}
  </tbody>
</table>
</div>
{/if}
{/if}
