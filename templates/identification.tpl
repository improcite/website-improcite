<h1>Espace réservé aux lapins</h1>

<form method="post" action="/?p=identification">

<div class="form-group input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
<input name="login" type="text" class="form-control" placeholder="Identifiant" required />
</div>

<div class="form-group input-group">
<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
<input name="password" type="password" class="form-control" placeholder="Mot de passe" required />
</div>

<div class="checkbox">
<label for="rememberme">
<input type="checkbox" id="rememberme" name="rememberme" checked value="1" />
Se rappeler de moi
</label>
</div>

<input type="hidden" name="backURL" value="{$backURL}" />
<input type="hidden" name="action" value="login" />

<div class="text-center">
<button type="submit" class="btn btn-success" >
M'identifier
</button>
</div>

<hr />

</form>

