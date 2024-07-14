        <div id="sidebar"
             class="d-flex flex-column
                    flex-shrink-0
                    p-3 bg-dark
                    text-white offcanvas-md offcanvas-start">
            <a href="index.php"
               class="navbar-brand"><i class="fa fa-home me-2"></i>Accueil
            </a><hr>
            <ul class="mynav nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="index.php?p=fichiers">
                        <i class="fa-regular fa-file"></i>
                        Fichiers
                    </a>
                </li>

            </ul>
            <hr>
            <div class="d-flex">
                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{photo_membre id_membre={$membre.id} id_saison={$id_saison} path=".."}" alt="{$membre.prenom}" width="28" height="28" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">{$membre.prenom}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#"><i class="fa fa-user-ninja me-2"></i>Mon compte</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../"><i class="fa fa-map me-2"></i>Retour au site public</a></li>
                        <li><a class="dropdown-item" href="../?p=sortie"><i class="fa fa-door-open me-2"></i>Se déconnecter</a></li>
                    </ul>
                </div>

            </div>
        </div>
