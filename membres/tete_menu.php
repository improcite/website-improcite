    <div id="menumembres" class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse" role="navigation">
          <div class="container">
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
                <li class="<?=((basename($_SERVER['REQUEST_URI']) == "membres.php")?'active':'')?>">
                  <a href="membres.php"><i class="glyphicon glyphicon-th-list"></i> Membres</a>
                </li>
                <li class="<?=((basename($_SERVER['REQUEST_URI']) == "infos.php")?'active':'')?>">
                  <a href="infos.php"><i class="glyphicon glyphicon-user"></i> Mon compte</a>
                </li>
                <li class="<?=((basename($_SERVER['REQUEST_URI']) == "reservation.php")?'active':'')?>">
                  <a href="reservation.php"><i class="glyphicon glyphicon-shopping-cart"></i> R&eacute;servations</a>
                </li>
                <li class="dropdown <?=( strstr( basename($_SERVER['REQUEST_URI']), "dispos") ?'active':'')?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-calendar"></i> Disponibilit&eacute;s <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="<?=((basename($_SERVER['REQUEST_URI']) == "dispos.php")?'active':'')?>">
                      <a href="dispos.php"><i class="glyphicon glyphicon-star"></i> Spectacles</a>
                    </li>
                    <li class="<?=((basename($_SERVER['REQUEST_URI']) == "dispos.php?train=1")?'active':'')?>">
                      <a href="dispos.php?train=1"><i class="glyphicon glyphicon-star-empty"></i> Entra&icirc;nements</a>
                    </li>
                    <li class="divider"></li>
                    <li class="<?=((basename($_SERVER['REQUEST_URI']) == "dispos_stats.php")?'active':'')?>">
                      <a href="dispos_stats.php"><i class="glyphicon glyphicon-stats"></i> Statistiques</a>
                    </li>
                  </ul>
                </li>
                <li class="<?=((basename($_SERVER['REQUEST_URI']) == "admin_bdd.php")?'active':'')?>">
                  <a href="admin_bdd.php"><i class="glyphicon glyphicon-wrench"></i> Donn&eacute;es</a>
                </li>
              </ul>
              <ul class="nav navbar-nav">
                <li><a href="sortie.php"><i class="glyphicon glyphicon-log-out"></i> Sortir</a></li> 
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div>
