<h3><i class="fa fa-key"></i> Mot de passe</h3>
<hr />

{if $result == "changepassword"}
<div class="alert alert-info" role="alert">
  Entre ton nouveau mot de passe pour le modifier
</div>
{/if}
{if $result == "nomatch"}
<div class="alert alert-warning" role="alert">
  Les mots de passe ne correspondent pas
</div>
{/if}
{if $result == "passwordchanged"}
<div class="alert alert-success" role="alert">
  Ton mot de passe a bien été changé
</div>
{/if}
{if $result == "passwordnotchanged"}
<div class="alert alert-danger" role="alert">
  Erreur lors du changement de ton mot de passe, retente ta chance !
</div>
{/if}

<div class="row mt-5 pb-3">
<div class="col-md-3"></div>
<div class="col-md-6">

<form method="post">

  <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-3 col-form-label">Email de connexion</label>
    <div class="col-sm-9">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{$membre.email}">
    </div>
  </div>
  <div class="row mb-3">
    <label for="inputPassword" class="col-sm-3 col-form-label">Nouveau mot de passe</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" id="inputPassword" name="password" required />
    </div>
  </div>
  <div class="row mb-3">
    <label for="inputPasswordConfirmation" class="col-sm-3 col-form-label">Confirmation du mot de passe</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" id="inputPasswordConfirmation" name="confirmpassword" required />
    </div>
  </div>
  <div class="text-center">
    <button type="submit" class="btn btn-success" >
      Modifier
    </button>
  </div>

</form>

</div>
<div class="col-md-3"></div>
</div>
