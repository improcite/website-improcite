<h1>Rester en contact</h1>

<h2>R�seaux sociaux</h2>

<div class="row text-center">
<div class="col-md-6">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
	      js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box" data-href="http://www.facebook.com/improcite" data-colorscheme="dark" data-show-faces="true" data-stream="true" data-header="true"></div>
</div>

<div class="col-md-6">
<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/Improcite"  data-widget-id="409658841832235008">Tweets de @Improcite</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>

</div>

<h2>S&#39;abonner &agrave; la lettre d&#39;informations d&#39;Improcit&eacute;</h2>

<? afficher_inscription_newsletter(); ?>

<div class="badge">Vous pouvez vous d�sinscrire a tout moment</div>

<h2>Contact direct</h2>

<a role="button" class="btn btn-info btn-lg" href=# onClick="<?=$sMailTo?>"><i class="glyphicon glyphicon-envelope"></i> Contacter l'�quipe communication</a> 

<h2>Logo et mascotte</h2>

<div class="row text-center">
<div class="col-md-6">
<img src="http://improcite.com/images2/improcite-logo-med.png" class="img-thumbnail img-responsive" alt="Logo Improcit�" />
</div>
<div class="col-md-6">
<img src="http://improcite.com/images2/mascotte-transparent.png" class="img-thumbnail img-responsive" alt="Mascotte Improcit�" />
</div>
</div>

<h2>Nos amis</h2>

<div class="row">

<?
$requete_liens = fxQuery("SELECT * FROM impro_liens ORDER BY nom ASC");
while ( $resultat_liens = @mysql_fetch_array ( $requete_liens ) ) {

	$id = $resultat_liens[ "id" ] ;
	$lien = $resultat_liens[ "lien" ] ;
	$nom = $resultat_liens[ "nom" ] ;
	$description = affiche_texte ( $resultat_liens[ "description" ] ) ;
		
	# Affichage du surnom

	echo "<div class=\"col-md-4 text-center\">";
	echo "<h3><a href=\"$lien\" title=\"$nom\">$nom</a></h3>\n" ;
	echo "$description\n" ;
	
	$photo = "photos/liens/$id.jpg";
	if ( file_exists( $photo ) )
	{
		echo "<img class=\"img-responsive\" src=$photo>\n";
	}
	echo "</div>";
	
}
?>
</div>
