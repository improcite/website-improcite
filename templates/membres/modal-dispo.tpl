<div class="modal fade" tabindex="-1" id="{$idModal}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="post" action="update_dispo.php">
      <div class="modal-header">
        <h5 class="modal-title">Alors, dispo ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6>{$date.nom}</h6>
        <p>{$date.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"}<br />{$date.lnom}</p>
        
        <input type="radio" class="btn-check" name="dispo_pourcent" id="dispo_0_{$date.id}_{$membre_id}" autocomplete="off" value="0"{if $date.dispo_pourcent == 0} checked{/if}>
        <label class="btn btn-danger" for="dispo_0_{$date.id}_{$membre_id}"><i class="fa fa-circle-xmark me-3"></i>Non</label>

        <input type="radio" class="btn-check" name="dispo_pourcent" id="dispo_50_{$date.id}_{$membre_id}" autocomplete="off" value="50" {if $date.dispo_pourcent == 50 or !$date.dispo_pourcent} checked{/if}>
        <label class="btn btn-light" for="dispo_50_{$date.id}_{$membre_id}"><i class="fa fa-circle-question me-3"></i>Peut-être</label>

        <input type="radio" class="btn-check" name="dispo_pourcent" id="dispo_100_{$date.id}_{$membre_id}" autocomplete="off" value="100" {if $date.dispo_pourcent == 100} checked{/if}>
        <label class="btn btn-success" for="dispo_100_{$date.id}_{$membre_id}"><i class="fa fa-circle-check me-3"></i>Oui</label>

        <textarea name="dispo_commentaire" class="form-control my-4" placeholder="Une envie ou une excuse bidon ?">{$date.dispo_commentaire}</textarea>

        <input type="hidden" name="date_id" value="{$date.id}" />
        <input type="hidden" name="membre_id" value="{$membre_id}" />
        <input type="hidden" name="backURL" value="{$backURL}" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <input type="submit" class="btn btn-primary" value="Valider" />
      </div>
    </form>
    </div>
  </div>
</div>

