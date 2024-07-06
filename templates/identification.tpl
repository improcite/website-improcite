<h1 class="text-center my-3"><i class="fa fa-mask"></i> Espace réservé aux lapins <i class="fa fa-carrot"></i></h1>

<div class="row mt-5 pb-3">
<div class="col-md-3"></div>
<div class="col-md-6">

<form method="post" action="/?p=identification">

  <div class="row mb-3">
    <label for="inputLogin" class="col-sm-3 col-form-label">Identifiant</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="inputLogin" name="login" required />
    </div>
  </div>
  <div class="row mb-3">
    <label for="inputPassword3" class="col-sm-3 col-form-label">Mot de passe</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" id="inputPassword" name="password" required />
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-sm-9 offset-sm-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="rememberme" name="rememberme" checked value="1" />
        <label class="form-check-label" for="rememberme">
          Se souvenir de moi
        </label>
      </div>
    </div>
  </div>

  <input type="hidden" name="backURL" value="{$backURL}" />
  <input type="hidden" name="action" value="login" />

  <div class="text-center">
    <button type="submit" class="btn btn-success" >
      M'identifier
    </button>
  </div>

</form>

</div>
<div class="col-md-3"></div>
</div>
