<?php $baseUri = basename($_SERVER['REQUEST_URI']); ?>

    <div id="menumembres" class="navbar-wrapper">

      <div class="container">
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><i class="glyphicon glyphicon-home"></i>  Accueil</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="<?=(($baseUri == "calendrier.php")?'active':'')?>">
                  <a href="calendrier.php"><i class="glyphicon glyphicon-calendar"></i> Calendrier</a>
                </li>
                <li class="<?=(($baseUri == "membres.php")?'active':'')?>">
                  <a href="membres.php"><i class="glyphicon glyphicon-th-list"></i> Membres</a>
                </li>
                <li class="dropdown <?=( strstr( $baseUri, "dispos") ?'active':'')?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-calendar"></i> Disponibilités <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="<?=(($baseUri == "dispos.php")?'active':'')?>">
                      <a href="dispos.php"><i class="glyphicon glyphicon-star"></i> Spectacles</a>
                    </li>
                    <li class="<?=(($baseUri == "dispos.php?train=1")?'active':'')?>">
                      <a href="dispos.php?train=1"><i class="glyphicon glyphicon-star-empty"></i> Entra&icirc;nements</a>
                    </li>
                    <li class="divider"></li>
                    <li class="<?=(($baseUri == "dispos_stats.php")?'active':'')?>">
                      <a href="dispos_stats.php"><i class="glyphicon glyphicon-stats"></i> Statistiques</a>
                    </li>
                  </ul>
                </li>
                <li class="<?=(($baseUri == "reservation.php")?'active':'')?>">
                  <a href="reservation.php"><i class="glyphicon glyphicon-shopping-cart"></i> R&eacute;servations</a>
                </li>
                <li class="dropdown <?=(($baseUri == "admin_bdd.php" || $baseUri == "carousel.php" || $baseUri == "fichiers.php" || $baseUri == "recrutement.php")?'active':'')?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-wrench"></i> Admin <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="<?=(($baseUri == "recrutement.php")?'active':'')?>">
                      <a href="recrutement.php"><i class="fa fa-user-plus"></i> Recrutement</a>
                    </li>
		    <li class="<?=(($baseUri == "admin_bdd.php")?'active':'')?>">
		      <a href="admin_bdd.php"><i class="glyphicon glyphicon-list-alt"></i> Donn&eacute;es</a>
		    </li>
		    <li class="<?=(($baseUri == "carousel.php")?'active':'')?>">
		      <a href="carousel.php"><i class="glyphicon glyphicon-film"></i> Caroussel</a>
		    </li>
		    <li class="<?=(($baseUri == "fichiers.php")?'active':'')?>">
		      <a href="fichiers.php"><i class="glyphicon glyphicon-file"></i> Fichiers</a>
		    </li>
		  </ul>
                </li>				
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown <?=(($baseUri == "infos.php")?'active':'')?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php
                    $id = $_SESSION['id_impro_membre'];
                    $photo = "../photos/comediens/$currentSaisonBit/$id.jpg";
                    if (!file_exists($photo)) { $photo = "../photos/comediens/$id.jpg"; }
                    if (!file_exists($photo)) { $photo = "../photos/comediens/defaut.jpg"; }
                    ?>
                    <img src="<?=$photo?>" class="img" alt="<?=$aUserInfos['prenom']?>" style="max-height:22px;display:inline;margin:0;padding:0;margin-right:5px" />
                    <?php echo $aUserInfos['prenom'] ?>
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="<?=(($baseUri == "infos.php")?'active':'')?>">
                      <a href="infos.php"><i class="fa fa-user"></i> Mon compte</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="sortie.php"><i class="glyphicon glyphicon-log-out"></i> Sortir</a></li> 
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>
