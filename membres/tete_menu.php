<?
$aData = array(
	array("membres", "membres.php", "Membres", "Liste des membres")
	,array("infos", "infos.php", "Mes infos", "Modifier mes informations")
	,array("reservation", "reservation.php", "R&eacute;servations", "")
	,array("fichiers", "fichiers.php", "Fichiers", "")
	,array("dispos_s", "dispos.php", "Dispos spectacles", "")
	,array("dispos_e", "dispos.php?train=1", "Dispos entrainements", "")
	,array("dispos_st", "dispos_stats.php", "Statistiques", "")
	,array("bdd", "admin_bdd.php", "Données", "Base de donn&eacute;es")
	,array("sortie", "sortie.php", "Sortir", "Retour au site")
	);

?>

    <div id="menumembres" class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">Accueil</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
			<? foreach($aData as $v) { ?>
			<li class="<?=((basename($_SERVER['REQUEST_URI']) == $v[1])?'active':'')?>"><a href="<?=$v[1]?>"><?=$v[2]?></a></li>
			<? } ?>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
